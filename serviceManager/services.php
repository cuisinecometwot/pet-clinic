<?php
require_once('../utils/connect.php');

$services = array();
$sql = "SELECT * FROM service_list";

if ($result = pg_query($conn, $sql)) {
    // Loop through each row in the result set
    while ($row = pg_fetch_assoc($result)) {
        $services[] = $row;
    }
    pg_free_result($result);
} else {
    echo "Error: " . pg_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evSXhuddledayAHT4wXauhxBV+wbVNPGCqVZxqh2kQ6z6sRW1z9NgzH1t4z4HfqrgoiixhISOzEGjfwEoqYlmF7KjGO8ALCXaRuNiXk8w/" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-3">

    <h1>Services</h1>

    <?php
    if (count($services) > 0) {
        foreach ($services as $service) {
            echo '<div class="card mb-3">';
            echo '<div class="card-header">';
            echo '<h4>' . htmlspecialchars($service['service_name']) . '</h4>';
            echo '</div>';
            echo '<div class="card-body">';
            echo '<p class="card-text">' . htmlspecialchars($service['description']) . '</p>';
            echo '<p class="card-text"><b>Cost:</b> VND ' . htmlspecialchars($service['cost']) . ' per day</p>';
            
            // Edit button to initiate edit form
            echo '<a href="Dashboard.php?p=serviceManager/edit_service&object_id=' . urlencode($service['sid']) . '" class="btn btn-primary">Edit</a>';

            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No services found!";
    }
    ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-OgwbZS7/BXzYhFOT11tTvwVHcwjK1Q2vRLzVMEcyCsRUjGjy6gljCqTnx95yGTca1z" crossorigin="anonymous"></script>
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
