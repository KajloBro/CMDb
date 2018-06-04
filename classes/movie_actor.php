<?php

class MovieActor extends Database {

    private $movie_id;
    private $actor_id;


    //GETTERS & SETTERS
    public function getMovie_id() {return $this->movie_id;}

    public function setMovie_id($movie_id) {
        $this->movie_id = $movie_id;
        return $this;
    }

    public function getActor_id() {return $this->actor_id;}

    public function setActor_id($actor_id){
        $this->actor_id = $actor_id;
        return $this;
    }

    //RETURNS ALL ACTORS FROM ONE MOVIE
    public function getMovieActors() {
        $movie_id = $_GET['id'];
        $sql = ("SELECT s.id as actor_id, s.first_name, s.last_name, s.image, s.rating_sum, s.votes 
        FROM stars AS s
        JOIN movies_actors AS ma ON ma.actor_id = s.id 
        JOIN movies AS m ON m.id = ma.movie_id 
        WHERE m.id = $movie_id");
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

    //RETURNS ALL MOVIES FROM ONE ACTOR
    public function getActorMovies() {
        $actor_id = $_GET['id'];
        $sql = ("SELECT m.id as movie_id, m.title, m.image, m.rating_sum, m.votes 
            FROM movies AS m 
            JOIN movies_actors AS ma ON ma.movie_id = m.id 
            JOIN stars AS s ON s.id = ma.actor_id 
            WHERE s.id = $actor_id");
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
}