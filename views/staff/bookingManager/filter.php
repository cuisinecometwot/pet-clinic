<?php
include '../../../utils/connect.php';

// Check if object_type is not set in the session
if (!isset($_GET['object_type'])) {
    echo "Error: Missing object information.";
    exit();
}
$objectType = $_GET['object_type'];

// Determine the redirect URL based on object_type
if ($objectType === 'health_record') {
    $redirectUrl = '../../Dashboard.php?p=staff/bookingManager/healthServiceManager';
} elseif ($objectType === 'beauty_service') {
    $redirectUrl = '../../Dashboard.php?p=staff/bookingManager/spaManager';
} elseif ($objectType === 'hotel_record') {
    $redirectUrl = '../../Dashboard.php?p=staff/bookingManager/hotelRecordManager';
} else {
    $redirectUrl = '../Dashboard.php?p=myProfile';
    $_SESSION['message'] = "Error: Invalid object type.";
    header("Location: $redirectUrl");
    exit();
}

// Update session variables with form data if they are set
if (isset($_GET['idSearch'])) {
    $_SESSION['idSearch'] = $_GET['idSearch'];
}

if (isset($_GET['filter'])) {
    $_SESSION['filter'] = $_GET['filter'];
}

// Redirect to the determined URL
header("Location: $redirectUrl");
exit();
?>
