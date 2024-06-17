<?php
if (session_status() == PHP_SESSION_NONE)
	session_start();
if (isset($_SESSION['role'])) // already logged in
	{
		header('Location: views/Dashboard.php');	
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
    <title> Register </title>
</head>
<body>
<style type="text/css">
body {
background-image: url('../res/img/bg0.jpg');
background-position: center;
background-repeat: no-repeat;
background-size: cover;
}
</style>
<main>
<br><br><br><br><br><br>
    <form action="controllers/RegisterController.php" method="post">
        <h1> Register | Pet Owner </h1> <!-- Clinic accounts must be created by Admin-->
        <div>
            <label for="Email">Your Email</label>
            <input type="email" name="email" id="email" placeholder="example@domain" required>
        </div>
        <div>
            <label for="Password">Password</label>
            <input type="password" name="password" id="password" placeholder="********" required>
        </div>
        <section>
            <button type="submit">Register</button>
            <a href="Login.php">Already have an account?</a>
        </section>
    </form>
</main>
</body>
</html>