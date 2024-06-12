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
        
        <!-- Add Room button -->
        <a href="Dashboard.php?p=hotel/add_room" class="btn btn-primary">Add Room</a>

        <!-- Filtering and sorting options -->
        <div>
            <label for="priceFilter">Filter by Price:</label>
            <select id="priceFilter">
                <option value="lowToHigh">Low to High</option>
                <option value="highToLow">High to Low</option>
            </select>

            <label for="sizeFilter">Filter by Size:</label>
            <select id="sizeFilter">
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="large">Large</option>
            </select>
        </div>

        <!-- Room grid layout -->
        <div class="room-grid">
        <?php
include '../utils/connect.php';
require '../models/HotelRoom.php';
$currentPage = isset($_SESSION['current_page']) ? $_SESSION['current_page'] : 1;
$perPage = 10; // Number of rooms per page

// Calculate offset for pagination
$offset = ($currentPage - 1) * $perPage;

$sql = "SELECT * FROM hotel_room LIMIT $1 OFFSET $2";
$result = pg_prepare($conn, "all_rooms", $sql);
$result = pg_execute($conn, "all_rooms", [$perPage, $offset]);

$num = pg_num_rows($result);
if ($num > 0) {
    echo "<div class='room-grid'>";
    $counter = 0;
    while ($row = pg_fetch_assoc($result)) {
        $room = new HotelRoom($row['id'], $row['size'], $row['occupied'], $row['price'], $row['image_link']);
        echo "<div class='room-card'>";
        echo "<img src='" . ($room->getImageLink() ? $room->getImageLink() : 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fstatic.vecteezy.com%2Fsystem%2Fresources%2Fpreviews%2F004%2F141%2F669%2Foriginal%2Fno-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg&f=1&nofb=1&ipt=bce4d230e8665ab4deabd81fbe46e59f1fb848eecb7e217d6f8094a4e5c319fd&ipo=images') . "' alt='Room Image' class='room-image'>";
        echo "<h3>Room Size: " . $room->getSize() . "</h3>";
        echo "<p>Price: $" . $room->getPrice() . "</p>";
        echo "<p>" . ($room->isOccupied() ? 'Occupied' : 'Available') . "</p>";
        echo "</div>";
        $counter++;
        if ($counter % 5 == 0) { // Start a new row after every 5 rooms
            echo "<div class='clear'></div>"; // Clear float
        }
    }
    echo "</div>";

    // Pagination Links
    $totalRooms = pg_fetch_row(pg_query($conn, "SELECT COUNT(*) FROM hotel_room"))[0];
    $totalPages = ceil($totalRooms / $perPage); // Calculate total pages

    if ($totalPages > 1) {
        echo "<ul class='pagination'>";
        if ($currentPage > 1) { // Previous page link
            echo "<li class='page-item'><a class='page-link' href='?p=myRooms&page=" . ($currentPage - 1) . "'>Previous</a></li>";
        }

        for ($i = 1; $i <= $totalPages; $i++) { // Page number links
            $activeClass = ($currentPage == $i) ? "active" : "";
            echo "<li class='page-item " . $activeClass . "'><a class='page-link' href='?p=myRooms&page=" . $i . "'>" . $i . "</a></li>";
        }

        if ($currentPage < $totalPages) { // Next page link
            echo "<li class='page-item'><a class='page-link' href='?p=myRooms&page=" . ($currentPage + 1) . "'>Next</a></li>";
        }
        echo "</ul>";
    }
} else {
    echo "No rooms found.";
}
?>
        </div>
    </div>
</body>
</html>
