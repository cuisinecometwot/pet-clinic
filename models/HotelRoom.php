<?php
class HotelRoom {
    private $id;
    private $size;
    private $occupied;
    private $price;
    private $imageLink;

    public function __construct($id, $size, $occupied, $price, $imageLink) {
        $this->id = $id;
        $this->size = $size;
        $this->occupied = $occupied;
        $this->price = $price;
        $this->imageLink = $imageLink;
    }

    public function getId() {
        return $this->id;
    }

    public function getSize() {
        return $this->size;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function isOccupied() {
        return $this->occupied;
    }

    public function setOccupied($occupied) {
        $this->occupied = $occupied;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getImageLink() {
        return $this->imageLink;
    }

    public function setImageLink($imageLink) {
        $this->imageLink = $imageLink;
    }
}
?>