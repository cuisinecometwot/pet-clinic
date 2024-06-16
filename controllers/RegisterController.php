<?php
include '../utils/connect.php';
		
$email = $_POST['email'];
$password = $_POST['password'];
        
$query = "SELECT * FROM owner_login WHERE email = '$email'";
      
$result = pg_prepare($conn, "my_query", 'SELECT * FROM owner_login WHERE email = $1');
$result = pg_execute($conn, "my_query", [$email]);

if (pg_num_rows($result) != 0) 
{   header("refresh:3; url=../Login.php");
	echo '<script type="text/javascript">
				window.onload=function(){ 
					alert("An account using this email already exists!");
         	}
         </script>'; 
}
else{
$query = "INSERT INTO owner_login VALUES ('".$email."', '".$password."')"; 
$result = pg_query($conn, $query) or die();
// Check if the email already exists in the profile table
$query = "SELECT * FROM profile WHERE email = $1";
$result = pg_prepare($conn, "check_profile", $query);
$result = pg_execute($conn, "check_profile", [$email]);

if (pg_num_rows($result) != 0) {
    // Fetch the existing rank
    $row = pg_fetch_assoc($result);
    $current_rank = $row['rank'];

    // Determine the new rank
    if ($current_rank === 'admin') {
        $new_rank = 'owner/admin';
    } elseif ($current_rank === 'staff') {
        $new_rank = 'owner/staff';
    } else {
        $new_rank = 'owner';
    }

    // Update the existing profile record with the new rank
    $query = "UPDATE profile SET rank = $1 WHERE email = $2";
    $result = pg_prepare($conn, "update_profile", $query);
    $result = pg_execute($conn, "update_profile", [$new_rank, $email]);
} else {
    // Insert a new profile record
    $query = "INSERT INTO profile (email, rank) VALUES ($1, 'owner')";
    $result = pg_prepare($conn, "insert_profile", $query);
    $result = pg_execute($conn, "insert_profile", [$email]);
}
		
if ($result)
{
	header("refresh:3; url=../Login.php");
	echo '<script type="text/javascript">
				window.onload=function(){ 
                 alert("Account created successfully! Redirecting to Login...");
            }
         </script>'; 
			exit;    
}
}
?>