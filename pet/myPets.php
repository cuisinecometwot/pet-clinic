<?php
include '../utils/connect.php';
require '../models/Pet.php';

$currentPage = isset($_SESSION['current_page']) ? $_SESSION['current_page'] : 1;
$perPage = 5; // Number of pets per page
$offset = ($currentPage - 1) * $perPage;

if ($_SESSION['role'] == 'owner') 
{
	$sql = "SELECT * FROM pet WHERE ownerid = (SELECT uid FROM profile WHERE email = $1) LIMIT $2 OFFSET $3";
	$result = pg_prepare($conn, "all_pets", $sql);
	$result = pg_execute($conn, "all_pets", [$_SESSION['email'], $perPage, $offset]);

	$num = pg_num_rows($result);
	if ($num > 0)
   {
		echo "<table class='table table-striped'>";
      echo "<thead>";
      echo "<tr>";
      echo "<th>Name</th>";
      echo "<th>Age</th>";
      echo "<th>Gender</th>";
      echo "<th>Species</th>";
      echo "<th>Notes</th>";
      echo "</tr>";
      echo "</thead>";
      echo "<tbody>";

	  while ($row = pg_fetch_row($result)) {
		$pet = new Pet($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7]);
		echo "<tr onclick=\"window.location='Dashboard.php?p=pet/modify_pet&object_id=" . urlencode($pet->getPetID()) . "'\" style='cursor: pointer;'>";
		echo "<td>" . $pet->getName() . "</td>";
		echo "<td>" . $pet->getAge() . "</td>";
		echo "<td>" . $pet->getGender() . "</td>";
		echo "<td>" . $pet->getSpecies() . "</td>";
		echo "<td>" . $pet->getNotes() . "</td>";
		echo "</tr>";
	}		
      echo "</tbody>";
      echo "</table>";

      // Pagination Links
      $totalPets = pg_fetch_row(pg_query($conn, "SELECT COUNT(*) FROM pet WHERE ownerid = (SELECT uid FROM profile WHERE email = '" . $_SESSION['email'] . "')"))[0];
      $totalPages = ceil($totalPets / $perPage); // Calculate total pages
		
      if ($totalPages > 1)
      {
      	echo "<ul class='pagination'>";
        	if ($currentPage > 1) 
        	{ // Previous page link
         	echo "<li class='page-item'><a class='page-link' href='?p=myPets&page=" . ($currentPage - 1) . "'>Previous</a></li>";
        	}

        	for ($i = 1; $i <= $totalPages; $i++) { // Page number links
         	$activeClass = ($currentPage == $i) ? "active" : "";
         	echo "<li class='page-item " . $activeClass . "'><a class='page-link' href='?p=myPets&page=" . $i . "'>" . $i . "</a></li>";
        	}
	
     		if ($currentPage < $totalPages) { // Next page link
        		echo "<li class='page-item'><a class='page-link' href='?p=myPets&page=" . ($currentPage + 1) . "'>Next</a></li>";
     		}
     		echo "</ul>";
     	}
	} 
	else 
	{
     	echo "No pets found.";
  	}

	echo "<hr>";
	include 'add_pet.php'; // Add Pet form view + controller
}
else 
{
// Staff add pet with Owner selected
}
?>
