<?php

class MovieDirector extends Database {

    private $movie_id;
    private $director_id;


    //GETTERS & SETTERS
    public function getMovie_id() {return $this->movie_id;}

    public function setMovie_id($movie_id) {
        $this->movie_id = $movie_id;
        return $this;
    }

    public function getDirector_id() {return $this->director_id;}

    public function setDirector_id($director_id){
        $this->director_id = $director_id;
        return $this;
    }

    //RETURNS ALL DIRECTORS FROM ONE MOVIE
    public function getMovieDirectors() {
        $movie_id = $_GET['id'];
        $sql = ("SELECT s.id as director_id, s.first_name, s.last_name, s.image, s.rating_sum, s.votes 
            FROM stars AS s
            JOIN movies_directors AS md ON md.director_id = s.id 
            JOIN movies AS m ON m.id = md.movie_id 
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

    //RETURNS ALL MOVIES FROM ONE DIRECTOR
    public function getDirectorMovies() {
        $director_id = $_GET['id'];
        $sql = ("SELECT m.id as movie_id, m.title, m.image, m.rating_sum, m.votes 
            FROM movies AS m 
            JOIN movies_directors AS md ON md.movie_id = m.id 
            JOIN stars AS s ON s.id = md.director_id 
            WHERE s.id = $director_id");
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

