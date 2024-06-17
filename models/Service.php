<?php
class Service {
  public $id;
  public $name;
  public $description;
  public $cost;

  public function __construct($id, $name, $description, $cost) {
    $this->id = $id;
    $this->name = $name;
    $this->description = $description;
    $this->cost = $cost;
  }

  public function getId() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }

  public function getDescription() {
    return $this->description;
  }

  public function getCost() {
    return $this->cost;
  }

  // Setter methods (optional with validation)
  public function setName($name) {
    if (strlen($name) > 50) {
      throw new Exception("Service name cannot be longer than 50 characters.");
    }
    $this->name = $name;
  }

  public function setDescription($description) {
    $this->description = $description;
  }

  public function setCost($cost) {
    if ($cost < 0) {
      throw new Exception("Service cost cannot be negative.");
    }
    $this->cost = $cost;
  }
}

include __DIR__ . '/../utils/connect.php';
$services = [];

$sql = "SELECT * FROM service_list"; 

$result = pg_prepare($conn, "service list", $sql);
$result = pg_execute($conn, "service list", []);

$num = pg_num_rows($result);

if ($num > 0) 
{
	while ($row = pg_fetch_row($result)) 
	{
      $service = new Service(
      	$row[0],
        	$row[1],
        	$row[2],
        	$row[3]
      );
      $services[] = $service;
    }
}
?>
