<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Dashboard </title>
	<link rel="stylesheet" href="styles.css">
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
	<script type="text/javascript" >
		function replaceContent() {
    		event.preventDefault();
  			const clickedLink = event.target;
  			const href = clickedLink.getAttribute('href');
  			// Check if href points to an external URL or internal file
  			const phpFile = href.slice(1) + ".php";

    		fetch(phpFile)
      		.then(response => response.text())
      		.then(data => {
        			document.getElementById('content').innerHTML = data;
      		})
      		.catch(error => {
        			console.error('Error:', error);
      		});
		}
	</script>
</head>
<body>
<div class="wrapper">
	 <?php include 'dashboardSidebar.php'; ?>
    <div class="main_content">
        <div class="header">Welcome! Have a nice day.</div>  
        <div class="content" id="content">
          <div>Lorem ipsum dolor sit, amet consectetur adipisicing elit. A sed nobis ut exercitationem atque accusamus sit natus officiis totam blanditiis at eum nemo, nulla et quae eius culpa eveniet voluptatibus repellat illum tenetur, facilis porro. Quae fuga odio perferendis itaque alias sint, beatae non maiores magnam ad, veniam tenetur atque ea exercitationem earum eveniet totam ipsam magni tempora aliquid ullam possimus? Tempora nobis facere porro, praesentium magnam provident accusamus temporibus! Repellendus harum veritatis itaque molestias repudiandae ea corporis maiores non obcaecati libero, unde ipsum consequuntur aut consectetur culpa magni omnis vero odio suscipit vitae dolor quod dignissimos perferendis eos? Consequuntur!</div>
      </div>
    </div>
</div>

</body>
</html>
