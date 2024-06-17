<?php
session_start();

// Update session variables with form data
if(isset($_GET['idSearch'])) {
    $_SESSION['idSearch'] = $_GET['idSearch'];
}

if(isset($_GET['filter'])) {
    $_SESSION['filter'] = $_GET['filter'];
}

// Redirect back to Dashboard.php
header("Location: ../Dashboard.php?p=hotel/hotelManager");
exit();
?>
