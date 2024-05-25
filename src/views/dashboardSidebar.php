<?php
if (session_status() == PHP_SESSION_NONE)
  session_start();

$role = $_SESSION['role'];

if ($role == 'owner')
  echo '<div class="container-fluid">
    <div class="row flex-wrap">
      <div class="s1debar">
        <h3> Dashboard </h3>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="index.php"><i class="fas fa-home"></i> Homepage</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#myProfile" onclick="replaceContent()"><i class="fas fa-user"></i> My Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#myPets" onclick="replaceContent()"><i class="fas fa-paw"></i> My Pets</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#petCheck" onclick="replaceContent()"><i class="fas fa-plus"></i> Đặt lịch khám</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#petCare" onclick="replaceContent()"><i class="fas fa-shower"></i> DV vệ sinh - làm đẹp</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#petHotel" onclick="replaceContent()"><i class="fas fa-hotel"></i> DV lưu giữ thú cưng</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#logs" onclick="replaceContent()"><i class="fas fa-th-list"></i> Service Logs</a>
          </li>
        </ul>
      </div>
    </div>
  </div>';
else if ($role == 'clinic')
  echo '<div class="container-fluid">
    <div class="row flex-wrap">
      <div class="s1debar">
        <h3> Dashboard </h3>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="index.html"><i class="fas fa-home"></i> Homepage</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#myProfile" onclick="replaceContent()"><i class="fas fa-user"></i> My Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#petList" onclick="replaceContent()"><i class="fas fa-paw"></i> Quan ly Pets</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#petCheckSchedule" onclick="replaceContent()"><i class="fas fa-plus"></i> Xem lịch khám</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#petCare" onclick="replaceContent()"><i class="fas fa-shower"></i> DV vệ sinh - làm đẹp</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#petHotel" onclick="replaceContent()"><i class="fas fa-hotel"></i> DV lưu giữ thú cưng</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#services" onclick="replaceContent()"><i class="fas fa-th-list"></i> Quan ly dich vu (CRUD)</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#reports" onclick="replaceContent()"><i class="fas fa-th-list"></i> Thong ke / Bao cao</a>
          </li>
        </ul>
      </div>
    </div>
  </div>';
?>
    