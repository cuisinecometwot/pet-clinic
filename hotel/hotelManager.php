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
    <form id="filterForm" action="hotel/filter.php" method="GET">
        <label for="idSearch">Search Room ID:</label>
        <input type="text" id="idSearch" name="idSearch">                
        <label for="filter">Sort:</label>
        <select id="filter" name="filter">
            <option value="id">ID</option>
            <option value="occupied">Occupied</option>
            <option value="available">Available</option>
        </select>

        <button type="submit">Apply Filters</button>
    </form>
</div>


        <!-- Room grid layout -->
        <div class="room-grid">
            <?php
                include '../utils/connect.php';
                require '../models/HotelRoom.php';
                $currentPage = isset($_SESSION['current_page']) ? $_SESSION['current_page'] : 1;
                $perPage = 8; // Number of rooms per page

                // Get filter values from the session
                $idSearch = isset($_SESSION['idSearch']) ? $_SESSION['idSearch'] : '';
                $filter = isset($_SESSION['filter']) ? $_SESSION['filter'] : '';

                // Calculate offset for pagination
                $offset = ($currentPage - 1) * $perPage;

                // Default SQL query
                $sql = "SELECT * FROM hotel_room";
                
                // Search by Room ID
                if(!empty($idSearch)) {
                    $sql .= " WHERE id = $idSearch";
                }

                // Sorting
                switch($filter) {
                    case 'occupied':
                        $sql .= " ORDER BY occupied DESC"; 
                        break;
                    case 'available':
                        $sql .= " ORDER BY occupied ASC"; 
                        break;
                    case 'id':
                        $sql .= " ORDER BY id"; 
                        break;
                    default:
                        $sql .= " ORDER BY id";
                }

                // Limit and Offset
                $sql .= " LIMIT $perPage OFFSET $offset";

                $result = pg_query($conn, $sql);

                $num = pg_num_rows($result);
                if ($num > 0) {
                    echo "<div class='room-grid'>";
                    $counter = 0;
                    while ($row = pg_fetch_assoc($result)) {
                        $room = new HotelRoom($row['id'], $row['description'], $row['occupied'], $row['condition'], $row['image_link']);
                        echo "<a href='Dashboard.php?p=hotel/modify_room&object_id=" . $room->getId() . "' style='text-decoration: none; color: inherit;'>";
                        echo "<div class='room-card'>";
                        echo "<img src='" . ($room->getImageLink() ? $room->getImageLink() : 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fstatic.vecteezy.com%2Fsystem%2Fresources%2Fpreviews%2F004%2F141%2F669%2Foriginal%2Fno-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg&f=1&nofb=1&ipt=bce4d230e8665ab4deabd81fbe46e59f1fb848eecb7e217d6f8094a4e5c319fd&ipo=images') . "' alt='Room Image' class='room-image'>";
                        echo "<h3>Room no: " . $room->getId() . "</h3>";
                        echo "<p>Condition: " . $room->getCondition() . "</p>";
                        echo "<p>" . ($room->isOccupied() ? 'Occupied' : 'Available') . "</p>";
                        echo "</div>";
                        echo "</a>";
                        $counter++;
                        if ($counter % 4 == 0) { // Start a new row after every 4 rooms
                            echo "<div class='clear'></div>"; // Clear float
                        }
                        if ($counter % 8 == 0) { 
                            echo "</div>"; // Close the current room-grid div
                            echo "<div class='clear'></div>"; // Clear float
                            echo "<div class='room-grid'>"; // Start a new room-grid div for the next page
                        }
                    }
                    echo "</div>";

                    // Pagination Links
                    $totalRooms = pg_fetch_row(pg_query($conn, "SELECT COUNT(*) FROM hotel_room"))[0];
                    $totalPages = ceil($totalRooms / $perPage); // Calculate total pages

                    if ($totalPages > 1) {
                        echo "<ul class='pagination'>";
                        if ($currentPage > 1) { // Previous page link
                            echo "<li class='page-item'><a class='page-link' href='?p=hotel/hotelManager&page=" . ($currentPage - 1) . "'>Previous</a></li>";
                        }

                        for ($i = 1; $i <= $totalPages; $i++) { // Page number links
                            $activeClass = ($currentPage == $i) ? "active" : "";
                            echo "<li class='page-item " . $activeClass . "'><a class='page-link' href='?p=hotel/hotelManager&page=" . $i . "'>" . $i . "</a></li>";
                        }

                        if ($currentPage < $totalPages) { // Next page link
                            echo "<li class='page-item'><a class='page-link' href='?p=hotel/hotelManager&page=" . ($currentPage + 1) . "'>Next</a></li>";
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