<?php
include 'utils/connect.php';
if (!isset($_SESSION['object_id']) || !isset($_SESSION['object_type'])) {
    echo "Error: Missing object information.";
    exit();
}

$objectId = $_SESSION['object_id'];
$objectType = $_SESSION['object_type'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Payment Form</h2>
        <form action="process_payment.php" method="POST">
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
session_start();
include 'utils/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['card_number'], $_POST['card_name'], $_POST['expiry_date'], $_POST['cvv'], $_POST['object_id'], $_POST['object_type'])) {
        $cardNumber = pg_escape_string($conn, $_POST['card_number']);
        $cardName = pg_escape_string($conn, $_POST['card_name']);
        $expiryDate = pg_escape_string($conn, $_POST['expiry_date']);
        $cvv = pg_escape_string($conn, $_POST['cvv']);
        $objectId = intval($_POST['object_id']);
        $objectType = pg_escape_string($conn, $_POST['object_type']);

        // Update the payment state in the appropriate table
        $updateQuery = "UPDATE $objectType SET payment = TRUE WHERE serviceid = $1";
        $result = pg_prepare($conn, "update_payment_state", $updateQuery);
        $result = pg_execute($conn, "update_payment_state", array($objectId));

        if ($result) {
            $_SESSION['message'] = "Payment successful.";
            header("Location: ../Dashboard.php?p=hotel/petHotel");
            exit();
        } else {
            $_SESSION['message'] = "Error updating payment state.";
            header("Location: ../Dashboard.php?p=hotel/petHotel");
            exit();
        }
    } else {
        $_SESSION['message'] = "Error: Missing required form data.";
        header("Location: ../Dashboard.php?p=hotel/petHotel");
        exit();
    }
} else {
    $_SESSION['message'] = "Invalid request method.";
    header("Location: ../Dashboard.php?p=hotel/petHotel");
    exit();
}
?>
