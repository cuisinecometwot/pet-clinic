<?php
if (session_status() == PHP_SESSION_NONE)
  session_start();

$ownerMenu = array(
	"Homepage" => "index.php",
	"My Profile" => "?p=myProfile",
	"My Pets" => "?p=myPets",
	"Đặt lịch" => "?p=booking",
	"Dịch vụ lưu giữ" => "?p=hotel",
	"Service Logs" => "?p=logs"
);

$staffMenu = array(
	"Homepage" => "index.php",
	"My Profile" => "?p=myProfile",
	"Quản lý pets" => "?p=myPets",
	"Xem lịch khám" => "?p=bookingManager",
	"Vệ sinh - làm đẹp" => "?p=spaManager",
	"Lưu giữ" => "?p=hotel/hotelManager"
);

$adminMenu = array(
	"Homepage" => "index.php",
	"My Profile" => "?p=myProfile",
	"Quản lý dịch vụ" => "?p=services",
	"Thống kê - báo cáo" => "?p=reports"
);

echo '<div class="container-fluid">
    				<div class="row flex-wrap">
      				<div class="s1debar">
        					<h3> Dashboard </h3>
        					<ul class="nav flex-column">';
        					
$role = $_SESSION['role'];
switch($role) 
{
	case "clinic":
		$menu = $staffMenu;
		break;
	case "admin":
		$menu = $adminMenu;
		break;
	default:
		$menu = $ownerMenu;
}
foreach ($menu as $menuItem => $url)
{
	echo "<li class=\"nav-item\">
            <a class=\"nav-link active\" href='{$url}'><i class=\"fas fa-home\"></i> {$menuItem}</a>
        </li>";
}
echo '</ul></div></div></div>';
/* // Good design!
switch($role) 
{
	
	case "owner":
	 	foreach ($ownerMenu as $menuItem => $url)
	 	{
	 		echo "<li class=\"nav-item\">
            		<a class=\"nav-link active\" href='{$url}'><i class=\"fas fa-home\"></i> {$menuItem}</a>
          		</li>";
	 	}
	 	break;
	case "clinic":
	 	foreach ($staffMenu as $menuItem => $url)
	 	{
	 		echo "<li class=\"nav-item\">
            		<a class=\"nav-link active\" href='{$url}'><i class=\"fas fa-home\"></i> {$menuItem}</a>
          		</li>";
	 	}
	 	break;
	case "admin":
	 	foreach ($adminMenu as $menuItem => $url)
	 	{
	 		echo "<li class=\"nav-item\">
            		<a class=\"nav-link active\" href='{$url}'><i class=\"fas fa-home\"></i> {$menuItem}</a>
          		</li>";
	 	}
	 	
}*/

?>
    