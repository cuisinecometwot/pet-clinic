<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Dashboard </title>
	<link rel="stylesheet" href="styles.css">
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
$(document).ready(function() {
    // Toggle submenu display on clicking "Service Logs"
    $('.nav-link').click(function() {
        $(this).next('.submenu').slideToggle();
    });
});
</script>

	<script type="text/javascript" >
		window.addEventListener('load', function() {
    		const params = new URLSearchParams(window.location.search);
    		const page = params.get('p'); // Get the 'p' parameter value

    		if (page) { // Check if 'p' exists
      		const phpFile = page + ".php"; // Construct the PHP filename
			
      		fetch(phpFile)
        		.then(response => response.text())
        		.then(data => {
          		document.getElementById('content').innerHTML = data;
        		})
        		.catch(error => {
          		console.error('Error:', error);
        		});
    		}
  		});
	</script>
</head>
<body>
<div class="wrapper">
    <?php include 'dashboardSidebar.php'; 
	 if (isset($_GET['page'])) {
  		 $_SESSION['current_page'] = (int) $_GET['page'];
	 }
	 if (isset($_GET['object_id'])) {
		$_SESSION['object_id'] = (int) $_GET['object_id'];
	 }
	 if (isset($_GET['object_type'])) {
			$_SESSION['object_type'] = (string) $_GET['object_type'];	
     }
    ?>
    <div class="main_content">
	     <div class="header">Welcome! Have a nice day.</div>  
        <div class="content" id="content">
		     <div>Choose your desired option from the left sidebar.</div>
		     <img src="res/img/lying-dog.jpg" alt="">
        </div>
    </div>
</div>

</body>
</html>
