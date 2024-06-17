<?php
if (session_status() == PHP_SESSION_NONE)
	session_start();
if (isset($_SESSION['role'])) // already logged in
{
	header('Location: Dashboard.php');	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
    <title> Login </title>
    <script>
    function showDialog() {
      alert("Relax and try to remember your password!");
    }
    </script>
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
    <form action="../controllers/LoginController.php" method="POST" autocomplete="on">
        <h1>Login</h1>
        <div>
            <label for="Email">Your Email</label>
            <input type="email" name="email" id="email" placeholder="example@domain" required>
        </div>
        <div>
            <label for="Password">Password</label>
            <input type="password" name="password" id="password" placeholder="********" required>
        </div>
        <div>
            <label for="role">Login as</label>
            <select name="role" id="color">
	            <option value="owner">Pet Owner</option>
	            <option value="clinic">Clinic</option>
            </select>
        </div>
        <section>
            <button type="submit">Login</button>
            <a href="Register.php"> Don't have an account? </a>
        </section>
        <button onclick="showDialog()"> Forgot Password? </button>
    </form>
</main>
</body>
</html>
