<?php

require_once ('functions.php'); 

//VIEW 1: ALL MOVIES
function showAllMovies() {

    //CHECK IF USER SET FILTER; IF TRUE CALL A FILTERED QUERY BY GENRE
    if (isset($_GET['filter'])) {
        require_once('classes/movie_genre.php');
        $filter = $_GET['filter'];
        $movie_genre = new MovieGenre();
        $json = $movie_genre->getGenreMovies($filter);
        $data = json_decode($json, true);
    }

    else {
        require_once('classes/movie.php');
        $movies = new Movie();
        $json = $movies->getAllMovies();
        $data = json_decode($json, true);
    }
    
    //CHECK IF USER SEARCHED STH; IF TRUE CALL A FUNCTION FROM FUNCTIONS.PHP
    if (isset($_GET['search']) && $_GET['search'] != '') {$data = moviesSearch($data);}

    //CHECK IF USER SET SORT; IF TRUE CALL A FUNCTION FROM FUNCTIONS.PHP
    if (isset($_GET['sort'])) {
        $data = moviesSortSwitch($data);
    }

    include 'includes/movies_sort_and_search.php';

    //DUMPING DATA INTO TABLE
    $increment = 1;
    foreach ($data as $row) {
        $rating = calculateRating((float)$row['rating_sum'], (int)$row['votes']);//FROM functions.php
        //ECHOING
        echo '<div class="container">';
            echo '<div class="mg_3_top">';
                echo '<a href="index.php?a=one_movie&id='.$row['id'].'" class="format_anchor_txt">';
                    echo '<div class="row row_is_link">';
                        echo '<div class="col-1 text-center table_height_align">';
                            echo $increment;
                        echo '</div>';
                        echo '<div class="col-2 text-center">';
                            echo '<img src="'.$row['image'].'" alt="'.$row['title'].'" class="movie_list_image_size">';
                        echo '</div>';
                        echo '<div class="col-4 text-center table_height_align">';
                            echo $row['title'].'('.$row['release_year'].')'.' ';
                        echo '</div>';
                        echo '<div class="offset-3"></div>';
                        echo '<div class="col-1 text-center table_height_align">';
                            echo $rating;
                        echo '</div>';
                        echo '<div class="offset-1"></div>';
                    echo '</div>';
                echo '</a>';
            echo '</div>';
        echo '</div>';
        $increment++;
    }
}

//VIEW 2: ALL DIRECTORS
function showAllDirectors() {

    //FETCHING DATA
    require_once('classes/star.php');
    $director = new Star();
    $json = $director->getAllDirectors();
    $data = json_decode($json, true);

    //CHECK IF USER SEARCHED STH; IF TRUE CALL A FUNCTION FROM FUNCTIONS.PHP
    if (isset($_GET['search']) && $_GET['search'] != '') {$data = starsSearch($data);}

    //CHECK IF USER SET SORT; IF TRUE CALL A FUNCTION FROM FUNCTIONS.PHP
    if (isset($_GET['sort'])) {
        $data = starsSortSwitch($data);
    } 

    //FORM WITH SORT BY SELECT LIST AND SEARCH BAR
    include 'includes/stars_sort_and_search.php';

    //DUMPING DATA INTO TABLE
    $increment = 1;
    foreach ($data as $row) {
        $rating = calculateRating((float)$row['rating_sum'], (int)$row['votes']);//FROM functions.php
        //ECHOING
        echo '<div class="container">';
            echo '<div class="mg_3_top">';
                echo '<a href="index.php?a=one_director&id='.$row['id'].'" class="format_anchor_txt">';
                    echo '<div class="row row_is_link">';
                        echo '<div class="col-1 text-center table_height_align">';
                            echo $increment;
                        echo '</div>';
                        echo '<div class="col-2 text-center">';
                            echo '<img src="'.$row['image'].'" alt="'.$row['last_name'].'" class="director_list_image_size">';
                        echo '</div>';
                        echo '<div class="col-4 text-center table_height_align">';
                            echo $row['first_name'].' '.$row['last_name'];
                        echo '</div>';
                        echo '<div class="offset-3"></div>';
                        echo '<div class="col-1 text-center table_height_align">';
                            echo $rating;
                        echo '</div>';
                        echo '<div class="offset-1"></div>';
                    echo '</div>';
                echo '</a>';
            echo '</div>';
        echo '</div>';
        $increment++;
    }
}

