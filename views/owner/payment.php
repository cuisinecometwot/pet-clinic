<?php
include '../../utils/connect.php';

if (!isset($_SESSION['object_id']) || !isset($_SESSION['object_type'])) {
    echo "Error: Missing object information.";
    exit();
}

$objectId = $_SESSION['object_id'];
$objectType = $_SESSION['object_type'];

// Determine the redirect URL and SQL update based on object_type
if ($objectType === 'health_record') {
    $redirectUrl = '../Dashboard.php?p=owner/log/healthRecord';
    $updateQuery = "UPDATE health_record SET payment = TRUE WHERE recordid = $1";
} elseif ($objectType === 'beauty_service') {
    $redirectUrl = '../Dashboard.php?p=owner/log/beautyService';
    $updateQuery = "UPDATE beauty_service SET payment = TRUE WHERE serviceid = $1";
} elseif ($objectType === 'hotel_record') {
    $redirectUrl = '../Dashboard.php?p=owner/log/hotelRecord';
    $updateQuery = "UPDATE hotel_record SET payment = TRUE WHERE recordid = $1";
} else {
    $redirectUrl = '../Dashboard.php?p=myProfile';
    $_SESSION['message'] = "Error: Invalid object type.";
    header("Location: $redirectUrl");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Payment Form</h2>
        <form action="owner/payment.php" method="POST">
            <div class="mb-3">
                <label for="cardNumber" class="form-label">Card Number</label>
                <input type="text" class="form-control" id="cardNumber" name="card_number" required>
            </div>
            <div class="mb-3">
                <label for="cardName" class="form-label">Cardholder Name</label>
                <input type="text" class="form-control" id="cardName" name="card_name" required>
            </div>
            <div class="mb-3">
                <label for="expiryDate" class="form-label">Expiry Date</label>
                <input type="text" class="form-control" id="expiryDate" name="expiry_date" required>
            </div>
            <div class="mb-3">
                <label for="cvv" class="form-label">CVV</label>
                <input type="text" class="form-control" id="cvv" name="cvv" required>
            </div>
            <input type="hidden" name="object_id" value="<?php echo $objectId; ?>">
            <input type="hidden" name="object_type" value="<?php echo $objectType; ?>">
            <button type="submit" class="btn btn-primary">Submit Payment</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['card_number'], $_POST['card_name'], $_POST['expiry_date'], $_POST['cvv'], $_POST['object_id'], $_POST['object_type'])) {
        $cardNumber = pg_escape_string($conn, $_POST['card_number']);
        $cardName = pg_escape_string($conn, $_POST['card_name']);
        $expiryDate = pg_escape_string($conn, $_POST['expiry_date']);
        $cvv = pg_escape_string($conn, $_POST['cvv']);
        $objectId = intval($_POST['object_id']);
        $objectType = pg_escape_string($conn, $_POST['object_type']);

        // Update the payment state in the appropriate table
        $result = pg_prepare($conn, "update_payment_state", $updateQuery);
        $result = pg_execute($conn, "update_payment_state", array($objectId));

        if ($result) {
            $_SESSION['message'] = "Payment successful.";
            header("Location: $redirectUrl"); // Redirect based on object_type
            exit();
        } else {
            $_SESSION['message'] = "Error updating payment state.";
            header("Location: $redirectUrl"); // Redirect based on object_type
            exit();
        }
    } else {
        $_SESSION['message'] = "Error: Missing required form data.";
        header("Location: $redirectUrl"); // Redirect based on object_type
        exit();
    }
}
?>
