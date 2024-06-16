<?php
require_once('../utils/connect.php');
if (isset($_SESSION['object_id'])) 
{
	$sid = intval($_SESSION['object_id']); 
} 
else 
{
    echo "Error: service ID not provided.";
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "GET" ) {

    // Escape and prepare the SQL query
    $sql = "SELECT * FROM service_list WHERE sid = $1";
    $result = pg_prepare($conn, "get_service", $sql);
    $result = pg_execute($conn, "get_service", array($sid));

    if ($result) {
        if (pg_num_rows($result) == 1) {
            $service = pg_fetch_assoc($result);
            pg_free_result($result);
        } else {
            echo "Service not found!";
            exit();
        }
    } else {
        echo "Error: " . pg_last_error($conn);
        exit();
    }
} else {
    echo "Invalid request!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evSXhuddledayAHT4wXauhxBV+wbVNPGCqVZxqh2kQ6z6sRW1z9NgzH1t4z4HfqrgoiixhISOzEGjfwEoqYlmF7KjGO8ALCXaRuNiXk8w/" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-3">

    <h1>Edit Service</h1>

    <form action="controllers/update_service.php" method="post">
        <input type="hidden" name="sid" value="<?php echo htmlspecialchars($service['sid']); ?>">
        <div class="mb-3">
            <label for="service_name" class="form-label">Service Name</label>
            <input type="text" class="form-control" id="service_name" name="service_name" value="<?php echo htmlspecialchars($service['service_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($service['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="cost" class="form-label">Cost (VND per day)</label>
            <input type="number" class="form-control" id="cost" name="cost" value="<?php echo htmlspecialchars($service['cost']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Service</button>
    </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-OgwbZS7/BXzYhFOT11tTvwVHcwjK1Q2vRLzVMEcyCsRUjGjy6gljCqTnx95yGTca1z" crossorigin="anonymous"></script>
</body>
</html>
