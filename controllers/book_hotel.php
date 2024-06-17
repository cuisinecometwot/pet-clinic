<?php
session_start();
include '../utils/connect.php';
include '../models/Profile.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['pet_id'], $_POST['check_in_date'], $_POST['check_out_date'])) {
        $petID = intval($_POST['pet_id']);
        $checkInDate = pg_escape_string($conn, $_POST['check_in_date']);
        $checkOutDate = pg_escape_string($conn, $_POST['check_out_date']);
        $specialNeeds = isset($_POST['special_needs']) ? pg_escape_string($conn, $_POST['special_needs']) : null;

        // Query the cost of the Pet Hotel service
        $serviceQuery = "SELECT cost FROM service_list WHERE service_name = 'Pet Hotel'";
        $serviceResult = pg_query($conn, $serviceQuery);

        if ($serviceRow = pg_fetch_assoc($serviceResult)) {
            $dailyCost = intval($serviceRow['cost']);
        } else {
            $_SESSION['message'] = "Error: Service cost not found.";
            header("Location: ../views/Dashboard.php?p=owner/petHotel");
            exit();
        }

        // Calculate the number of days between check-in and check-out dates
        $checkInDateTime = new DateTime($checkInDate);
        $checkOutDateTime = new DateTime($checkOutDate);
        $interval = $checkInDateTime->diff($checkOutDateTime);
        $numDays = $interval->days;

        // Check if there's already a booking for the same petID and overlapping dates
        $queryOverlapCheck = "
            SELECT COUNT(*) AS count_overlap
            FROM hotel_record
            WHERE petID = $1
            AND check_in <= $2
            AND check_out >= $3
        ";
        $resultOverlapCheck = pg_prepare($conn, "check_overlap", $queryOverlapCheck);
        $resultOverlapCheck = pg_execute($conn, "check_overlap", array($petID, $checkOutDate, $checkInDate));

        $overlapRow = pg_fetch_assoc($resultOverlapCheck);
        $countOverlap = intval($overlapRow['count_overlap']);

        if ($countOverlap > 0) {
            $_SESSION['message'] = "Error: This pet already has a booking for overlapping dates.";
            header("Location: ../views/Dashboard.php?p=owner/petHotel");
            exit();
        }

        // Check for room availability for each day between check-in and check-out
        $roomQuery = "SELECT COUNT(*) AS room_count FROM hotel_room";
        $roomResult = pg_query($conn, $roomQuery);
        $roomRow = pg_fetch_assoc($roomResult);
        $totalRooms = intval($roomRow['room_count']);

        $currentDate = clone $checkInDateTime;
        $isFull = false;

        for ($i = 0; $i <= $numDays; $i++) {
            $dateString = $currentDate->format('Y-m-d');

            $availabilityQuery = "
                SELECT COUNT(*) AS occupied_count
                FROM hotel_record
                WHERE check_in <= $1 AND check_out >= $1
            ";
            $availabilityResult = pg_prepare($conn, "check_availability", $availabilityQuery);
            $availabilityResult = pg_execute($conn, "check_availability", array($dateString));

            if ($availabilityRow = pg_fetch_assoc($availabilityResult)) {
                $occupiedCount = intval($availabilityRow['occupied_count']);
                if ($occupiedCount >= $totalRooms + 1) {
                    $_SESSION['message'] = "Error: The hotel is fully booked on " . $currentDate->format('Y-m-d') . ".";
                    header("Location: ../views/Dashboard.php?p=owner/petHotel");
                    exit();
                }
            }

            $currentDate->modify('+1 day');
        }

        // Calculate the total cost
        $totalCost = ($numDays+1) * $dailyCost;

        // Insert the data into the hotel_record table
        $query = "INSERT INTO hotel_record (petID, check_in, check_out, notes, cost) VALUES ($1, $2, $3, $4, $5)";
        $result = pg_prepare($conn, "insert_hotel_record", $query);
        $result = pg_execute($conn, "insert_hotel_record", array($petID, $checkInDate, $checkOutDate, $specialNeeds, $totalCost));

        if ($result) {
            $_SESSION['message'] = "Registering successfully";
            header("Location: ../views/Dashboard.php?p=owner/petHotel");
            exit();
        } else {
            $_SESSION['message'] = "Error registering pet for hotel stay.";
            header("Location: ../views/Dashboard.php?p=owner/petHotel");
            exit();
        }
    } else {
        $_SESSION['message'] = "Error: Missing required form data.";
        header("Location: ../views/Dashboard.php?p=owner/petHotel");
        exit();
    }
}
?>
