<?php
	if (session_status() == PHP_SESSION_NONE)
        session_start();
 
	if (!isset($_SESSION['user'])){
		include '../utils/connect.php';
		$email = $_POST['email'];
		$password = $_POST['password'];
		$role = $_POST['role'];
        
		$query = "SELECT * FROM owner_login WHERE email = '$email'";
      
		$result = pg_prepare($conn, "my_query", 'SELECT * FROM owner_login WHERE email = $1');
		$result = pg_execute($conn, "my_query", [$email]);

		if (pg_num_rows($result) != 0) 
			echo '<script type="text/javascript">
						window.onload=function(){ 
							alert("An account using this email already exists!");
         			}
         		</script>'; 

		$query = "INSERT INTO owner_login VALUES ('".$email."', '".$password."')"; 
		$result = pg_query($conn, $query) or die();
		
		if ($result){
			header("refresh:3; url=Login.php");
			echo '<script type="text/javascript">
						window.onload=function(){ 
                  	alert("Account created successfully! Redirecting to Login...");
                  }
              	</script>'; 
			exit;    
		}
	} else {header('Location: Dashboard.php'); exit;} //if already signed in, we dont need to register!
?>