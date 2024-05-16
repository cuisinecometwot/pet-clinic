<?php

class Owner{
  private $ownerID;
  private $name;
  private $email;
  private $phone;
  
  public function __construct($ownerID, $email, $name, $phone){
    $this->ownerID = ($ownerID >= 0) ? $ownerID : 0;
    $this->email = $email;
    $this->name = $name;
    $this->phone = $phone;
  }

	public function setOwnerID($newID){
		$this->ownerID = $newID;
	}
	
	public function setEmail($newEmail){
		$this->email = $newEmail;
	}  
  
	public function setName($newName){
    	$this->name = $newName;
  	}

  	public function setPhone($newPhone){
    	$this->phone = $newPhone;
  	}

  	public function getOwnerID(){
    	return $this->ownerID;
  	}

  	public function getName(){
    	return $this->name;
  	}

  	public function getPhone(){
    	return $this->phone;
  	}
  
  	public function getEmail(){
    	return $this->email;
  	}
  
}

?>
