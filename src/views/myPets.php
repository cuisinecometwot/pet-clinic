<?php
include '../utils/connect.php';
include '../utils/displayErrors.php';
require '../models/Pet.php';

if (isset($_SESSION['email'])) 
{
	if ($_SESSION['role'] == 'owner') 
	{
		$sql = "SELECT * FROM pet WHERE ownerid = (SELECT ownerid FROM owner WHERE email = $1)";
      $result = pg_prepare($conn, "all_pets", $sql);
		$result = pg_execute($conn, "all_pets", [$_SESSION['email']]);
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

         while ($row = pg_fetch_row($result)) 
         {
         	$pet = new Pet($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);

            echo "<tr>";
            echo "<td>" . $pet->getName() . "</td>";
            echo "<td>" . $pet->getAge() . "</td>";
            echo "<td>" . $pet->getGender() . "</td>";
            echo "<td>" . $pet->getSpecies() . "</td>";
            echo "<td>" . $pet->getNotes() . "</td>";
            echo "</tr>";
         }
			echo "</tbody>";
         echo "</table>";
		} else echo "No pets found.";
		
		echo "<hr>";
		include 'add_pet.php'; // Add Pet form view + controller
	}
}
?>