//VIEW 3: ALL ACTORS
function showAllActors() {

    //FETCHING DATA
    require_once('classes/star.php');
    $actor = new Star();
    $json = $actor->getAllActors();
    $data = json_decode($json, true);

    //CHECK IF USER SEARCHED STH; IF TRUE CALL A FUNCTION FROM FUNCTIONS.PHP
    if (isset($_GET['search']) && $_GET['search'] != '') {$data = starsSearch($data);}

    //CHECK IF USER SET SORT; IF TRUE CALL A FUNCTION FROM FUNCTIONS.PHP
    if (isset($_GET['sort'])) {
        $data = starsSortSwitch($data);
    } 

    //FORM WITH SORT BY SELECT LIST AND SEARCH BAR
    include 'includes/stars_sort_and_search.php';

    //DUMPING DATA INTO TABLE
    $increment = 1;
    foreach ($data as $row) {
        $rating = calculateRating((float)$row['rating_sum'], (int)$row['votes']);//FROM functions.php
        //ECHOING
        echo '<div class="container">';
            echo '<div class="mg_3_top">';
                echo '<a href="index.php?a=one_actor&id='.$row['id'].'" class="format_anchor_txt">';
                    echo '<div class="row row_is_link">';
                        echo '<div class="col-1 text-center table_height_align">';
                            echo $increment;
                        echo '</div>';
                        echo '<div class="col-2 text-center">';
                            echo '<img src="'.$row['image'].'" alt="'.$row['last_name'].'" class="actor_list_image_size">';
                        echo '</div>';
                        echo '<div class="col-4 text-center table_height_align">';
                            echo $row['first_name'].' '.$row['last_name'];
                        echo '</div>';
                        echo '<div class="offset-3"></div>';
                        echo '<div class="col-1 text-center table_height_align">';
                            echo $rating;
                        echo '</div>';
                        echo '<div class="offset-1"></div>';
                    echo '</div>';
                echo '</a>';
            echo '</div>';
        echo '</div>';
        $increment++;
    }
}

//VIEW 4: A MOVIE
function showOneMovie() {
    //FETCHING MOVIE, GENRES, DIRECTORS AND ACTORS
    require_once('classes/movie.php');
    require_once('classes/movie_genre.php');
    require_once('classes/movie_director.php');
    require_once('classes/movie_actor.php');
    $movie = new Movie();
    $movie_genre = new MovieGenre();
    $movie_director = new MovieDirector();
    $movie_actor = new MovieActor();
    $json_movie = $movie->getOneMovie();
    $json_genre = $movie_genre->getMovieGenres();
    $json_director = $movie_director->getMovieDirectors();
    $json_actor = $movie_actor->getMovieActors();
    $data = json_decode($json_movie, true);
    $genres = json_decode($json_genre, true);
    $directors = json_decode($json_director, true);
    $actors = json_decode($json_actor, true);

    //DUMPING MOVIE DATA
    $rating = calculateRating((float)$data['rating_sum'], (int)$data['votes']);//FROM functions.php
    echo '<div class="container">';
        echo '<div class="row mg_30_top">';
            echo '<div class="col-4 pd_15_top_bot">';
                echo '<img src="'.$data['image'].'" alt="'.$data['title'].'" id="movie_fit_image">';        
            echo '</div>';
            echo '<div class="col-8 pd_15_top_bot">';
                echo '<div class="row">';
                    echo '<div class="col-12">';
                        echo '<h2 class="text-center">';
                            echo $data['title'];
                            echo '('.$data['release_year'].')';
                        echo '</h2>';
                    echo '</div>';
                echo '</div>';
                echo '<hr class="custom_hr">';
                echo '<div class="row mg_30_top">';
                    echo '<div class="col-3">';
                        echo '<p class="text-left duration_genres_format_txt mg_0_bot">';
                            echo $data['duration'].' min';
                        echo '</p>';
                    echo '</div>';
                    echo '<div class="col-9">';
                        echo '<p class="text-right votes_rating_format_txt mg_0_bot">';
                            echo 'Rating: <b>'.$rating.'</b> out of <b>'.$data['votes'].'</b> votes';
                        echo '</p>';
                    echo '</div>';
                echo '</div>';
                echo '<div class="row">';
                    echo '<div class="col-12">';
                        echo '<p class="text-left duration_genres_format_txt mg_0_bot">';
                            //$genres IS AN ASSOCIATIVE MULTIDIMENSIONAL ARRAY FETCHED FROM JSON
                            //$genre IS ONE ASSOCIATIVE ARRAY
                            //['genres'] IS A KEY OF AN ARRAY WHICH CONTAINS VALUES LIKE (drama, crime, etc)
                            foreach ($genres as $genre){
                                echo $genre['genre'].' ';
                            }
                        echo '</p>';
                    echo '</div>';
                echo '</div>';
                echo '<hr class="custom_hr">';
                echo '<div class="row mg_50_top">';
                    echo '<div class="col-12">';
                        echo '<p id="plot_format_txt">Plot:</p>';
                        echo $data['description'];
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

    
    // DUMPING DIRECTOR(S)

    //PREPARE TABLE HEADING
    $director_increment = 1;
    echo '<div class="container">';
        echo '<div class="row mg_30_top">';
            echo '<div class="col-12">';
                echo '<h2 class="text-center">';
                    echo 'Directors';
                echo '</h2>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
    //DUMPING DIRECTORS DATA
    foreach ($directors as $director) {
        $rating = calculateRating((float)$director['rating_sum'], (int)$director['votes']);//FROM functions.php
        echo '<div class="container">';
            echo '<a href="index.php?a=one_director&id='.$director['director_id'].'" class="format_anchor_txt" >';
                echo '<div class="row mg_3_top row_is_link">';
                    echo '<div class="col-1 text-center table_height_align">';
                        echo $director_increment;
                    echo '</div>';
                    echo '<div class="col-2 text-center">';
                        echo '<img src="'.$director['image'].'" alt="'.$director['last_name'].'" class="director_list_image_size">';
                    echo '</div>';
                    echo '<div class="col-4 text-center table_height_align">';
                        echo $director['first_name'].' '.$director['last_name'].'';
                    echo '</div>';
                    echo '<div class="offset-3"></div>';
                    echo '<div class="col-1 text-center table_height_align">';
                        echo $rating;
                    echo '</div>';
                echo '</div>';
            echo '</a>';
        echo '</div>';
        $director_increment++;
    }

    
    // DUMPING ACTOR(S)

    //PREPARE TABLE HEADING
    $actor_increment = 1;
    echo '<div class="container">';
        echo '<div class="row mg_30_top">';
            echo '<div class="col-12">';
                echo '<h2 class="text-center">';
                    echo 'Cast';
                echo '</h2>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
    //DUMPING ACTORS DATA
    foreach ($actors as $actor) {
        $rating = calculateRating((float)$actor['rating_sum'], (int)$actor['votes']);//FROM functions.php
        echo '<div class="container">';
            echo '<a href="index.php?a=one_actor&id='.$actor['actor_id'].'" class="format_anchor_txt">';
                echo '<div class="row mg_3_top row_is_link">';
                    echo '<div class="col-1 text-center table_height_align">';
                        echo $actor_increment;
                    echo '</div>';
                    echo '<div class="col-2 text-center">';
                        echo '<img src="'.$actor['image'].'" alt="'.$actor['last_name'].'" class="actor_list_image_size">';
                    echo '</div>';
                    echo '<div class="col-4 text-center table_height_align">';
                        echo $actor['first_name'].' '.$actor['last_name'].'';
                    echo '</div>';
                    echo '<div class="offset-3"></div>';
                    echo '<div class="col-1 text-center table_height_align">';
                        echo $rating;
                    echo '</div>';
                echo '</div>';
            echo '</a>';
        echo '</div>';
        $actor_increment++;
    }
}

