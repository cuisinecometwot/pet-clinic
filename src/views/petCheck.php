<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<div class="container">
		<h1>Đặt lịch khám cho thú cưng</h1>
    	<form id="appointmentForm">
      	<div class="form-group">
        		<label for="petSelect">Chọn thú cưng:</label>
        		<select class="form-control" id="petSelect" required>
        		<?php
      		include '../models/Pet.php';
      		var_dump($pets);
      		foreach ($pets as $pet) 
      		{
        			$petId = $pet->getPetID(); // Access pet ID from the Pet object
        			$petName = $pet->getName(); // Access pet name from the Pet object
        			echo "<option value='$petId'>$petName</option>";
      		}
      		?>
        		</select>
      	</div>
      	<div class="form-group">
        		<label for="dateSelect">Chọn ngày:</label>
        		<input type="date" class="form-control" id="dateSelect" required>
      	</div>
      	<div class="form-group">
        		<label for="timeSelect">Chọn giờ:</label>
				<select class="form-control" id="timeSelect" required>
        		<?php
      		$startTime = "08:00"; // Adjust start time as needed
      		$endTime = "18:00"; // Adjust end time as needed
      		$interval = 30; // Interval between time options in minutes

      		$currentTime = strtotime($startTime);
      		while ($currentTime <= strtotime($endTime)) 
      		{
        			$timeOption = date('H:i', $currentTime);
        			echo "<option value='$timeOption'>$timeOption</option>";
        			$currentTime += $interval * 60; // Increment time by the interval
      		}
      		?>
        		</select>
      	</div>
      	<button type="submit" class="btn btn-primary">Đặt lịch</button>
   	</form>
		<?php include 'petCheckController.php';?>
    	<div id="calendar" class="mt-5"></div>

    	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    	<script src="pet-appointment.js"></script>
  	</div>
</body>
</html>
