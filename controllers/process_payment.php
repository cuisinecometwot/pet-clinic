<?php
include '../utils/connect.php';
if (session_status() == PHP_SESSION_NONE)
	session_start();
	
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (isset($_POST['card_number'], $_POST['card_name'], $_POST['expiry_date'], $_POST['cvv'], $_POST['object_id'], $_POST['object_type'])) 
    {
        $cardNumber = pg_escape_string($conn, $_POST['card_number']);
        $cardName = pg_escape_string($conn, $_POST['card_name']);
        $expiryDate = pg_escape_string($conn, $_POST['expiry_date']);
        $cvv = pg_escape_string($conn, $_POST['cvv']);
        $objectId = intval($_POST['object_id']);
        $objectType = pg_escape_string($conn, $_POST['object_type']);

        // Update the payment state in the appropriate table
        $updateQuery = "UPDATE {$objectType} SET payment = TRUE WHERE serviceid = $1";
        $result = pg_prepare($conn, "update_payment_state", $updateQuery);
        $result = pg_execute($conn, "update_payment_state", array($objectId));

        if ($result) 
        {
            $_SESSION['message'] = "Payment successful.";
            header("Location: ../Dashboard.php?p=hotel/petHotel");
            exit();
            
        } 
        else 
        {
            $_SESSION['message'] = "Error updating payment state.";
            header("Location: ../Dashboard.php?p=hotel/petHotel");
            exit();
        }
    } 
    else 
    {
        $_SESSION['message'] = "Error: Missing required form data.";
        header("Location: ../Dashboard.php?p=hotel/petHotel");
        exit();
    }
} 
else 
{
    $_SESSION['message'] = "Invalid request method.";
    header("Location: ../Dashboard.php?p=hotel/petHotel");
    exit();
}
?>