<?php
include '../utils/displayErrors.php';
class Pet
{
	private $petID; // retrieve from DB
	private $name; // Pet name
	private $age;
	private $gender;
	private $species;
	private $notes;
	private $ownerID; // retrieve from DB
	
	public function __construct($id, $name, $age, $gender, $species, $notes, $ownerId) {
    	$this->id = $id;
    	$this->name = $name;
    	$this->age = $age;
    	$this->gender = $gender;
    	$this->species = $species;
    	$this->notes = $notes;
    	$this->ownerId = $ownerId;
  }

	public function getPetID(){
		return $this->petID;
	}
	// No setPetID
	
	public function getName(){
		return $this->name;
	}
	public function setName($newName){
		$this->name = $newName;
	}
	
	public function getAge() {
  		if ($this->age!=null) return $this->age;
  		return "NaN";
	}
	public function setAge($newAge) {
  		$this->age = $newAge;
	}
	
	public function getGender() {
  		return $this->gender;
	}
	public function setGender($newGender) {
  		$this->gender = $newGender;
	}
	
	public function getSpecies() {
  		if ($this->species!=null) return $this->species;
  		return "Not specified."; 
	}
	public function setSpecies($newSpecies) {
  		$this->species = $newSpecies;
	}
	
	public function getNotes() {
  		if ($this->notes!=null) return $this->notes;
  		return "Not specified."; 
	}
	public function setNotes($newNotes) {
  		$this->notes = $newNotes;
	}
	
	public function getOwnerID(){
		return $this->ownerID;	
   }
}

if ($_SESSION['role'] == 'owner') 
{
   $pets = []; // Initialize an empty array to store Pet objects

   $sql = "SELECT * FROM pet WHERE ownerid = (SELECT ownerid FROM owner WHERE email = $1)";
   $result = pg_prepare($conn, "my_pets", $sql); // Prepare the SQL statement for efficiency
   $result = pg_execute($conn, "my_pets", [$_SESSION['email']]);

   $num = pg_num_rows($result);

   if ($num > 0) 
   {
		while ($row = pg_fetch_row($result)) 
		{
      	$pet = new Pet(
      		$row[0], // petID
        		$row[1], // name
        		$row[2], // age (null check handled in constructor)
        		$row[3], // gender
        		$row[4], // species (null check handled in constructor)
        		$row[5], // notes (null check handled in constructor)
        		$row[6]  // ownerID
      	);
      	$pets[] = $pet; // Add the Pet object to the pets array
    	}
  	}
}
?>