//VIEW 5: A DIRECTOR
function showOneDirector() {

    //FETCHING DIRECTOR AND HIS MOVIES
    require_once('classes/star.php');
    require_once('classes/movie_director.php');
    $director = new Star();
    $director_movie = new MovieDirector();
    $json = $director->getOneDirector();
    $json_movie = $director_movie->getDirectorMovies();
    $data = json_decode($json, true);
    $movies = json_decode($json_movie, true);

    //DUMPING DIRECTORS DATA
    $rating = calculateRating((float)$data['rating_sum'], (int)$data['votes']);//FROM functions.php
    echo '<div class="container">';
        echo '<div class="row mg_30_top">';
            echo '<div class="col-6 pd_15_top_bot">';
                echo '<img src="'.$data['image'].'" alt="'.$data['last_name'].'" class="star_fit_image">';
            echo '</div>';
            echo '<div class="col-6 pd_15_top_bot">';
                echo '<div class="row">';
                    echo '<div class="col-12">';
                        echo '<h2 class="text-center">';
                            echo $data['first_name'].' ';
                            echo $data['last_name'].' (';
                            echo $data['year_of_birth'];
                            echo dumpYearOfDeathIfExists($data['year_of_death']);
                        echo '</h2>';
                    echo '</div>';
                echo '</div>';
                echo '<hr class="custom_hr">';
                echo '<div class="row mg_10_top">';
                    echo '<div class="offset-6"';
                    echo '<div class="col-6">';
                        echo '<p class="text-right votes_rating_format_txt mg_0_bot">';
                            echo 'Rating: <b>'.$rating.'</b> out of <b>'.$data['votes'].'</b> votes';
                        echo '</p>';
                    echo '</div>';
                echo '</div>';
                echo '<hr class="custom_hr">';
                echo '<div class="row mg_30_top">';
                    echo '<div class="col-12">';
                        echo '<p id="plot_format_txt">Biography:</p>';
                        echo $data['description'];
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

    
    //DUMPING MOVIE(S)

    //PREPARE TABLE HEADING
    $movie_increment = 1;
    echo '<div class="container">';
        echo '<div class="row mg_30_top">';
            echo '<div class="col-12">';
                echo '<h2 class="text-center">';
                    echo 'Movies';
                echo '</h2>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
    //DUMPING MOVIES DATA
    foreach ($movies as $movie) {
        $rating = calculateRating((float)$movie['rating_sum'], (int)$movie['votes']);//FROM functions.php
        echo '<div class="container">';
            echo '<a href="index.php?a=one_movie&id='.$movie['movie_id'].'" class="format_anchor_txt" >';
                echo '<div class="row mg_3_top row_is_link">';
                    echo '<div class="col-1 text-center table_height_align">';
                        echo $movie_increment;
                    echo '</div>';
                    echo '<div class="col-2 text-center">';
                        echo '<img src="'.$movie['image'].'" alt="'.$movie['title'].'" class="movie_list_image_size">';
                    echo '</div>';
                    echo '<div class="col-4 text-center table_height_align">';
                        echo $movie['title'].'';
                    echo '</div>';
                    echo '<div class="offset-3"></div>';
                    echo '<div class="col-1 text-center table_height_align">';
                        echo $rating;
                    echo '</div>';
                echo '</div>';
            echo '</a>';
        echo '</div>';
        $movie_increment++;
    }
}

