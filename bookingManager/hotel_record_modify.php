<?php
include '../utils/connect.php';

// Check if record ID is provided via session
if(isset($_SESSION['object_id'])) {
    $recordId = intval($_SESSION['object_id']); 
} else {
    echo "Error: Record ID not provided.";
    exit();
}

// Retrieve hotel record details from the database
$query = "SELECT * FROM hotel_record WHERE recordID = $1";
$result = pg_prepare($conn, "get_hotel_record", $query);
$result = pg_execute($conn, "get_hotel_record", array($recordId));

if($row = pg_fetch_assoc($result)) {
    $petId = $row['petid'];
    $checkIn = $row['check_in'];
    $checkOut = $row['check_out'];
    $notes = $row['notes'];
    $cost = $row['cost'];
    $finished = ($row['finished'] === 't') ? true : false;
    $payment = ($row['payment'] === 't') ? true : false;
} else {
    echo "Error: Hotel record not found.";
    exit();
}

// Retrieve pet image URL from another table
$queryPet = "SELECT image_link FROM pet WHERE petid = $1";
$resultPet = pg_prepare($conn, "get_pet_image", $queryPet);
$resultPet = pg_execute($conn, "get_pet_image", array($petId));

if($rowPet = pg_fetch_assoc($resultPet)) {
    $petImageLink = $rowPet['image_link'];
} 

// Handle form submission to update hotel record information
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve updated values from the form
    $newFinished = $_POST['finished'];
    $newPayment = $_POST['payment'];
    
    // Update the hotel record information in the database
    $updateQuery = "UPDATE hotel_record SET finished = $1, payment = $2 WHERE recordID = $3";
    $updateResult = pg_prepare($conn, "update_hotel_record", $updateQuery);
    $updateResult = pg_execute($conn, "update_hotel_record", array($newFinished, $newPayment, $recordId));
    
    if ($updateResult) {
        echo "Hotel record information updated successfully.";
        header("Location: /Dashboard.php?p=bookingManager/hotelRecordManager"); 
        exit();
    } else {
        echo "Error updating hotel record information.";
        
    }
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hotel Record</title>
    <link rel="stylesheet" href="bookingManager/style.css"> 
</head>
<body>
    <div class="container">
        <div class="details">
            <h2>Edit Hotel Record</h2>
            <form method="POST" action="bookingManager/hotel_record_modify.php">
                <div class="form-group">
                    <label for="record_id">Record ID:</label><br>
                    <input type="text" id="record_id" name="record_id" value="<?php echo $recordId; ?>" readonly><br>
                </div>
                <div class="form-group">
                    <label for="pet_id">Pet ID:</label><br>
                    <input type="text" id="pet_id" name="pet_id" value="<?php echo $petId; ?>" readonly><br>
                </div>
                <div class="form-group">
                    <label for="check_in">Check-in Date:</label><br>
                    <input type="text" id="check_in" name="check_in" value="<?php echo $checkIn; ?>" readonly><br>
                </div>
                <div class="form-group">
                    <label for="check_out">Check-out Date:</label><br>
                    <input type="text" id="check_out" name="check_out" value="<?php echo $checkOut; ?>" readonly><br>
                </div>
                <div class="form-group">
                    <label for="notes">Notes:</label><br>
                    <textarea id="notes" name="notes" readonly><?php echo htmlspecialchars($notes); ?></textarea><br>
                </div>
                <div class="form-group">
                    <label for="cost">Cost:</label><br>
                    <input type="text" id="cost" name="cost" value="<?php echo $cost; ?>" readonly><br>
                </div>
                <div class="form-group">
                    <label for="finished">Finished:</label><br>
                    <select id="finished" name="finished">
                        <option value="TRUE" <?php echo $finished ? 'selected' : ''; ?>>Yes</option>
                        <option value="FALSE" <?php echo !$finished ? 'selected' : ''; ?>>No</option>
                    </select><br>
                </div>
                <div class="form-group">
                    <label for="payment">Payment:</label><br>
                    <select id="payment" name="payment">
                        <option value="TRUE" <?php echo $payment ? 'selected' : ''; ?>>Paid</option>
                        <option value="FALSE" <?php echo !$payment ? 'selected' : ''; ?>>Not Paid</option>
                    </select><br>
                </div>
                <input type="submit" value="Update Hotel Record">
            </form>
        </div>
        <div class="pet-image">
            <?php if (!empty($petImageLink)) : ?>
                <img src="<?php echo $petImageLink; ?>" alt="Pet Image">
            <?php else : ?>
                <p>No image available</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
