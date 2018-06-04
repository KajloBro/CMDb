<?php

    include 'classes/conn.php';
    include 'views/home_view.php';

?>

<!DOCTYPE html>

<html>
<head>
    <title>Croatian Movie Database</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/normalize.css"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" 
              rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="icon" href="img/project/cmdb_icon.png"/>
</head>
<body>

    <?php

    include 'includes/header.php';

    //MAIN SWITCH
    if(isset($_GET['a'])) {$a = $_GET['a'];} else {$a = '';}
    switch($a) {
        case 'one_director':
            showOneDirector();
            break;

        case 'all_directors':
            showAllDirectors();
            break;

        case 'one_actor':
            showOneActor();
            break;

        case 'all_actors':
            showAllActors();
            break;

        case 'one_movie':
            showOneMovie();
            break;

        default:   
            showAllMovies();
            break;
    }
    
    include 'includes/footer.php';

    ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>
