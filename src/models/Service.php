<?php
class Service {
	private $id;
  	private $name;
  	private $description;
  	private $price;

  	public function __construct($id, $name, $description, $price) {
    	$this->id = $id;
    	$this->name = $name;
    	$this->description = $description;
    	$this->price = $price;
  	}
	
	public function getID(){
		return $this->id;
	}
	
	public function getName(){
		return $this->name;	
	}
	
	public function getDesc(){
		return $this->description;	
	}
	
	public function getPrice(){
		return $this->price;	
	}
	
	public function setName($name){
		$this->name = $name;	
	}
	
	public function setDesc($desc){
		$this->description = $desc;	
	}
	
	public function setPrice($price){
		$this->price = $price;	
	}
}
