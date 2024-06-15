<?php
// here is controllers/
include '../utils/connect.php';
include '../models/Service.php';
include '../models/Record.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$petId = $_POST['petSelect'];
	$date = $_POST['dateSelect'];
	$time = $_POST['timeSelect'];
echo $petId;
	$hasHealthCheck = isset($_POST['health-check']);
	$hasSpa = isset($_POST['spa']);

	$currentTime = strtotime(date('Y-m-d H:i'));
	$bookingTime = strtotime("$date $time");
	if ($bookingTime < $currentTime) 
	{
		$_SESSION['message'] = "Error: Booking date and time cannot be in the past.";
  		exit;
	}
	// TODO: Check before INSERT: No insert if a request for the same service exists on the same day.
	// Solution: Install trigger in DB
	if ($hasHealthCheck) 
	{
		//$healthRecord = new HealthRecord($petId, $date, $time, $cost);
		$query = "INSERT INTO health_record(petID, date, time, cost) VALUES ($1, $2, $3, $4)";
		$result = pg_prepare($conn, "insert_health_record", $query);
  		$result = pg_execute($conn, "insert_health_record", array((int)$petId, $date, $time, $services[0]->getCost()));
		$_SESSION['message'] = "Booking successfully";
	}
	if ($hasSpa) 
	{
		//$spaRecord = new BeautyService($petId, $date, $time, $cost);
		$query = "INSERT INTO beauty_service(petID, date, time, cost) VALUES ($1, $2, $3, $4)";
		$result = pg_prepare($conn, "insert_beauty_service", $query);
  		$result = pg_execute($conn, "insert_beauty_service", array((int)$petId, $date, $time, $services[1]->getCost()));
		$_SESSION['message'] = "Booking successfully";
	}
	header("Location: ../Dashboard.php?p=booking");
}
?>