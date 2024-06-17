<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pet Hotel Registration</title>
</head>
<body>
  <h1>Register Your Pet for Hotel Stay</h1>
  <form action="../../controllers/book_hotel.php" method="POST" id="petHotelForm">
    <div class="form-group">
      <label for="petSelect">Choose Pet:</label>
      <select class="form-control" id="petSelect" name="pet_id" required>
        <option value="">--Choose Pet--</option>
        <?php
          include '../../utils/connect.php';
          require '../../models/Pet.php';
          foreach ($pets as $pet) {
            $petId = $pet->getPetID();
            $petName = $pet->getName();
            echo "<option value='$petId'>$petName</option>";
          }
        ?>
      </select>
    </div>
    <div class="form-group">
      <label for="checkInDate">Check-In Date:</label>
      <input type="date" class="form-control" id="checkInDate" name="check_in_date" required>
    </div>
    <div class="form-group">
      <label for="checkOutDate">Check-Out Date:</label>
      <input type="date" class="form-control" id="checkOutDate" name="check_out_date" required>
    </div>
    <div class="form-group">
      <label for="specialNeeds">Special Needs (Optional):</label>
      <textarea class="form-control" id="specialNeeds" name="special_needs" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Register Pet</button>
  </form>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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



