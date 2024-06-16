<h3>Add Staff</h3>
<form action="userManager/add_staff.php" method="POST">
    <div class="form-group">
        <label for="staffEmail">Email</label>
        <input type="email" class="form-control" id="staffEmail" name="staffEmail" required>
    </div>
    <div class="form-group">
        <label for="staffPassword">Password</label>
        <input type="password" class="form-control" id="staffPassword" name="staffPassword" required>
    </div>
    <button type="submit" class="btn btn-primary">+ Add</button>
</form>

<?php
session_start(); // Ensure the session is started

include '../utils/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['staffEmail']) && isset($_POST['staffPassword'])) {
        $staffEmail = pg_escape_string($conn, $_POST['staffEmail']);
        $staffPassword = pg_escape_string($conn, $_POST['staffPassword']);
        pg_query($conn, "BEGIN");
        
        // Check if email already exists in clinic_login
        $checkLoginQuery = "SELECT email FROM clinic_login WHERE email = $1";
        $checkLoginResult = pg_prepare($conn, "check_login_email", $checkLoginQuery);
        $checkLoginResult = pg_execute($conn, "check_login_email", array($staffEmail));

        if (pg_num_rows($checkLoginResult) > 0) {
            // Email already exists in clinic_login, set session message and redirect
            $_SESSION['message'] = 'Error: The email is already used.';
            pg_query($conn, "ROLLBACK");
            header("Location: add_staff.php");
            exit();
        }

        // Insert into clinic_login table
        $loginQuery = "INSERT INTO clinic_login (email, pwd) VALUES ($1, $2)";
        $loginResult = pg_prepare($conn, "insert_clinic_login", $loginQuery);
        $loginResult = pg_execute($conn, "insert_clinic_login", array($staffEmail, $staffPassword));

        // Check if email already exists in profile
        $checkProfileQuery = "SELECT email FROM profile WHERE email = $1";
        $checkProfileResult = pg_prepare($conn, "check_profile_email", $checkProfileQuery);
        $checkProfileResult = pg_execute($conn, "check_profile_email", array($staffEmail));

        if (pg_num_rows($checkProfileResult) > 0) {
            // Email exists in profile, update rank to 'owner/staff'
            $updateProfileQuery = "UPDATE profile SET rank = 'owner/staff' WHERE email = $1";
            $updateProfileResult = pg_prepare($conn, "update_profile_rank", $updateProfileQuery);
            $updateProfileResult = pg_execute($conn, "update_profile_rank", array($staffEmail));

            if (!$updateProfileResult) {
                $_SESSION['message'] = 'Error: Could not update profile rank.';
                pg_query($conn, "ROLLBACK");
                header("Location: ../Dashboard.php?p=userManager/add_staff");
                exit();
            }
        } else {
            // Insert a new profile record
            $insertProfileQuery = "INSERT INTO profile (email, rank) VALUES ($1, 'staff')";
            $insertProfileResult = pg_prepare($conn, "insert_profile", $insertProfileQuery);
            $insertProfileResult = pg_execute($conn, "insert_profile", array($staffEmail));

            if (!$insertProfileResult) {
                $_SESSION['message'] = 'Error: Could not insert into profile.';
                pg_query($conn, "ROLLBACK");
                header("Location: add_staff.php");
                exit();
            }
        }

        // Commit the transaction
        pg_query($conn, "COMMIT");
        $_SESSION['message'] = 'Staff added successfully.';
        header("Location: ../Dashboard.php?p=userManager/users");
        exit();
    } else {
        echo "Error: Missing form data.";
    }
}

// Display the session message
$message = null;
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); 
}

if ($message): 
    $alertClass = (strpos($message, 'Error') === 0) ? 'alert-danger' : 'alert-success';
?>
    <div class="alert <?php echo $alertClass; ?>" role="alert">
      <?php echo $message; ?>
    </div>
<?php endif; ?>
