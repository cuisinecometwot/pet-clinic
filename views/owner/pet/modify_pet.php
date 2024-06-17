<?php
include '../../../utils/connect.php';

// Check if pet ID is provided via session
if (isset($_SESSION['object_id'])) 
{
	$petId = intval($_SESSION['object_id']); 
} 
else 
{
    echo "Error: Pet ID not provided.";
    exit();
}

// Retrieve pet details from the database
$query = "SELECT * FROM pet WHERE petid = $1";
$result = pg_prepare($conn, "get_pet", $query);
$result = pg_execute($conn, "get_pet", array($petId));

if($row = pg_fetch_assoc($result)) 
{
    $petName = $row['name'];
    $petAge = $row['age'];
    $petGender = $row['gender'];
    $petSpecies = $row['species'];
    $petNote = $row['note'];
    $petImageLink = $row['image_link'];
} 
else 
{
    echo "Error: Pet not found.";
    exit();
}

// Handle form submission to update pet information
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Retrieve updated values from the form
    $newName = $_POST['pet_name'];
    $newAge = $_POST['pet_age'];
    $newGender = $_POST['pet_gender'];
    $newSpecies = $_POST['pet_species'];
    $newNote = $_POST['pet_note'];
    $newImageLink = $_POST['pet_image_link']; // Added to retrieve updated image link
    
    // Update the pet information in the database
    $updateQuery = "UPDATE pet SET name = $1, age = $2, gender = $3, species = $4, note = $5, image_link = $6 WHERE petid = $7";
    $updateResult = pg_prepare($conn, "update_pet", $updateQuery);
    $updateResult = pg_execute($conn, "update_pet", array($newName, $newAge, $newGender, $newSpecies, $newNote, $newImageLink, $petId));
    
    if ($updateResult) 
    {
        echo "Pet information updated successfully.";
         header("Location: ../../Dashboard.php?p=owner/pet/myPets");
         exit();
    } 
    else 
    {
        echo "Error updating pet information.";
    }
}
    
// Health Records Query
$healthQuery = "SELECT hr.recordID, hr.petID, hr.date, hr.time, p.name AS veterinarian, hr.med_instruction, hr.diet_instructions, hr.additional_instructions, hr.cost, hr.finished, hr.payment
                FROM health_record hr
                LEFT JOIN profile p ON hr.staffid = p.uid
                WHERE hr.petID = $1";

$healthStmt = pg_prepare($conn, "get_health_records", $healthQuery);
$healthResult = pg_execute($conn, "get_health_records", array($petId));

if (!$healthResult) {
    echo "Error retrieving health records: " . pg_last_error($conn);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pet Details</title>
    <link rel="stylesheet" href="owner/pet/style.css"> 
</head>
<body>
    <div class="container">
        <div class="pet-details">
            <h2>Edit Pet Details</h2>
            <form method="POST" action="owner/pet/modify_pet.php">
                <div class="form-group">
                    <label for="pet_id">Pet ID:</label><br>
                    <input type="text" id="pet_id" name="pet_id" value="<?php echo $petId; ?>" readonly><br>
                </div>
                <div class="form-group">
                    <label for="pet_name">Name:</label><br>
                    <input type="text" id="pet_name" name="pet_name" value="<?php echo htmlspecialchars($petName); ?>"><br>
                </div>
                <div class="form-group">
                    <label for="pet_age">Age:</label><br>
                    <input type="text" id="pet_age" name="pet_age" value="<?php echo $petAge; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="pet_gender">Gender:</label><br>
                    <input type="text" id="pet_gender" name="pet_gender" value="<?php echo htmlspecialchars($petGender); ?>"><br>
                </div>
                <div class="form-group">
                    <label for="pet_species">Species:</label><br>
                    <input type="text" id="pet_species" name="pet_species" value="<?php echo htmlspecialchars($petSpecies); ?>"><br>
                </div>
                <div class="form-group">
                    <label for="pet_note">Note:</label><br>
                    <textarea id="pet_note" name="pet_note"><?php echo htmlspecialchars($petNote); ?></textarea><br>
                </div>
                <div class="form-group">
                    <label for="pet_image_link">Image Link:</label><br>
                    <input type="text" id="pet_image_link" name="pet_image_link" value="<?php echo htmlspecialchars($petImageLink); ?>"><br>
                </div>
                <input type="submit" value="Update Pet Information">
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
    <!-- Display Health Records -->
    <div class="container mt-5">
        <h3>Health Records</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Pet ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Veterinarian</th>
                    <th>Med Instruction</th>
                    <th>Diet</th>
                    <th>Additional instructions</th>
                    <th>Cost</th>
                    <th>Finished</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = pg_fetch_assoc($healthResult)) : ?>
                    <tr>
                        <td><?php echo $row['recordid']; ?></td>
                        <td><?php echo $row['petid']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['time']; ?></td>
                        <td><?php echo $row['veterinarian']; ?></td>
                        <td><?php echo $row['med_instruction']; ?></td>
                        <td><?php echo $row['diet_instructions']; ?></td>
                        <td><?php echo $row['additional_instructions']; ?></td>
                        <td><?php echo $row['cost']; ?></td>
                        <td><?php echo $row['finished'] === 't' ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['payment'] === 't' ? 'Paid' : 'Not Paid'; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>



