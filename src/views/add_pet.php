<h3>Add Pet</h3>
<form action="add_pet.php" method="POST">
  	<div class="form-group">
    	<label for="petName">Pet Name</label>
    	<input type="text" class="form-control" id="petName" name="petName" required>
  	</div>
  	<div class="form-group">
    	<label for="petAge">Age</label>
    	<input type="number" class="form-control" id="petAge" name="petAge" min="1" required>
  	</div>
  	<div class="form-group">
    	<label for="petGender">Gender</label>
    	<select class="form-control" id="petGender" name="petGender" required>
      	<option value="Other">Other</option>
      	<option value="Male">Male</option>
      	<option value="Female">Female</option>
    	</select>
  	</div>
  	<div class="form-group">
    	<label for="petSpecies">Species</label>
    	<input type="text" class="form-control" id="petSpecies" name="petSpecies" required>
  	</div>
  	<div class="form-group">
    	<label for="petNote">Note (optional)</label>
    	<textarea class="form-control" id="petNote" name="petNote" rows="3"></textarea>
  	</div>
  	<button type="submit" class="btn btn-primary">+ Add</button>
</form>
<?php // controller
include '../utils/connect.php';
require '../models/Owner.php';
$query = "INSERT INTO pet (name, age, gender, species, note, ownerid) VALUES ($1, $2, $3, $4, $5, $6)";
$result = pg_prepare($conn, "insert_pet", $query);
$result = pg_execute($conn, "insert_pet", [$_POST['petName'],  $_POST['petAge'], 
															$_POST['petGender'],  $_POST['petSpecies'], 
															$_POST['petNote'], $owner->getOwnerID()]);
if ($result)
{
	echo "Pet added!";
}
else 
{
	echo "Something went wrong!";
}

?>
