<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking Records</title>
    <link rel="stylesheet" href="hotel/style.css">
</head>
<body>
    <div class="container">
        <h1>Hotel Booking Records</h1>        
        <!-- Filtering and sorting options -->
        <div>
        <form id="filterForm" action="bookingManager/filter.php" method="GET">
                <input type="hidden" name="object_type" value="hotel_record"> 
                <label for="idSearch">Search pet ID:</label>
                <input type="text" id="idSearch" name="idSearch">                
                <label for="filter">Sort:</label>
                <select id="filter" name="filter">
                    <option value="id">ID</option>
                    <option value="finished">Finished</option>
                    <option value="not_finished">Unfinished</option>
                </select>
                <button type="submit">Apply Filters</button>
            </form>
        </div>
    </div>

    <?php
    include '../utils/connect.php';

    // Hotel Records Query
    $sql = "SELECT * FROM hotel_record";

    $idSearch = isset($_SESSION['idSearch']) ? $_SESSION['idSearch'] : '';
    $filter = isset($_SESSION['filter']) ? $_SESSION['filter'] : '';
    if(!empty($idSearch)) {
      $sql .= " WHERE petid = $idSearch";
    }
    switch ($filter) {
        case 'finished':
            $sql .= " ORDER BY finished DESC";
            break;
        case 'not_finished':
            $sql .= " ORDER BY finished ASC";
            break;
        case 'id':
        default:
            $sql .= " ORDER BY recordid";
            break;
    }

    $hotelResult = pg_query($conn, $sql);
    if (!$hotelResult) {
        echo "Error retrieving hotel records: " . pg_error($conn);
        exit;
    }
    unset($_SESSION['idSearch']); 
    unset($_SESSION['filter']);
    ?>

    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Records</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjD BrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>


<table class="table table-striped">
  <thead>
    <tr>
      <th>#ID</th>
      <th>Pet ID</th>
      <th>Check-in</th>
      <th>Check-out</th>
      <th>Notes</th>
      <th>Cost</th>
      <th>Finished</th>
      <th>Payment</th>
    </tr>
  </thead>
  <tbody>
  <?php while ($row = pg_fetch_assoc($hotelResult)) : ?>
    <tr onclick="window.location='Dashboard.php?p=bookingManager/hotel_record_modify&object_id=<?php echo $row['recordid']; ?>'" style="cursor: pointer;">
        <td><?php echo $row['recordid']; ?></td>
        <td><?php echo $row['petid']; ?></td>
        <td><?php echo $row['check_in']; ?></td>
        <td><?php echo $row['check_out']; ?></td>
        <td><?php echo $row['notes']; ?></td>
        <td><?php echo $row['cost']; ?></td>
        <td><?php echo $row['finished'] === 't' ? 'Yes' : 'No'; ?></td>
        <td><?php echo $row['payment'] === 't' ? 'Paid' : 'Not Paid'; ?></td>
    </tr>
<?php endwhile; ?>
  </tbody>
</table>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>

    <?php 
    $message = null;
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']); 
    }
    if ($message): 
        $alertClass = (strpos($message, 'Error') === 0) ? 'alert-danger' : 'alert-success';
    ?>
        <div class="alert <?php echo $alertClass; ?>" role="alert">
          <?php echo $message; ?>
        </div>
    <?php endif; ?>
</body>
</html>
