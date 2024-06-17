<?php
include '../../../utils/connect.php';

if (isset($_SESSION['object_id'])) {
    $roomId = intval($_SESSION['object_id']);
} else {
    echo "Error: Room ID not provided.";
    exit();
}

$query = "SELECT * FROM hotel_room WHERE id = $1";
$result = pg_prepare($conn, "get_hotel_room", $query);
$result = pg_execute($conn, "get_hotel_room", array($roomId));

if ($row = pg_fetch_assoc($result)) {
    $roomDescription = $row['description'];
    $roomPetID = $row['petid'];
    $roomCondition = $row['condition'];
    $roomImageLink = $row['image_link'];
} else {
    echo "Error: Room not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Hotel</title>
    <link rel="stylesheet" href="hotel/style.css">
</head>
<body>
    <div class="container">
        <h1>Pet Hotel</h1>
        <h3>Hotel Room no <?php echo $roomId; ?></h3>
        <form action="staff/hotel/modify_room.php" method="POST">
            <input type="hidden" name="roomId" value="<?php echo $roomId; ?>">
            <div class="form-group">
                <label for="roomDescription">Description</label>
                <input type="text" class="form-control" id="roomDescription" name="roomDescription" required value="<?php echo $roomDescription; ?>">
            </div>
            <div class="form-group">
                <label for="roomPetID">Occupant</label>
                <input type="text" class="form-control" id="roomPetID" name="roomPetID" value="<?php echo $roomPetID; ?>">
            </div>
            <div class="form-group">
                <label for="roomCondition">Condition</label>
                <select class="form-control" id="roomCondition" name="roomCondition" required>
                    <option value="Good" <?php if ($roomCondition == 'Good') echo 'selected'; ?>>Good</option>
                    <option value="Decent" <?php if ($roomCondition == 'Decent') echo 'selected'; ?>>Decent</option>
                    <option value="Unusable" <?php if ($roomCondition == 'Unusable') echo 'selected'; ?>>Unusable</option>
                </select>
            </div>
            <div class="form-group">
                <label for="roomImageLink">Image Link</label>
                <input type="text" class="form-control" id="roomImageLink" name="roomImageLink" required value="<?php echo $roomImageLink; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Modify Room</button>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['roomId'], $_POST['roomDescription'], $_POST['roomPetID'], $_POST['roomCondition'], $_POST['roomImageLink'])) {
            $roomId = intval($_POST['roomId']);
            $roomDescription = $_POST['roomDescription'];
            $roomPetID = $_POST['roomPetID'] !== '' ? $_POST['roomPetID'] : null;
            $roomCondition = $_POST['roomCondition'];
            $roomImageLink = $_POST['roomImageLink'];

            $query = "UPDATE hotel_room SET description = $1, petID = $2, condition = $3, image_link = $4 WHERE id = $5";
            $result = pg_prepare($conn, "update_hotel_room", $query);
            $result = pg_execute($conn, "update_hotel_room", array($roomDescription, $roomPetID, $roomCondition, $roomImageLink, $roomId));

            if ($result) {
                // Redirect back to dashboard if update successful
                header("Location: ../../Dashboard.php?p=staff/hotel/hotelManager");
                exit();
            } else {
                echo "Error updating room.";
            }
        } else {
            echo "Error: Missing form data.";
        }
    }
    ?>
</body>
</html>
