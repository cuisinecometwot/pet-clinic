<?php
if (session_status() == PHP_SESSION_NONE)
  session_start();

$ownerMenu = array(
	"Homepage" => "index.php",
	"My Profile" => "?p=myProfile",
	"My Pets" => "?p=owner/pet/myPets",
	"Đặt lịch" => "?p=owner/booking",
	"Dịch vụ lưu giữ" => "?p=owner/petHotel",
	"Service Logs" => array(
        "Beauty Service" => "?p=owner/log/beautyService",
        "Health Record" => "?p=owner/log/healthRecord",
        "Hotel Record" => "?p=owner/log/hotelRecord"
    ),
    "Log Out" => "../../utils/logout.php"
);

$staffMenu = array(
	"Homepage" => "index.php",
	"My Profile" => "?p=myProfile",
	"Xem lịch khám" => "?p=staff/bookingManager/healthServiceManager",
	"Vệ sinh - làm đẹp" => "?p=staff/bookingManager/spaManager",
	"Quản lý đặt phòng" => "?p=staff/bookingManager/hotelRecordManager",
	"Lưu giữ" => "?p=staff/hotel/hotelManager",
	"Log Out" => "../../utils/logout.php"
);

$adminMenu = array(
	"Homepage" => "index.php",
	"My Profile" => "?p=myProfile",
	"User Profile" => "?p=admin/userManager/users",
	"Manage Services" => "?p=admin/serviceManager/services",
	"Revenue" => "?p=admin/revenue",
	"Log Out" => "../../utils/logout.php"
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
foreach ($menu as $menuItem => $url) {
    if (is_array($url)) {
        // If it's an array (sub-menu), display it as a nested list
        echo '<li class="nav-item">';
        echo '<a class="nav-link" href="#">' . $menuItem . '</a>';
        echo '<ul class="submenu" >';
        foreach ($url as $subMenuItem => $subMenuUrl) {
            echo '<li><a class="nav-link" href="' . $subMenuUrl . '">' . $subMenuItem . '</a></li>';
        }
        echo '</ul>'; // End submenu
        echo '</li>';
    } else {
        // If it's a regular menu item, display it normally
        echo '<li class="nav-item">';
        echo '<a class="nav-link" href="' . $url . '">' . $menuItem . '</a>';
        echo '</li>';
    }
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
    