<?php
// here is controllers/
include '../utils/connect.php';
include '../models/Service.php';
include '../models/Record.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$petId = $_POST['petSelect'];
	$date = $_POST['dateSelect'];
	$time = $_POST['timeSelect'];

	$hasHealthCheck = isset($_POST['health-check']);
	$hasSpa = isset($_POST['spa']);

	$currentTime = strtotime(date('Y-m-d H:i'));
	$bookingTime = strtotime("$date $time");
	if ($bookingTime < $currentTime) 
	{
  		echo "Error: Booking date and time cannot be in the past.";
  		exit;
	}
	
	$cost = 20000;
	if ($hasHealthCheck) 
	{
		echo "OK1";
		$healthRecord = new HealthRecord($petId, $date, $time, $cost);
	}
	if ($hasSpa) 
	{
		echo "OK2";
		$spaRecord = new BeautyService($petId, $date, $time, $cost);
		
	}
	//header("Location: ../Dashboard.php");
}
?>