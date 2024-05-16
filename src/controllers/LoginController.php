<?php
	include '../utils/connect.php'; include '../utils/displayErrors.php';
	if (session_status() == PHP_SESSION_NONE)
		session_start();

	if (!isset($_SESSION['role'])){
		if (isset($_POST['email']) && isset($_POST['password'])) {
			$email = $_POST['email'];
			$password = $_POST['password'];
        	$role = $_POST['role'];
        	$email = pg_escape_string($email); $password = pg_escape_string($password);

        	if ($role == "owner"){    
         	//$query = "SELECT * FROM owner_login WHERE email = '$email'";
         	$result = pg_prepare($conn, "my_query", 'SELECT * FROM owner_login WHERE email = $1');
				$result = pg_execute($conn, "my_query", [$email]);
				
            //$result = pg_query($conn, $query) or die();
            $num = pg_num_rows($result);

				if ($num == 1){
					$storedPWD = pg_fetch_assoc($result)['pwd'];
					
					if (strcmp($password, $storedPWD)==0){
						$_SESSION['role'] = $role;
						$_SESSION['email'] = $email;
						header('Location: Dashboard.php');				
					} else echo '<script type="text/javascript">window.onload=function(){ alert("Incorrect Email / Password!"); }</script>'; 
            } else echo '<script type="text/javascript">window.onload=function(){ alert("Incorrect Email / Password!"); }</script>'; 
        	}
        	else if ($role == "clinic"){
            //$query = "SELECT * FROM clinic_login WHERE email = '$email'";
            $result = pg_prepare($conn, "my_query", 'SELECT * FROM clinic_login WHERE email = $1');
				$result = pg_execute($conn, "my_query", [$email]);
            //$result = pg_query($conn, $query) or die();
            $num = pg_num_rows($result);

				if ($num == 1){					
					$storedPWD = pg_fetch_assoc($result)['pwd'];
					
					if (strcmp($password, $storedPWD)==0){
						$_SESSION['role'] = $role;
						$_SESSION['email'] = $email;
						header('Location: Dashboard.php');				
					} else echo '<script type="text/javascript">window.onload=function(){ alert("Incorrect Email / Password!"); }</script>'; 
				} else echo '<script type="text/javascript">window.onload=function(){ alert("Incorrect Email / Password!"); }</script>'; 
			}
		}
	} else {header('Location: Dashboard.php'); exit;} //if already signed in, we dont need to access here!
?>