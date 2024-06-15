<?php
require_once('utils/connect.php'); 

$totalHealthRevenue = 0;
$totalBeautyRevenue = 0;
$totalHotelRevenue = 0;

$sql = "SELECT SUM(cost) AS revenue FROM health_record WHERE payment = TRUE";
$result = pg_query($conn, $sql);
if ($result && pg_num_rows($result) > 0) 
{
  $row = pg_fetch_assoc($result);
  $totalHealthRevenue = $row['revenue'];
}

pg_free_result($result);

$sql = "SELECT SUM(cost) AS revenue FROM beauty_service WHERE payment = TRUE";
$result = pg_query($conn, $sql);
if ($result && pg_num_rows($result) > 0) 
{
  $row = pg_fetch_assoc($result);
  $totalBeautyRevenue = $row['revenue'];
}
pg_free_result($result);

$sql = "SELECT SUM(cost) AS revenue FROM hotel_record WHERE payment = TRUE";
$result = pg_query($conn, $sql);
if ($result && pg_num_rows($result) > 0) 
{
  $row = pg_fetch_assoc($result);
  $totalHotelRevenue = $row['revenue'];
}
pg_free_result($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<title>Overall Revenue</title>
</head>
<body>
  	<h1>Overall Revenue</h1>

  	<ul>
    	<li>Health Services: VND <?php echo $totalHealthRevenue; ?></li>
    	<li>Beauty Services: VND <?php echo $totalBeautyRevenue; ?></li>
    	<li>Hotel Stays: VND <?php echo $totalHotelRevenue; ?></li>
  	</ul>

  	<?php
  	$totalRevenue = $totalHealthRevenue + $totalBeautyRevenue + $totalHotelRevenue;
  	if ($totalRevenue > 0) {
    	echo "<h2>Total Revenue: VND " . $totalRevenue . "</h2>";
  	}
  	?>

</body>
</html>