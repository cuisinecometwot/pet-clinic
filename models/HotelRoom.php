<?php
class HotelRoom {
    private $id;
    private $description;
    private $occupied;
    private $condition;
    private $imageLink;

    public function __construct($id, $description, $occupied, $condition, $imageLink) {
        $this->id = $id;
        $this->description = $description;
        $this->occupied = ($occupied === 't');
        $this->condition = $condition;
        $this->imageLink = $imageLink;
    }

    public function getId() {
        return $this->id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function isOccupied() {
        return $this->occupied;
    }

    public function setOccupied($occupied) {
        $this->occupied = $occupied;
    }

    public function getCondition() {
        return $this->condition;
    }

    public function setCondition($condition) {
        $this->condition = $condition;
    }

    public function getImageLink() {
        return $this->imageLink;
    }

    public function setImageLink($imageLink) {
        $this->imageLink = $imageLink;
    }
}
?>