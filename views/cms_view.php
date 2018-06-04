<?php

function showCmsHomePage() {
    include 'includes/cms_navigation.php';
    ?>
    <div class="container">
        <div class="row mg_10_top">
            <div class="how_to">
                <h2> Hello fellow user. </h2>
                <br>
                <p>You are looking at Croatian Movie Database open source content management service.</p>
                <p>You can insert new movies, genres, actors and directors, as well alter and drop them.</p>
                <br>
                <p>About:</p> 
                <ol>
                <li> Database contains only Croatian movies since 1991 (Croatian indepence day) </li>
                <li> As initial movie rating please consider typing official IMDB rating.</li>
                <li> Not all actors/directors are Croatian. Database contains stars releated with movies 
                    (nationality does NOT matter)</li>
                <li> If there is a Croatian actor or director who is not related with any movie in Database he will NOT be in DB as well.
                <li> Somebody had a tough time collecting data, do NOT insert nor alter fake information.</li>
                </ol>    
            </div>    
        </div>
    </div>
    
    <?php
}

function insertMovieForm() {
    movieStepOne();
}

function movieStepOne() {
    
    if (empty($_POST["title"])) {

        //INSERT MOVIE NAVIGATION AND HEADER
        include 'includes/cms_navigation.php';
        ?>
        <div class="container">
            <div class="row mg_10_top text-center">
                <div class="col-12">
                    <p class="step_txt">Step 1: Insert movie data</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <hr class="progress_line"/>
                </div>
                <div class="col-3">
                    <hr class="invert_progress_line"/>
                </div>
                <div class="col-3">
                    <hr class="invert_progress_line"/>
                </div>
                <div class="col-3">
                    <hr class="invert_progress_line"/>
                </div>
            </div>
        </div>
        
        <!-- INSERT MOVIE FORM -->
        <div class="container">
            <div class="row mg_10_top">
                <div class="col-12">
                    <form action="cms.php?a=insert_movie" method="post" name="movie_step_one">
                        <div class="form-group pd_15_top_bot mg_0_bot">
                            <input type="text" name="title" id="insertTitle" class="form-control" placeholder="Enter movie title">
                            <small  class="form-text text-muted">* e.g. Kako je počeo rat na mom otoku</small>
                        </div>
                        <div class="form-group pd_15_bot mg_0_bot">
                            <input type="number" name="duration" id="insertDuration" class="form-control" 
                            placeholder="Enter movie duration in minutes">
                            <small  class="form-text text-muted">* e.g. 200</small>
                        </div>
                        <div class="form-group pd_15_bot mg_0_bot">
                            <textarea name="description" id="insertDescription" class="description_area" rows="5" 
                            placeholder="Enter description (optional)"></textarea>
                            <small  class="form-text text-muted">e.g. Bacon ipsum</small>
                        </div>
                        <div class="form-group pd_15_bot mg_0_bot">
                            <input type="number" step="0.1" name="rating" id="insertRating" class="form-control" 
                            placeholder="Enter initial IMDb rating">
                            <small  class="form-text text-muted">* e.g. 8,2</small>
                        </div>
                        <div class="form-group pd_15_bot mg_0_bot">
                            <input type="number" name="release_year" id="insertReleaseYear" class="form-control" 
                            placeholder="Enter release year">
                            <small  class="form-text text-muted">* e.g. 1998</small>
                        </div>
                        <div class="form-group pd_15_bot mg_0_bot">
                            <input type="text" name="img_path" id="insertImgPath" class="form-control" 
                            placeholder="Enter image path">
                            <small  class="form-text text-muted">* e.g. img/movies/kako_je_poceo_rat_na_mom_otoku.jpg</small>
                        </div>
                        <button type="submit" class="btn btn-primary mg_15_bot">Proceed</button>
                    </form>
                </div>
            </div>
        </div>

        <?php
    }

    else {
        //FETCH POST DATA
        $title = $_POST['title'];
        $duration = $_POST['duration'];
        $description = $_POST['description'];
        $rating = $_POST['rating'];
        $release_year = $_POST['release_year'];
        $img_path = $_POST['img_path'];
        
        //VERIFY SUBMITTED DATA
        $verification_title = true;
        if ($title === '') {$verification_title = false;}

        $verification_duration = true;
        if ($duration < 30 || $duration > 300 || !(is_int($duration)) == FALSE) {$verification_duration = false;} 
        
        $verification_description = true;
        if ($description == '') {
            $description = 'Bacon ipsum dolor amet landjaeger spare ribs boudin, 
            short ribs ground round biltong beef ribs turkey frankfurter. 
            Short loin cupim swine, spare ribs frankfurter meatball strip 
            steak pork burgdoggen tri-tip ham chicken sausage leberkas. 
            Flank cupim beef ribs biltong chicken leberkas short loin pork belly 
            ground round kielbasa buffalo. Ribeye alcatra sirloin bacon sausage fatback 
            pastrami tail frankfurter. Bacon rump sausage short loin turkey frankfurter shankle 
            tongue chuck swine shoulder tri-tip.';
        }

        $verification_rating = true;
        if (!(is_float($rating)) == FALSE || $rating == null) {$verification_rating = false;}
        else {$rating = number_format((float)$rating, 1, '.', '');}

        $verification_release_year = true;
        if ($release_year < 1990 || $release_year > 2020 || !(is_int($release_year)) == FALSE) {
            $verification_release_year = false;
        }

        $verification_img_path = true;
        if ($verification_img_path == '') {
            $img_path = 'img/movies/empty.png';
        }

        //CHECK IF ALL VERIFICATIONS ARE TRUE
        $verification = $verification_title * $verification_duration * $verification_description * $verification_rating * 
                        $verification_release_year * $verification_img_path;

        if ($verification) {
            require_once 'classes/conn.php';
            $data['title'] = $title;
            $data['duration'] = $duration;
            $data['description'] = $description;
            $data['rating'] = $rating;
            $data['release_year'] = $release_year;
            $data['img_path'] = $img_path;
            
            movieStepTwo($data);
        }

        else {
            // TO DO: FOR EVERY IF SET JS ALERT
            // TMP CODE
            if (!$verification_title) {echo 'Wrong title';} 
            if (!$verification_rating) {echo 'Wrong rating';}
            if (!$verification_release_year) {echo 'Wrong release_year';}
            if (!$verification_img_path) {echo 'Wrong img_path';}
            if (!$verification_duration) {echo 'Wrong duration';}
            if (!$verification_description) {echo 'Wrong description';}
            unset($_POST['title']);
            unset($_POST['duration']);
            unset($_POST['description']);
            unset($_POST['img_path']);
            unset($_POST['release_year']);
            unset($_POST['rating']);
            movieStepOne();
        }
        

        
    }
}

function movieStepTwo($data) {
    
}