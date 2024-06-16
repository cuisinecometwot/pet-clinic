<?php
session_start(); // Ensure the session is started

// Include your database connection file
include '../utils/connect.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and validate input
    $oldPassword = pg_escape_string($conn, $_POST['oldPassword']); 
    $newPassword = pg_escape_string($conn, $_POST['newPassword']); 
    $confirmPassword = pg_escape_string($conn, $_POST['confirmPassword']); 
    
    // Validate passwords match
    if ($newPassword !== $confirmPassword) {
        $_SESSION['message'] = 'Error: New passwords do not match.';
        header("Location: ../Dashboard.php?p=myProfile"); 
        exit();
    }
    
    // Determine the table based on role
    $role = $_SESSION['role'];
    $email = $_SESSION['email'];
    
    if ($role == 'admin' || $role == 'staff') {
        // Update clinic_login table
        $updateQuery = "UPDATE clinic_login SET pwd = $1 WHERE email = $2 AND pwd = $3";
        $updateResult = pg_prepare($conn, "update_clinic_password", $updateQuery);
        $updateResult = pg_execute($conn, "update_clinic_password", array($newPassword, $email, $oldPassword));
    } else {
        // Update owner_login table
        $updateQuery = "UPDATE owner_login SET pwd = $1 WHERE email = $2 AND pwd = $3";
        $updateResult = pg_prepare($conn, "update_owner_password", $updateQuery);
        $updateResult = pg_execute($conn, "update_owner_password", array($newPassword, $email, $oldPassword));
    }
    
    // Check if update was successful
    if ($updateResult) {
        $_SESSION['message'] = 'Password updated successfully.';
        header("Location: ../Dashboard.php?p=myProfile"); 
        exit();
    } else {
        $_SESSION['message'] = 'Error: Failed to update password.';
        header("Location: ../Dashboard.php?p=myProfile"); 
        exit();
    }
} else {
    header("Location: ../Dashboard.php?p=myProfile");
    exit();
}
?>
