<?php
class Record {
  	private $id;
  	private $serviceId;
  	private $petId;
  	private $staffId;
  	private $time;
  	private $note;

  	public function __construct($id, $serviceId, $petId, $staffId, $time, $note) {
    	$this->id = $id;
    	$this->serviceId = $serviceId;
    	$this->petId = $petId;
    	$this->staffId = $staffId;
    	$this->time = $time;
    	$this->note = $note;
  	}

	public function getId() {
    	return $this->id;
  	}

  	public function getServiceId() {
    	return $this->serviceId;
  	}

  	public function getPetId() {
    	return $this->petId;
  	}

  	public function getStaffId() {
    	return $this->staffId;
  	}

  	public function getTime() {
    	return $this->time;
  	}

  	public function getNote() {
    	return $this->note;
  	}

  	public function setId($id) {
    	$this->id = $id;
  	}

  	public function setServiceId($serviceId) {
    	$this->serviceId = $serviceId;
  	}

  	public function setPetId($petId) {
    	$this->petId = $petId;
  	}

  	public function setStaffId($staffId) {
    	$this->staffId = $staffId;
  	}

  	public function setTime($time) {
    	$this->time = $time;
  	}

  	public function setNote($note) {
    	if ($note != null)
    		$this->note = $note;
    	else 
    		$this->note = "None";
  	}
?>