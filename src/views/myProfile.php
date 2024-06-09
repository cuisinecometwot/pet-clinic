<?php
include '../utils/connect.php';
require '../models/Owner.php';

if ($_SESSION['role'] == 'owner') 
{
  	echo "<h1>Owner Information</h1>";
   echo "<table>";
   echo "<tr><td>ID:</td><td>" . $row[0] . "</td></tr>";
   echo "<tr><td>Email:</td><td>" . $row[1] . "</td></tr>";
   echo "<tr><td>Name:</td><td>" . $row[2] . "</td></tr>";
   echo "<tr><td>Phone Number:</td><td>" . $row[3] . "</td></tr>";
   echo "</table>";

   // echo "<br><a href='edit_owner.php?id=" . $row[0] . "'>Edit Information</a>";
}

else if ($_SESSION['role'] == 'clinic') 
{
  	$result = pg_prepare($conn, "my_query2", 'SELECT * FROM clinic WHERE email = $1');
  	$result = pg_execute($conn, "my_query2", [$_SESSION['email']]);
  	$num = pg_num_rows($result);
}

else // User not logged in
{
  	header('Location: Login.php'); 
	exit;
}

?>
