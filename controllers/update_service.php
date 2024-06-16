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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_name = pg_escape_string($conn, $_POST['service_name']);
    $description = pg_escape_string($conn, $_POST['description']);
    $cost = pg_escape_string($conn, $_POST['cost']);

    $sql = "UPDATE service_list SET service_name = $1, description = $2, cost = $3 WHERE sid = $4";
    $result = pg_prepare($conn, "update_service", $sql);
    $result = pg_execute($conn, "update_service", array($service_name, $description, $cost,$sid));

    if ($result) {
        $_SESSION['message'] = 'Service updated successfully.';
    } else {
        $_SESSION['message'] = 'Error: Failed to update service.';
    }
} else {
    $_SESSION['message'] = 'Error: Invalid request method.';
}
header("Location: ../Dashboard.php?p=serviceManager/services");
exit();
?>
