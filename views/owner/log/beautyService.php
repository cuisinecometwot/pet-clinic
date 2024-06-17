<?php
include '../../../utils/connect.php';
include '../../../models/Record.php';

$profile_id = $_SESSION['profile_id'];

$beautyServiceQuery = "
    SELECT 
        bs.serviceID, 
        bs.petID, 
        bs.date, 
        bs.time, 
        p.name AS service_provider, 
        bs.service_type, 
        bs.notes, 
        bs.cost, 
        bs.finished, 
        bs.payment
    FROM 
        beauty_service bs
    LEFT JOIN 
        profile p ON bs.staffID = p.uid
    WHERE 
        bs.petID IN (SELECT petID FROM pet WHERE ownerID = $profile_id)
";

$beautyResult = pg_query($conn, $beautyServiceQuery);
if (!$beautyResult) {
    echo "Error retrieving beauty services: " . pg_error($conn);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beauty Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDBrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>

<h2>Beauty Services</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#ID</th>
            <th>Pet ID</th>
            <th>Date</th>
            <th>Time</th>
            <th>Type</th>
            <th>Staff</th>
            <th>Notes</th>
            <th>Cost</th>
            <th>Finished</th>
            <th>Payment</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = pg_fetch_assoc($beautyResult)) : ?>
    <tr>
        <td><?php echo $row['serviceid']; ?></td>
        <td><?php echo $row['petid']; ?></td>
        <td><?php echo $row['date']; ?></td>
        <td><?php echo $row['time']; ?></td>
        <td><?php echo $row['service_type']; ?></td>
        <td><?php echo $row['service_provider']; ?></td>
        <td><?php echo $row['notes']; ?></td>
        <td><?php echo $row['cost']; ?></td>
        <td><?php echo $row['finished'] === 't' ? 'Yes' : 'No'; ?></td>
        <td>
            <?php if ($row['payment'] === 't') : ?>
                Paid
            <?php else : ?>
                <a href="Dashboard.php?p=owner/payment&object_id=<?php echo $row['serviceid']; ?>&object_type=beauty_service" style="text-decoration: none; color: inherit;">
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