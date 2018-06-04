<?php

class Movie extends Database {
    
    private $id;
    private $title;
    private $duration;
    private $image;
    private $description;
    private $rating_sum;
    private $votes;
    private $release_year;


    //GETTERS & SETTERS
    public function getId() {return $this->id;}

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getTitle() {return $this->title;}

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getDuration() {return $this->duration;}

    public function setDuration($duration) {
        $this->duration = $duration;
        return $this;
    }

    public function getImage() {return $this->image;}

    public function setImage($image) {
        $this->image = $image;
        return $this;
    }

    public function getDescription() {return $this->description;}

    public function setDescription($description){
        $this->description = $description;
        return $this;
    }

    public function getRating_sum() {return $this->rating_sum;}

    public function setRating_sum($rating_sum) {
        $this->rating_sum = $rating_sum;
        return $this;
    }

    public function getVotes() {return $this->votes;}
 
    public function setVotes($votes) {
        $this->votes = $votes;
        return $this;
    }

    public function getRelease_year() {return $this->release_year;}

    public function setRelease_year($release_year) {
        $this->release_year = $release_year;
        return $this;
    }

    private function getAttributes() {
        $data = array();
        $data['id'] = $this->id;
        $data['title'] = $this->title;
        $data['duration'] = $this->duration;
        $data['image'] = $this->image;
        $data['description'] = $this->description;
        $data['rating_sum'] = $this->rating_sum;
        $data['votes'] = $this->votes;
        $data['release_year'] = $this->release_year;
        return $data;
    }

    public function setAttributes($id, $title, $duration, $image, $description, $rating_sum, $votes, $release_year) {
        $this->id = $id;
        $this->title = $title;
        $this->duration = $duration;
        $this->image = $image;
        $this->description = $description;
        $this->rating_sum = $rating_sum;
        $this->votes = $votes;
        $this->release_year = $release_year;
    }

    //RETURNS ALL MOVIES
    public function getAllMovies() {
        $sql = ("SELECT * FROM movies ORDER BY title");
        $result = $this->connect()->query($sql);
        $num_rows = $result->num_rows;
        if ($num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        $data = json_encode($data);
        return $data;
        }
        else {
            echo 'Sorry, Database is empty';
            return 0;
        }
    }

    //RETURNS ONE MOVIE
    public function getOneMovie() {
        $id = $_GET['id'];
        $sql = ("SELECT * FROM movies WHERE id = $id");
        $result = $this->connect()->query($sql);
        $num_rows = $result->num_rows;
        if ($num_rows == 1) {
            $row = $result->fetch_assoc();
            $data = json_encode($row);
            return $data;
        }
        else {
            echo 'Sorry, there might be a problem with a movie ID in the Database';
            return 0;
        }
    }


    
}