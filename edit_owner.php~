<?php
include '../utils/connect.php';
require_once '../models/Owner.php';

// Check if user is logged in and owner
if (isset($_SESSION['email']) && $_SESSION['role'] == 'owner') {

  // Get owner ID from GET parameter (assuming edit link passes ID)
  $owner_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

  // Check if ID is valid
  if ($owner_id > 0) {
    // Prepare query to retrieve owner information
    $result = pg_prepare($conn, "get_owner", "SELECT * FROM owner WHERE ownerid = $1");
    $result = pg_execute($conn, "get_owner", [$owner_id]);

    // Check if owner exists
    if (pg_num_rows($result) == 1) {
      $row = pg_fetch_row($result);
      $owner = new Owner($row[0], $row[2], $row[1], $row[3]);

      // Handle form submission (if submitted)
      if (isset($_POST['submit'])) {
        // Validate form data (replace with actual validation)
        $errors = [];
        if (empty($_POST['name'])) {
          $errors[] = "Name is required.";
        }
        if (empty($_POST['email'])) {
          $errors[] = "Email is required.";
        }
        // ... add validation for other fields ...

        if (empty($errors)) {
          // Prepare update query
          $result = pg_prepare($conn, "update_owner", "UPDATE owner SET name = $1, email = $2, phone_number = $3 WHERE id = $4");

          // Update owner information
          $result = pg_execute($conn, "update_owner", [
            $_POST['name'],
            $_POST['email'],
            $_POST['phone_number'],
            $owner_id
          ]);

          if ($result) {
            echo "Owner information updated successfully!";
            // Reload owner information after successful update
            $result = pg_execute($conn, "get_owner", [$owner_id]);
            $row = pg_fetch_row($result);
            $owner = new Owner($row[0], $row[2], $row[1], $row[3]);
          } else {
            echo "Failed to update owner information.";
          }
        }
      }
    } else {
      echo "Invalid owner ID.";
    }
  } else {
    echo "Invalid owner ID.";
  }
} else {
  // User not logged in or not owner
  echo "You are not authorized to edit owner information.";
}

// Display edit form (if valid owner retrieved)
if (isset($owner)) {
?>

<h2>Edit Owner Information</h2>

<?php if (isset($errors)): ?>
  <ul>
    <?php foreach ($errors as $error): ?>
      <li style="color: red;"><?= $error ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<form method="POST">
  <label for="name">Name:</label>
  <input type="text" name="name" id="name" value="<?= $owner->getName() ?>">
  <br>
  <label for="email">Email:</label>
  <input type="email" name="email" id="email" value="<?= $owner->getEmail() ?>">
  <br>
  <label for="phone_number">Phone Number:</label>
  <input type="text" name="phone_number" id="phone_number" value="<?= $owner->getPhoneNumber() ?>">
  <br>
  <button type="submit" name="submit">Update Information</button>
</form>

<?php
}
?>