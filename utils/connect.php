<?php
// Include this file when connecting to DB
// Connection detail should in hidden files like .config instead of source code.
// But this way is simplier =.=

// Remember to run Postgres Docker!
include 'displayErrors.php';
$HOST = "localhost";
$DB = "petclinic";
$USER = "myuser";
$PWD = "mypassword";

if (session_status() == PHP_SESSION_NONE)
	session_start();
  
$conn = pg_connect("host=$HOST dbname=$DB user=$USER password=$PWD") or die();
if(!$conn) exit();

?>
