<?php
class HotelRoom {
    private $id;
    private $description;
    private $petID;
    private $condition;
    private $imageLink;

    public function __construct($id, $description, $petID, $condition, $imageLink) {
        $this->id = $id;
        $this->description = $description;
        $this->petID = $petID;
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

    public function getPetID() {
        return $this->petID;
    }

    public function setPetID($petID) {
        $this->petID = $petID;
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