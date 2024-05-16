<?php
 session_start();
 session_unset();
 session_destroy(); 
 header('Location: ../views/index.php'); // redirect to index.php
?>