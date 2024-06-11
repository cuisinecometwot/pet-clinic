<?php
class Profile
{
  private $profileID;
  private $name;
  private $email;
  private $phone;
  
  public function __construct($profileID, $name, $email, $phone){
    $this->profileID = ($profileID >= 0) ? $profileID : 0;
    $this->email = $email;
    $this->name = $name;
    $this->phone = $phone;
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

  	public function getProfileID(){
    	return $this->profileID;
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


$result = pg_prepare($conn, "my_query1", 'SELECT * FROM profile WHERE email = $1');
$result = pg_execute($conn, "my_query1", [$_SESSION['email']]);
$num = pg_num_rows($result);
if ($num == 1) 
{
  	$row = pg_fetch_row($result);
	$profile = new Profile($row[0], $row[1], $row[2], $row[3]);
}

?>
