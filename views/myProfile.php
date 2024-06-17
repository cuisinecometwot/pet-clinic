<?php
include '../utils/connect.php';
require '../models/Profile.php';
?>
<!DOCTYPE HTML>
<h1>Edit Your Profile</h1>

<form action='../controllers/edit_profile.php' method='post'>
<table class='table table-striped'>
	<tr><td>ID</td><td><?php echo $row[0]; ?></td></tr>
	<tr><td>Name</td><td>
	<input type='text' class="form-control" name='name' value='<?php echo $row[1]; ?>' required></td></tr>
	<tr><td>Email</td><td>
	<input type='email' class="form-control" name='email' value='<?php echo $row[2]; ?>' required></td></tr>
	<tr><td>Phone Number</td><td>
	<input type='tel' class="form-control" name='phone_number' value='<?php echo $row[3]; ?>' required></td></tr>
</table>
<button type='submit' class="btn btn-success">Update Information</button>
</form>
<!-- Update Password - not implemented-->    
<form action='../controllers/edit_password.php' method='post' autocomplete="off">
<table class='table table-striped'>
	<tr><td>Old Password</td><td>
	<input type='text' class="form-control" name="oldPassword" required></td></tr>
	<tr><td>New Password</td><td>
	<input type='text' class="form-control" name="newPassword" required></td></tr>
	<tr><td>Confirm New Password</td><td>
	<input type='password' class="form-control" name= "confirmPassword" required></td></tr>
</table>
<button type='submit' class="btn btn-success">Update Password</button>
</form>
<?php
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