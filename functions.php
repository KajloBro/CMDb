<?php


////////////////////////////////////////////////FUNCTIONS////////////////////////////////////////////////////

//DATABASE CONTAINS RATING SUM AND NUMBER OF VOTES
//THIS FUNCTION CALCULATES DYNAMIC RATING OUT OF THOSE TWO VARIABLES
//RETURNS 0 IF THERE IS NO VOTES AT ALL
function calculateRating($rating_sum, $votes) {
    if ($votes == 0) {
        return 0.0;
    }
    else {
        $rating = (float) ($rating_sum / $votes);
        $rating = number_format((float)$rating, 2, '.', '');
        return $rating;
    }
}

//FUNCTION RETURNS EITHER FORMATED YEAR OF DEATH OR FORMATED EMPTY STRING
function dumpYearOfDeathIfExists($year) {
    if ($year == 0) {
        return ")";
    }
    else {
        return '-'.$year.')';
    }
}


/////////////////////////////////////MOVIES SEARCHES, SORTS, FILTERS/////////////////////////////////////////

//SEARCH QUERY FOR MOVIES
function moviesSearch($data) {
    if (isset($_GET['sort'])) {unset($_GET['sort']);}
    if (isset($_GET['filter'])) {unset($_GET['filter']);}
    $search = $_GET['search'];
    $search_query = array();
    foreach($data as $row){
        if (stripos($row['title'], $search) !== false) {
            $search_query[] = $row;
        }
    }
    if (count($search_query) > 0) {
        return $search_query;
    }
    else {
        echo '<div class="container text-center mg_30_top">';
            echo 'Bullocks... Try again';
        echo '</div>';
        return $data;
    }
}

//SORT SWITCH FOR MOVIES
function moviesSortSwitch($data) {
    $sort = $_GET['sort'];
    switch($sort){
        case 'By release year':
            usort($data, "moviesCmpByYear");
            return $data;
            break;

        case 'By rating':
            usort($data, "moviesCmpByRating");
            return $data;
            break;

        case 'By popularity':
            usort($data, "moviesCmpByPopular");
            return $data;
            break;

        case 'By duration':
            usort($data, "moviesCmpByDuration");
            return $data;
            break;

        default:
            usort($data, "moviesCmpByAlpha");
            return $data;
            break;
    }
}

//COMPARE MOVIES BY RATING
function moviesCmpByRating($a, $b) {
    return strcmp(calculateRating($b['rating_sum'], $b['votes']), calculateRating($a['rating_sum'], $a['votes']));
}

//COMPARE MOVIES BY RELEASE YEAR
function moviesCmpByYear($a, $b) {
    return $a['release_year'] - $b['release_year'];
}

//COMPARE MOVIES BY TITLE (DEFAULT)
function moviesCmpByAlpha($a, $b) {
    return strcmp($a['title'], $b['title']);
}

//COMPARE MOVIES BY POPULARITY
function moviesCmpByPopular($a, $b) {
    return $a['votes'] - $b['votes'];
}

//COMPARE MOVIES BY DURATION
function moviesCmpByDuration($a, $b) {
    return $a['duration'] - $b['duration'];
}


/////////////////////////////////////STARS SEARCHES, SORTS, FILTERS/////////////////////////////////////////

//SEARCH QUERY FOR STARS
function starsSearch($data) {
    $search = $_GET['search'];
    $search_query = array();
    foreach($data as $row){
        if (stripos($row['last_name'], $search) !== false) {
            $search_query[] = $row;
        }
        else if (stripos($row['first_name'], $search) !== false) {
            $search_query[] = $row;
        }
        
    } 
    if (count($search_query) > 0) {
        return $search_query;
    }
    else {
        echo '<div class="container text-center mg_30_top">';
            echo 'Bullocks... Try again';
        echo '</div>';
        return $data;
    }
}

//SORT SWITCH FOR STARS
function starsSortSwitch($data) {
    $sort = $_GET['sort'];
    switch($sort){
        case 'By first name':
            usort($data, "starsCmpByFirst");
            return $data;
            break;

        case 'By birth year':
            usort($data, "starsCmpByBirth");
            return $data;
            break;

        case 'By death year':
            usort($data, "starsCmpByDeath");
            return $data;
            break;

        case 'By rating':
            usort($data, "starsCmpByRating");
            return $data;
            break;

        case 'By popularity':
            usort($data, "starsCmpByPopular");
            return $data;
            break;

        default:
            usort($data, "starsCmpByLast");
            return $data;
            break;
    }
}

//COMPARE STARS BY LAST NAME (DEFAULT)
function starsCmpByLast($a, $b) {
    return strcmp($a['last_name'],$b['last_name']);
}

//COMPARE STARS BY FIRST NAME
function starsCmpByFirst($a, $b) {
    return strcmp($a['first_name'],$b['first_name']);
}

//COMPARE STARS BY YEAR OF BIRTH
function starsCmpByBirth($a, $b) {
    return $a['year_of_birth'] - $b['year_of_birth'];
}

//COMPARE STARS BY YEAR OF DEATH
function starsCmpByDeath($a, $b) {
    return $b['year_of_death'] - $a['year_of_death'];
}

//COMPARE STARS BY RATING
function starsCmpByRating($a, $b) {
    return calculateRating($a['rating_sum'], $a['votes']) - calculateRating($b['rating_sum'], $b['votes']);
}

//COMPARE STARS BY POPULARITY (IN HOW MANY MOVIES DID THE STAR APPEAR)
function starsCmpByPopular($a, $b) {
    return $b['popularity'] - $a['popularity'];
}


///////////////////////////////////////////////////CMS///////////////////////////////////////////////////////
