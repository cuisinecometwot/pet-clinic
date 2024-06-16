<?php
include '../utils/connect.php'; 
require '../models/Profile.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone_number = htmlspecialchars(trim($_POST['phone_number']));
    
    if (empty($name) || empty($email) || empty($phone_number)) {
        $_SESSION['message'] = 'Please fill in all required fields.';
        header("Location: ../Dashboard.php?p=myProfile"); 
        exit();
    }
    
    $profile_id = $_SESSION['profile_id']; 
    $updateQuery = "UPDATE profile SET name = $1, email = $2, phone = $3 WHERE uid = $4";
    $updateParams = [$name, $email, $phone_number, $profile_id];
    
    $result = pg_query_params($conn, $updateQuery, $updateParams);
    if ($result) {
        $_SESSION['message'] = 'Profile updated successfully.';
    } else {
        $_SESSION['message'] = 'Error updating profile: ' . pg_last_error($conn);
    }
    
    
    header("Location: ../Dashboard.php?p=myProfile"); 
    exit();
} else {
    
    $_SESSION['message'] = 'Unauthorized access.';
    header("Location: ../Dashboard.php?p=myProfile"); 
    exit();
}
?>
