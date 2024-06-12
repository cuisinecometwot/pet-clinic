<h3>Add Hotel Room</h3>
<form action="hotel/add_room.php" method="POST">
    <div class="form-group">
        <label for="roomDescription">Description</label>
        <input type="text" class="form-control" id="roomDescription" name="roomDescription" required>
    </div>
    <div class="form-group">
        <label for="roomOccupied">Occupied</label>
        <select class="form-control" id="roomOccupied" name="roomOccupied" required>
            <option value="false">No</option>
            <option value="true">Yes</option>
        </select>
    </div>
    <div class="form-group">
        <label for="roomCondition">Condition</label>
        <select class="form-control" id="roomCondition" name="roomCondition" required>
            <option value="Good">Good</option>
            <option value="Decent">Decent</option>
            <option value="Unusable">Unsuable</option>
        </select>
    </div>
    <div class="form-group">
        <label for="roomImageLink">Image Link</label>
        <input type="text" class="form-control" id="roomImageLink" name="roomImageLink" required>
    </div>
    <button type="submit" class="btn btn-primary">+ Add</button>
</form>
<?php
include '../utils/connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all necessary POST variables are set
    if(isset($_POST['roomDescription']) && isset($_POST['roomOccupied']) && isset($_POST['roomCondition']) && isset($_POST['roomImageLink'])) {
        // Retrieve and sanitize form inputs
        $roomDescription = pg_escape_string($conn, $_POST['roomDescription']);
        $roomOccupied = ($_POST['roomOccupied'] === 'true') ? 't' : 'f'; // Convert to 't' or 'f' for PostgreSQL boolean
        $roomCondition = pg_escape_string($conn, $_POST['roomCondition']);
        $roomImageLink = pg_escape_string($conn, $_POST['roomImageLink']);

        // Prepare and execute query
        $query = "INSERT INTO hotel_room (description, occupied, condition, image_link) VALUES ($1, $2, $3, $4)";
        $result = pg_prepare($conn, "insert_hotel_room", $query);
        $result = pg_execute($conn, "insert_hotel_room", array($roomDescription, $roomOccupied, $roomCondition, $roomImageLink));

        if ($result) {
            header("Location: /Dashboard.php?p=hotel/hotelManager");
            exit();
        } else {
            echo "Error: Could not add the room.";
        }
    } else {
        echo "Error: Missing form data.";
    }
}
?>

