<?php
include 'utils/connect.php';
include 'models/Pet.php';
include_once 'models/Service.php';
include_once 'models/Record.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$petId = $_POST['petSelect'];
	$date = $_POST['dateSelect'];
	$time = $_POST['timeSelect'];

	echo $hasHealthCheck = isset($_POST['health-check']); // Check if health-check is checked
	echo $hasSpa = isset($_POST['spa']); // Check if spa is checked

	$currentTime = strtotime(date('Y-m-d H:i'));
	$bookingTime = strtotime("$date $time");
	if ($bookingTime < $currentTime) 
	{
  		echo "Error: Booking date and time cannot be in the past.";
  		exit;
	}
	include 'utils/displayErrors.php';
	$cost = 20000;
	if ($hasHealthCheck) 
	{
  		$healthRecord = new HealthRecord($petId, $date, $time, $cost);
  		var_dump($healthRecord);
	}
	if ($hasSpa) 
	{
		$spaRecord = new BeautyService($petId, $date, $time, $cost);
		var_dump($spaRecord);
	}
	header("Location: Dashboard.php");
}
?>