<?php
include '../../../utils/connect.php';
include '../../../models/Record.php';

// Hotel Records Query
$profile_id = $_SESSION['profile_id'];
$hotelQuery = "SELECT * FROM hotel_record WHERE petID IN (SELECT petID FROM pet WHERE ownerID = $profile_id)";
$hotelResult = pg_query($conn, $hotelQuery);
if (!$hotelResult) {
  echo "Error retrieving hotel records: " . pg_error($conn);
  exit;
}
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

<h2>Hotel Records</h2>
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
      <tr>
        <td><?php echo $row['recordid']; ?></td>
        <td><?php echo $row['petid']; ?></td>
        <td><?php echo $row['check_in']; ?></td>
        <td><?php echo $row['check_out']; ?></td>
        <td><?php echo $row['notes']; ?></td>
        <td><?php echo $row['cost']; ?></td>
        <td><?php echo $row['finished'] === 't' ? 'Yes' : 'No'; ?></td>
        <td>
            <?php if ($row['payment'] === 't') : ?>
                Paid
            <?php else : ?>
                <a href="Dashboard.php?p=owner/payment&object_id=<?php echo $row['recordid']; ?>&object_type=hotel_record" style="text-decoration: none; color: inherit;">
                    Not Paid
                </a>
            <?php endif; ?>
        </td>
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