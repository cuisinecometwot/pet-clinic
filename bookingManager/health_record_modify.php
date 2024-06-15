<?php
include '../utils/connect.php';

// Check if record ID is provided via session
if (isset($_SESSION['object_id'])) 
{
    $recordId = intval($_SESSION['object_id']);
} 
else 
{
    echo "Error: Record ID not provided.";
    exit();
}

// Retrieve health record details from the database
$query = "SELECT * FROM health_record WHERE recordid = $1";
$result = pg_prepare($conn, "get_health_record", $query);
$result = pg_execute($conn, "get_health_record", array($recordId));

if ($row = pg_fetch_assoc($result)) 
{
    $petId = $row['petid'];
    $date = $row['date'];
    $time = $row['time'];
    $veterinarian = $row['veterinarian'];
    $medInstruction = $row['med_instruction'];
    $dietInstructions = $row['diet_instructions'];
    $additionalInstructions = $row['additional_instructions'];
    $cost = $row['cost'];
    $finished = ($row['finished'] === 't') ? true : false;
    $payment = ($row['payment'] === 't') ? true : false;
} 
else 
{
    echo "Error: Health record not found.";
    exit();
}

// Retrieve pet image URL from another table
$queryPet = "SELECT image_link FROM pet WHERE petid = $1";
$resultPet = pg_prepare($conn, "get_pet_image", $queryPet);
$resultPet = pg_execute($conn, "get_pet_image", array($petId));

if ($rowPet = pg_fetch_assoc($resultPet)) {
    $petImageLink = $rowPet['image_link'];
}

// Handle form submission to update health record information
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve updated values from the form
    $newVeterinarian = $_POST['veterinarian'];
    $newMedInstruction = $_POST['med_instruction'];
    $newDietInstructions = $_POST['diet_instructions'];
    $newAdditionalInstructions = $_POST['additional_instructions'];
    $newFinished = $_POST['finished'] === 'TRUE' ? 't' : 'f';
    $newPayment = $_POST['payment'] === 'TRUE' ? 't' : 'f';

    // Update the health record information in the database
    $updateQuery = "UPDATE health_record SET 
                    veterinarian = $1, 
                    med_instruction = $2, 
                    diet_instructions = $3, 
                    additional_instructions = $4, 
                    finished = $5, 
                    payment = $6 
                    WHERE recordid = $7";
    $updateResult = pg_prepare($conn, "update_health_record", $updateQuery);
    $updateResult = pg_execute($conn, "update_health_record", array(
        $newVeterinarian,
        $newMedInstruction,
        $newDietInstructions,
        $newAdditionalInstructions,
        $newFinished,
        $newPayment,
        $recordId
    ));

    if ($updateResult) 
    {
        echo "Health record information updated successfully.";
        header("Location: ../Dashboard.php?p=bookingManager/healthServiceManager");
        exit();
    } else 
    {
    	
        echo "Error updating health record information.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Health Record</title>
    <link rel="stylesheet" href="bookingManager/style.css">
</head>
<body>
    <div class="container">
        <div class="details">
            <h2>Edit Health Record</h2>
            <form method="POST" action="bookingManager/health_record_modify.php">
                <div class="form-group">
                    <label for="record_id">Record ID:</label><br>
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
                    <label for="veterinarian">Veterinarian:</label><br>
                    <input type="text" id="veterinarian" name="veterinarian" value="<?php echo htmlspecialchars($veterinarian); ?>"><br>
                </div>
                <div class="form-group">
                    <label for="med_instruction">Medical Instructions:</label><br>
                    <textarea id="med_instruction" name="med_instruction"><?php echo htmlspecialchars($medInstruction); ?></textarea><br>
                </div>
                <div class="form-group">
                    <label for="diet_instructions">Diet Instructions:</label><br>
                    <textarea id="diet_instructions" name="diet_instructions"><?php echo htmlspecialchars($dietInstructions); ?></textarea><br>
                </div>
                <div class="form-group">
                    <label for="additional_instructions">Additional Instructions:</label><br>
                    <textarea id="additional_instructions" name="additional_instructions"><?php echo htmlspecialchars($additionalInstructions); ?></textarea><br>
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
                <input type="submit" value="Update Health Record">
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
