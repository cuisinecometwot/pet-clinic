<?php
	include '../utils/connect.php';
	if (session_status() == PHP_SESSION_NONE)
		session_start();

	if (!isset($_SESSION['role']))
	{
		if (isset($_POST['email']) && isset($_POST['password']))
		{
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
					//
					echo $storedPWD;
					echo $password;
					if (strcmp($password, $storedPWD)==0)
					{
						$_SESSION['role'] = $role;
						$_SESSION['email'] = $email;
						header('Location: Dashboard.php');				
					} 
					else echo $alertFailed;
            } 
            else echo $alertFailed;
        	}
        	else if ($role == "clinic")
        	{
            $result = pg_prepare($conn, "findStaff", 'SELECT * FROM clinic_login WHERE email = $1');
				$result = pg_execute($conn, "findStaff", [$email]);
            $num = pg_num_rows($result);

				if ($num == 1)
				{					
					$storedPWD = pg_fetch_assoc($result)['pwd'];
					if (strcmp($password, $storedPWD)==0)
					{
						$_SESSION['role'] = $role;
						$_SESSION['email'] = $email;
						header('Location: Dashboard.php');				
					} 
					else echo $alertFailed; 
				} 
				else echo $alertFailed;
			}
		}
	}
	else //if already signed in, we dont need to access here!
	{
		header('Location: Dashboard.php'); 
		exit;
	} 
?>