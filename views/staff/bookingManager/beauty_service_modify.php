<?php
include '../../../utils/connect.php';

// Check if record ID is provided via session
if (isset($_SESSION['object_id'])) {
    $recordId = intval($_SESSION['object_id']);
} else {
    echo "Error: Record ID not provided.";
    exit();
}

// Retrieve beauty service details from the database
$query = "SELECT * FROM beauty_service WHERE serviceID = $1";
$result = pg_prepare($conn, "get_beauty_service", $query);
$result = pg_execute($conn, "get_beauty_service", array($recordId));

if ($row = pg_fetch_assoc($result)) {
    $petId = $row['petid'];
    $date = $row['date'];
    $time = $row['time'];
    $serviceType = $row['service_type'];
    $serviceProvider = $row['staffid'];
    $notes = $row['notes'];
    $cost = $row['cost'];
    $finished = ($row['finished'] === 't') ? true : false;
    $payment = ($row['payment'] === 't') ? true : false;
} else {
    echo "Error: Beauty service record not found.";
    exit();
}

// Retrieve pet image URL from another table (assuming this functionality is needed)
$queryPet = "SELECT image_link FROM pet WHERE petid = $1";
$resultPet = pg_prepare($conn, "get_pet_image", $queryPet);
$resultPet = pg_execute($conn, "get_pet_image", array($petId));

if ($rowPet = pg_fetch_assoc($resultPet)) {
    $petImageLink = $rowPet['image_link'];
}

// Handle form submission to update beauty service information
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve updated values from the form
    $newServiceType = $_POST['service_type'];
    $newServiceProvider = $_POST['service_provider'] !== '' ? $_POST['service_provider'] : null;
    $newNotes = $_POST['notes'];
    $newFinished = $_POST['finished'] === 'TRUE' ? 't' : 'f';
    $newPayment = $_POST['payment'] === 'TRUE' ? 't' : 'f';

    // Update the beauty service information in the database
    $updateQuery = "UPDATE beauty_service SET 
                    service_type = $1, 
                    staffid = $2, 
                    notes = $3, 
                    finished = $4, 
                    payment = $5 
                    WHERE serviceID = $6";
    $updateResult = pg_prepare($conn, "update_beauty_service", $updateQuery);
    $updateResult = pg_execute($conn, "update_beauty_service", array(
        $newServiceType,
        $newServiceProvider,
        $newNotes,
        $newFinished,
        $newPayment,
        $recordId
    ));

    if ($updateResult) {
        echo "Beauty service information updated successfully.";
        header("Location: ../../Dashboard.php?p=staff/bookingManager/spaManager");
        exit();
    } else {
        echo "Error updating beauty service information.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Beauty Service</title>
    <link rel="stylesheet" href="staff/bookingManager/style.css">
</head>
<body>
    <div class="container">
        <div class="details">
            <h2>Edit Beauty Service</h2>
            <form method="POST" action="staff/bookingManager/beauty_service_modify.php">
                <div class="form-group">
                    <label for="record_id">Service ID:</label><br>
                    <input type="text" id="record_id" name="record_id" value="<?php echo $recordId; ?>" readonly><br>
                </div>
                <div class="form-group">
                    <label for="pet_id">Pet ID:</label><br>
                    <input type="text" id="pet_id" name="pet_id" value="<?php echo $petId; ?>" readonly><br>
                </div>
                <div class="form-group">
                    <label for="date">Date:</label><br>
                    <input type="text" id="date" name="date" value="<?php echo $date; ?>" readonly><br>
                </div>
                <div class="form-group">
                    <label for="time">Time:</label><br>
                    <input type="text" id="time" name="time" value="<?php echo $time; ?>" readonly><br>
                </div>
                <div class="form-group">
                    <label for="service_type">Service Type:</label><br>
                    <input type="text" id="service_type" name="service_type" value="<?php echo htmlspecialchars($serviceType); ?>"><br>
                </div>
                <div class="form-group">
                    <label for="service_provider">Service Provider:</label><br>
                    <input type="text" id="service_provider" name="service_provider" value="<?php echo htmlspecialchars($serviceProvider); ?>"><br>
                </div>
                <div class="form-group">
                    <label for="notes">Notes:</label><br>
                    <textarea id="notes" name="notes"><?php echo htmlspecialchars($notes); ?></textarea><br>
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
                <input type="submit" value="Update Beauty Service">
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
