<?php
include '../utils/connect.php';
if(isset($_SESSION['object_id'])) {
    $roomId = intval($_SESSION['object_id']); 
} else {
    echo "Error: Room ID not provided.";
    exit();
}

$query = "SELECT * FROM hotel_room WHERE id = $1";
$result = pg_prepare($conn, "get_hotel_room", $query);
$result = pg_execute($conn, "get_hotel_room", array($roomId));

if($row = pg_fetch_assoc($result)) {
    $roomDescription = $row['description'];
    $roomOccupied = $row['occupied'];
    $roomCondition = $row['condition'];
    $roomImageLink = $row['image_link'];
} else {
    echo "Error: Room not found.";
    exit();
}
?>

<h3>Hotel Room no <?php echo $roomId; ?></h3>
<form action="hotel/modify_room.php" method="POST" onsubmit="return validateForm()">
    <input type="hidden" name="roomId" value="<?php echo $roomId; ?>">
    <div class="form-group">
        <label for="roomDescription">Description</label>
        <input type="text" class="form-control" id="roomDescription" name="roomDescription" required value="<?php echo $roomDescription; ?>">
    </div>
    <div class="form-group">
        <label for="roomOccupied">Occupied</label>
        <select class="form-control" id="roomOccupied" name="roomOccupied" required>
            <option value="false" <?php if ($roomOccupied == 'false') echo 'selected'; ?>>No</option>
            <option value="true" <?php if ($roomOccupied == 'true') echo 'selected'; ?>>Yes</option>
        </select>
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
</form

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['roomId'], $_POST['roomDescription'], $_POST['roomOccupied'], $_POST['roomCondition'], $_POST['roomImageLink'])) {
        // Process form data here
        $roomId = intval($_POST['roomId']);
        $roomDescription = $_POST['roomDescription'];
        $roomOccupied = $_POST['roomOccupied'];
        $roomCondition = $_POST['roomCondition'];
        $roomImageLink = $_POST['roomImageLink'];
        
        // Perform necessary database updates here
        $query = "UPDATE hotel_room SET description = $1, occupied = $2, condition = $3, image_link = $4 WHERE id = $5";
        $result = pg_prepare($conn, "update_hotel_room", $query);
        $result = pg_execute($conn, "update_hotel_room", array($roomDescription, $roomOccupied, $roomCondition, $roomImageLink, $roomId));
        
        if ($result) {
            // Redirect back to dashboard if update successful
            header("Location: /Dashboard.php?p=hotel/hotelManager");
            exit();
        } else {
            echo "Error updating room.";
        }
    } else {
        echo "Error: Missing form data.";
    }
}
?>