//VIEW 6: AN ACTOR
function showOneActor() {

    //FETCHING ACTOR AND HIS MOVIES
    require_once('classes/star.php');
    require_once('classes/movie_actor.php');
    $actor = new Star();
    $actor_movie = new MovieActor();
    $json = $actor->getOneActor();
    $json_movie = $actor_movie->getActorMovies();
    $data = json_decode($json, true);
    $movies = json_decode($json_movie, true);

    //DUMPING ACTORS DATA
    $rating = calculateRating((float)$data['rating_sum'], (int)$data['votes']);//FROM functions.php
    echo '<div class="container">';
        echo '<div class="row mg_30_top">';
            echo '<div class="col-6 pd_15_top_bot">';
                echo '<img src="'.$data['image'].'" alt="'.$data['last_name'].'" class="star_fit_image">';
            echo '</div>';
            echo '<div class="col-6 pd_15_top_bot">';
                echo '<div class="row">';
                    echo '<div class="col-12">';
                        echo '<h2 class="text-center">';
                            echo $data['first_name'].' ';
                            echo $data['last_name'].' (';
                            echo $data['year_of_birth'];
                            echo dumpYearOfDeathIfExists($data['year_of_death']);
                        echo '</h2>';
                    echo '</div>';
                echo '</div>';
                echo '<hr class="custom_hr">';
                echo '<div class="row mg_10_top">';
                    echo '<div class="offset-6"';
                    echo '<div class="col-6">';
                        echo '<p class="text-right votes_rating_format_txt mg_0_bot">';
                            echo 'Rating: <b>'.$rating.'</b> out of <b>'.$data['votes'].'</b> votes';
                        echo '</p>';
                    echo '</div>';
                echo '</div>';
                echo '<hr class="custom_hr">';
                echo '<div class="row mg_30_top">';
                    echo '<div class="col-12">';
                        echo '<p id="plot_format_txt">Biography:</p>';
                        echo $data['description'];
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

    
    //DUMPING MOVIE(S)

    //PREPARE TABLE HEADING
    $movie_increment = 1;
    echo '<div class="container">';
        echo '<div class="row mg_30_top">';
            echo '<div class="col-12">';
                echo '<h2 class="text-center">';
                    echo 'Movies';
                echo '</h2>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
    //DUMPING MOVIES DATA
    foreach ($movies as $movie) {
        $rating = calculateRating((float)$movie['rating_sum'], (int)$movie['votes']);//FROM functions.php
        echo '<div class="container">';
            echo '<a href="index.php?a=one_movie&id='.$movie['movie_id'].'" class="format_anchor_txt" >';
                echo '<div class="row mg_3_top row_is_link">';
                    echo '<div class="col-1 text-center table_height_align">';
                        echo $movie_increment;
                    echo '</div>';
                    echo '<div class="col-2 text-center">';
                        echo '<img src="'.$movie['image'].'" alt="'.$movie['title'].'" class="movie_list_image_size">';
                    echo '</div>';
                    echo '<div class="col-4 text-center table_height_align">';
                        echo $movie['title'].'';
                    echo '</div>';
                    echo '<div class="offset-3"></div>';
                    echo '<div class="col-1 text-center table_height_align">';
                        echo $rating;
                    echo '</div>';
                echo '</div>';
            echo '</a>';
        echo '</div>';
        $movie_increment++;
    }
}