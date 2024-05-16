<?php
include 'displayErrors.php';
class Pet{
	private $petID; // retrieve from DB
	private $name; // Pet name
	private $age;
	private $gender;
	private $species;
	private $notes;
	private $ownerID; // retrieve from DB
	
	public function __construct($ownerID, $name, $gender, $age = null, $species = null, $notes = null){
		$this->name = $name;
		$this->age = $age;
		$this->gender = $gender;
		$this->species = $species;	
		$this->notes = $notes;
		$this->ownerID = $ownerID;
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
	// No setOwnerID
	
}

?>