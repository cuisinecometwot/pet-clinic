<?php
include '../utils/connect.php';

$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

$alertFailed = '<script type="text/javascript">
					window.onload=function(){
					alert("Incorrect Email / Password!");
				}</script>'; 

if ($role == "owner")
{
	$result = pg_prepare($conn, "findOwner", 'SELECT * FROM owner_login WHERE email = $1');
	$result = pg_execute($conn, "findOwner", [$email]);
	$num = pg_num_rows($result);

	if ($num == 1)
	{
		$storedPWD = pg_fetch_assoc($result)['pwd'];
		echo $storedPWD;
		echo $password;
		if (strcmp($password, $storedPWD)==0)
		{
			$_SESSION['role'] = $role;
			$_SESSION['email'] = $email;
			header('Location: ../Dashboard.php');
		} 

	} 
	else 
	{
		echo $alertFailed;
    	header('Location: ../Login.php');
	}
}

else if ($role == "clinic")
{
    $result = pg_prepare($conn, "findStaff", 'SELECT * FROM clinic_login WHERE email = $1');
	$result = pg_execute($conn, "findStaff", [$email]);
    $num = pg_num_rows($result);

	if ($num == 1)
	{
		//$storedPWD = pg_fetch_assoc($result)['pwd'];
		$row = pg_fetch_assoc($result);
		$storedPWD = $row['pwd'];
		$is_admin = $row['is_admin'];
		
		if (strcmp($password, $storedPWD)==0)
		{
			$_SESSION['role'] = $role;
			if ($is_admin === 't') 
				$_SESSION['role'] = 'admin';
			
			$_SESSION['email'] = $email;
			header('Location: ../Dashboard.php');
		} 
		else echo $alertFailed; 
	} 
	else echo $alertFailed;
}


?>