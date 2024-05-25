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
        		<?php ?>
        		</select>
      	</div>
      	<div class="form-group">
        		<label for="dateSelect">Chọn ngày:</label>
        		<input type="date" class="form-control" id="dateSelect" required>
      	</div>
      	<div class="form-group">
        		<label for="timeSelect">Chọn giờ:</label>
				<select class="form-control" id="timeSelect" required>
        	
        		</select>
      	</div>
      	<button type="submit" class="btn btn-primary">Đặt lịch</button>
   	</form>

    	<div id="calendar" class="mt-5"></div>

    	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    	<script src="pet-appointment.js"></script>
  	</div>
</body>
</html>
