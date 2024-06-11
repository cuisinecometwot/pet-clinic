<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<!-- Service Description -->
	<div class="container">
		<?php
		include 'models/Service.php';
      echo '<div>';
      echo '<h2>' . $services[0]->getName() . ' (Price: VND' . $services[0]->getCost() . ')</h2>';
      echo '<p>' . $services[0]->getDescription() . '</p>';
      echo '</div>';
      echo '<div>';
      echo '<h2>' . $services[1]->getName() . ' (Price: VND' . $services[1]->getCost() . ')</h2>';
      echo '<p>' . $services[1]->getDescription() . '</p>';
      echo '</div>';
		?>		
	</div>
	<!-- Booking Form -->
	<div class="container">
		<h2>Đặt lịch sử dụng dịch vụ cho thú cưng</h2>
    	<form action="controllers/bookingController.php" method="POST">
      	<div class="form-group">
        		<label for="petSelect">Chọn thú cưng:</label>
        		<select class="form-control" id="petSelect" name="petSelect" required>
        			<option value="" disabled selected>--Choose Pet--</option>
        			<?php
      				include 'models/Pet.php';
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
        		<input type="date" class="form-control" id="dateSelect" name="dateSelect" required>
      	</div>
      	<div class="form-group">
        		<label for="timeSelect">Chọn giờ:</label>
				<select class="form-control" id="timeSelect" name="timeSelect" required>
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
      	<div class="form-group">
      		<label for="health-check">Dịch vụ khám sức khỏe</label>
         	<input type="checkbox" id="health-check" name="health-check" checked> 
         </div>
         <div>
         	<label for="spa">Dịch vụ làm đẹp</label>
         	<input type="checkbox" id="spa" name="spa"> 
         </div>
      	<button type="submit" class="btn btn-success">Đặt lịch</button>
   	</form>
    	<!-- div id="calendar" class="mt-5"></div -->

  	</div>
</body>
</html>