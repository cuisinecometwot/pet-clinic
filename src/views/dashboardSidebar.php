<?php
if (session_status() == PHP_SESSION_NONE)
	session_start();

if ($_SESSION['role'] == 'owner')
	echo '<div class="sidebar">
        <h2> Dashboard </h2>
        <ul>
            <li><a href="index.php"><i class="fas fa-home"></i>Homepage</a></li>
            <li><a href="#myProfile" onclick="replaceContent()"><i class="fas fa-user"></i>My Profile</a></li>
            <li><a href="#myPets" onclick="replaceContent()"><i class="fas fa-paw"></i>My Pets</a></li>
            <li><a href="#petCheck" onclick="replaceContent()"><i class="fas fa-plus"></i>Đặt lịch khám</a></li>
            <li><a href="#petCare" onclick="replaceContent()"><i class="fas fa-shower"></i>DV vệ sinh - làm đẹp</a></li>
            <li><a href="#petHotel" onclick="replaceContent()"><i class="fas fa-hotel"></i>DV lưu giữ thú cưng</a></li>
            <li><a href="#logs" onclick="replaceContent()"><i class="fas fa-th-list"></i>Service Logs</a></li>
        </ul> 
    </div>';
else if ($_SESSION['role'] == 'clinic')
	echo '<div class="sidebar">// clinic sidebar
        <h2> Dashboard </h2>
        <ul>
            <li><a href="index.html"><i class="fas fa-home"></i>Homepage</a></li>
            <li><a href="#myProfile" onclick="replaceContent()"><i class="fas fa-user"></i>My Profile</a></li>
            <li><a href="#petList" onclick="replaceContent()"><i class="fas fa-paw"></i>Quan ly Pets</a></li> <!-- Xem info co ban, tinh trang sk -->
            <li><a href="#petCheckSchedule" onclick="replaceContent()"><i class="fas fa-plus"></i>Xem lịch khám</a></li>
            <li><a href="#petCare" onclick="replaceContent()"><i class="fas fa-shower"></i>DV vệ sinh - làm đẹp</a></li>
            <li><a href="#petHotel" onclick="replaceContent()"><i class="fas fa-hotel"></i>DV lưu giữ thú cưng</a></li>
            <li><a href="#services" onclick="replaceContent()"><i class="fas fa-th-list"></i>Quan ly dich vu (CRUD)</a></li>
            <li><a href="#reports" onclick="replaceContent()"><i class="fas fa-th-list"></i>Thong ke / Bao cao</a></li>
        </ul> 
    </div>'; 
else header('Location: Login.php');
?>