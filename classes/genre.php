<?php

class Genre extends Database {
    
    private $id;
    private $genre;
    

    //GETTERS & SETTERS
    public function getId() {return $this->id;}

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getGenre() {return $this->genre;}

    public function setGenre($genre) {
        $this->genre = $genre;
        return $this;
    }

    
}