<h3>Add Hotel Room</h3>
<form action="hotel/add_room.php" method="POST">
    <div class="form-group">
        <label for="roomSize">Room Size</label>
        <select class="form-control" id="roomSize" name="roomSize" required>
            <option value="Small">Small</option>
            <option value="Medium">Medium</option>
            <option value="Large">Large</option>
        </select>
    </div>
    <div class="form-group">
        <label for="roomOccupied">Occupied</label>
        <select class="form-control" id="roomOccupied" name="roomOccupied" required>
            <option value="false">No</option>
            <option value="true">Yes</option>
        </select>
    </div>
    <div class="form-group">
        <label for="roomPrice">Price</label>
        <input type="number" class="form-control" id="roomPrice" name="roomPrice" min="1" required>
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
    if(isset($_POST['roomSize']) && isset($_POST['roomOccupied']) && isset($_POST['roomPrice']) && isset($_POST['roomImageLink'])) {
        // Retrieve and sanitize form inputs
        $roomSize = pg_escape_string($conn, $_POST['roomSize']);
        $roomOccupied = ($_POST['roomOccupied'] === 'true') ? 't' : 'f'; // Convert to 't' or 'f' for PostgreSQL boolean
        $roomPrice = (int) $_POST['roomPrice'];
        $roomImageLink = pg_escape_string($conn, $_POST['roomImageLink']);

        // Prepare and execute query
        $query = "INSERT INTO hotel_room (size, occupied, price, image_link) VALUES ($1, $2, $3, $4)";
        $result = pg_prepare($conn, "insert_hotel_room", $query);
        $result = pg_execute($conn, "insert_hotel_room", array($roomSize, $roomOccupied, $roomPrice, $roomImageLink));

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

