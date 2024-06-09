<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Dashboard </title>
	<link rel="stylesheet" href="styles.css">
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
  	 	 // Store the "page" value in the session
  		 $_SESSION['current_page'] = (int) $_GET['page'];
	 }
    ?>
    <div class="main_content">
	     <div class="header">Welcome! Have a nice day.</div>  
        <div class="content" id="content">
            <div>Lorem ipsum dolor sit, amet consectetur adipisicing elit. A sed nobis ut exercitationem atque accusamus sit natus officiis totam blanditiis at eum nemo, nulla et quae eius culpa eveniet voluptatibus repellat illum tenetur, facilis porro. Quae fuga odio perferendis itaque alias sint, beatae non maiores magnam ad, veniam tenetur atque ea exercitationem earum eveniet totam ipsam magni tempora aliquid ullam possimus? Tempora nobis facere porro, praesentium magnam provident accusamus temporibus! Repellendus harum veritatis itaque molestias repudiandae ea corporis maiores non obcaecati libero, unde ipsum consequuntur aut consectetur culpa magni omnis vero odio suscipit vitae dolor quod dignissimos perferendis eos? Consequuntur!</div>
        </div>
    </div>
</div>

</body>
</html>
