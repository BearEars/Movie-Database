<html>
<head>
        <title>Inserting movie</title>
        <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>

<?php
	include 'movie_db_funcs.php';
        session_start(); // can use this to verify user is logged in
        if (!isset($_SESSION["username"]) || !$_SESSION["manager"]) {
                header("Location: /~twecto2/CS405/Movie-Database/home.html");
                exit;
        }
	$username = $_SESSION["username"];
        
        echo "<div id=\"top\">";
        echo "\t<p style=\"font-size:75%\">Logged in as: ".$username."<br>";
        echo "You have manager privileges!<br>";
        echo "\t<a href=\"logout.php\">Log Out</a></p>";
        echo "</div>";

        $link = establishLink();
        
	$movieId = insertMovieTable($_POST, $link);

	insertLanguages($link, $movieId, $_POST);
	insertGenres($link, $movieId, $_POST);
	insertTags($link, $movieId, $_POST);
	insertActors($link, $movieId, $_POST);
	insertDirectors($link, $movieId, $_POST);
	insertProducers($link, $movieId, $_POST);
	insertEditors($link, $movieId, $_POST);
	insertScreenwriters($link, $movieId, $_POST);

        echo "Movie successfully added!<br>";
        echo "<a href=\"main.php\">Return to Search</a>";

?>


</body>
</html>
