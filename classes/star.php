<?php

class Star extends Database {

    private $id;
    private $first_name;
    private $last_name;
    private $image;
    private $description;
    private $rating_sum;
    private $votes;
    private $year_of_birth;
    private $year_of_death;
    private $is_actor;
    private $is_director;


    //GETTERS & SETTERS
    public function getId() {return $this->id;}

    public function setId($id){
        $this->id = $id;

        return $this;
    }

    public function getFirst_name() {return $this->first_name;}

    public function setFirst_name($first_name) {
        $this->first_name = $first_name;
        return $this;
    }

    public function getLast_name() {return $this->last_name;}

    public function setLast_name($last_name) {
        $this->last_name = $last_name;
        return $this;
    }

    public function getImage() {return $this->image;}

    public function setImage($image) {
        $this->image = $image;
        return $this;
    }

    public function getDescription() {return $this->description;}

    public function setDescription($description) {
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

    public function getYear_of_birth() {return $this->year_of_birth;}

    public function setYear_of_birth($year_of_birth) {
        $this->year_of_birth = $year_of_birth;
        return $this;
    }

    public function getYear_of_death() {return $this->year_of_death;}

    public function setYear_of_death($year_of_death) {
        $this->year_of_death = $year_of_death;
        return $this;
    }

    public function getIs_actor() {return $this->is_actor;}

    public function setIs_actor($is_actor) {
        $this->is_actor = $is_actor;
        return $this;
    }

    public function getIs_director() {return $this->is_director;}

    public function setIs_director($is_director) {
        $this->is_director = $is_director;
        return $this;
    }

    //RETURNS ALL DIRECTORS
    public function getAllDirectors() {
        //QUERY GETS * FROM STAR + POPULARITY (IN HOW MANY MOVIES THE DID STAR APPEAR)
        $sql = ("SELECT s.id, s.first_name, s.last_name, s.image, s.description, s.rating_sum, 
                 s.votes, s.year_of_birth, s.year_of_death, s.is_actor, s.is_director,
                 COUNT(CASE WHEN md.director_id = s.id THEN 1 ELSE 0 END) AS popularity
                 FROM movies_directors AS md 
                 LEFT JOIN stars AS s ON md.director_id = s.id 
                 WHERE s.is_director = 1
                 GROUP by s.id
                 ORDER BY s.last_name");
        $result = $this->connect()->query($sql);
        $num_rows = $result->num_rows;
        if ($num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $data = json_encode($data);
        return $data;
    }

    //RETURNS ALL ACTORS
    public function getAllActors() {
        //QUERY GETS * FROM STAR + POPULARITY (IN HOW MANY MOVIES DID THE STAR APPEAR)
        $sql = ("SELECT s.id, s.first_name, s.last_name, s.image, s.description, s.rating_sum, 
                 s.votes, s.year_of_birth, s.year_of_death, s.is_actor, s.is_director,
                 COUNT(CASE WHEN ma.actor_id = s.id THEN 1 ELSE 0 END) AS popularity
                 FROM movies_actors AS ma 
                 LEFT JOIN stars AS s ON ma.actor_id = s.id 
                 WHERE s.is_actor = 1
                 GROUP by s.id
                 ORDER BY s.last_name");
        $result = $this->connect()->query($sql);
        $num_rows = $result->num_rows;
        if ($num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $data = json_encode($data);
        return $data;
    }

    //RETURNS ONE DIRECTOR
    public function getOneDirector() {
        $id = $_GET['id'];
        $sql = ("SELECT * FROM stars WHERE id = $id");
        $result = $this->connect()->query($sql);
        $num_rows = $result->num_rows;
        if ($num_rows == 1) {
            $row = $result->fetch_assoc();
            $data = $row;
            $data = json_encode($data);
            return $data;
        }

        else {
            echo 'Sorry, there might be a problem with a director ID in the Database';
            return 0;
        }
    }

    //RETURNS ONE ACTOR
    public function getOneActor() {
        $id = $_GET['id'];
        $sql = ("SELECT * FROM stars WHERE id = $id");
        $result = $this->connect()->query($sql);
        $num_rows = $result->num_rows;
        if ($num_rows > 0) {
            $row = $result->fetch_assoc();
            $data = $row;
            $data = json_encode($data);
            return $data;
        }

        else {
            echo 'Sorry, there might be a problem with an actor ID in the Database';
            return 0;
        }
    }
    
}