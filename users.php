<?php
require_once('utils/connect.php');

$users = array();
$sql = "SELECT * FROM profile ORDER BY uid";

if ($result = pg_query($conn, $sql)) 
{
	while ($row = pg_fetch_assoc($result)) {
    	$users[] = $row;
  	}
  	// Free the memory used by the result set
  	pg_free_result($result);
} 
else 
{
  echo "Error: " . pg_last_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profiles</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evSX huddledayAHT4wXauhxBV+wbVNPGCqVZxqh2kQ6z6sRW1z9NgzH1t4z4HfqrgoiixhISOzEGjfwEoqYlmF7KjGO8ALCXaRuNiXk8w/" crossorigin="anonymous">
</head>
<body>
  <div class="container mt-3">
    <h1>User Profiles</h1>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Role</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Check if there are any users
        if (count($users) > 0) {
          // Loop through each user in the array
          $i = 1;  // Counter for user ID
          foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td>" . $user['name'] . "</td>";
            echo "<td>" . $user['email'] . "</td>";
            echo "<td>" . $user['phone'] . "</td>";
            echo "<td>" . $user['rank'] . "</td>";
            echo "</tr>";
            $i++;
          }
        } else {
          echo "<tr><td colspan='5'>No users found!</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-OgwbZS7/BXzYhFOT11tTvwVHcwjK1Q2vRLzVMEcyCsRUjGjy6gljCqTnx95yGTca1z" crossorigin="anonymous"></script>
</body>
</html>