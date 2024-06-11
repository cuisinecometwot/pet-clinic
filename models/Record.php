<?php

abstract class Record 
{
  private $petId;
  private $date;
  private $time;

  public function __construct($petId, $date, $time) {
    $this->petId = $petId;
    $this->date = $date;
    $this->time = $time;
  }

  public function getPetId() {
    return $this->petId;
  }

  public function getDate() {
    return $this->date;
  }

  public function getTime() {
    return $this->time;
  }
}

class HealthRecord extends Record 
{
  private $veterinarian;
  private $medInstruction;
  private $dietInstructions;
  private $additionalInstructions;
  private $cost;

  public function __construct($petId, $date, $time, $cost, $veterinarian=null, $medInstruction=null, $dietInstructions=null, $additionalInstructions=null) {
    parent::__construct($petId, $date, $time);
    $this->veterinarian = $veterinarian;
    $this->medInstruction = $medInstruction;
    $this->dietInstructions = $dietInstructions;
    $this->additionalInstructions = $additionalInstructions;
    $this->cost = $cost;
  }

  public function getVeterinarian() {
    return $this->veterinarian;
  }

  public function getMedInstruction() {
    return $this->medInstruction;
  }

  public function getDietInstructions() {
    return $this->dietInstructions;
  }

  public function getAdditionalInstructions() {
    return $this->additionalInstructions;
  }

  public function getCost() {
    return $this->cost;
  }
}

class BeautyService extends Record 
{
  private $serviceType;
  private $serviceProvider;
  private $notes;
  private $cost;

  public function __construct($petId, $date, $time, $cost, $serviceType=null, $serviceProvider=null, $notes=null) {
    parent::__construct($petId, $date, $time);
    $this->serviceType = $serviceType;
    $this->serviceProvider = $serviceProvider;
    $this->notes = $notes;
    $this->cost = $cost;
  }

  public function getServiceType() {
    return $this->serviceType;
  }

  public function getServiceProvider() {
    return $this->serviceProvider;
  }

  public function getNotes() {
    return $this->notes;
  }

  public function getCost() {
    return $this->cost;
  }
}
// test


$healthRecord = new HealthRecord(5, "2024-06-24", "09:00", 50000);
var_dump($healthRecord);
?>