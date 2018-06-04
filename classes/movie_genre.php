<?php 

class MovieGenre extends Database {

    private $movie_id;
    private $genre_id;


    //GETTERS & SETTERS
    public function getMovie_id() {return $this->movie_id;}

    public function setMovie_id($movie_id) {
        $this->movie_id = $movie_id;
        return $this;
    }

    public function getGenre_id() {return $this->genre_id;}

    public function setGenre_id($genre_id) {
        $this->genre_id = $genre_id;
        return $this;
    }

    //RETURNS ALL GENRES FROM ONE MOVIE
    public function getMovieGenres() {
        $movie_id = $_GET['id'];
        $sql = ("SELECT g.genre FROM genres AS g 
        JOIN movies_genres AS mg ON mg.genre_id = g.id 
        JOIN movies AS m ON m.id = mg.movie_id 
        WHERE m.id = $movie_id");
        $result = $this->connect()->query($sql);
        $num_rows = $result->num_rows;
        if ($num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $data = json_encode($data);
            return $data;
        }
    }

    //RETURNS ALL MOVIES WITH GIVEN GENRE
    public function getGenreMovies($filter) {
        $sql = ("SELECT * FROM movies AS m 
                 JOIN movies_genres AS mg ON mg.movie_id = m.id 
                 JOIN genres AS g ON mg.genre_id = g.id
                 WHERE g.genre = '$filter'");
        $result = $this->connect()->query($sql);
        $num_rows = $result->num_rows;
        if ($num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $data = json_encode($data);
            return $data;
        }
    }

}