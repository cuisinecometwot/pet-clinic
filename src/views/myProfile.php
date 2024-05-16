<?php
if (session_status() == PHP_SESSION_NONE)
  session_start();

include '../utils/connect.php';
include '../utils/displayErrors.php';
require_once '../models/Owner.php';
// TODO: This page should show info depend on user role (owner or clinic staff)
// Allow to modify their personal info
if (isset($_SESSION['email'])) {
	if ($_SESSION['role'] == 'owner'){
  		$result = pg_prepare($conn, "my_query1", 'SELECT * FROM owner WHERE email = $1');
  		$result = pg_execute($conn, "my_query1", [$_SESSION['email']]);
  		$num = pg_num_rows($result);
  	}
  	else {
  		$result = pg_prepare($conn, "my_query2", 'SELECT * FROM clinic WHERE email = $1');
  		$result = pg_execute($conn, "my_query2", [$_SESSION['email']]);
  		$num = pg_num_rows($result);
  	}

  	if ($num == 1){
  		$row = pg_fetch_row($result);
		var_dump($row);
		$owner = new Owner($row[0], $row[2], $row[1], $row[3]);

  	} else echo "Fatal error!";
}

?>
