<html>
<head>
        <title>Updating movie</title>
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
	echo "<a href=\"addManagers.php\">Add Manager</a><br>";
        echo "\t<a href=\"logout.php\">Log Out</a>";
	echo "<br><br><a href=\"myWatchlist.php\">My Watchlist</a>";
        echo "<br><a href=\"main.php\">Search</a></p>";
        echo "</div>";

        $link = establishLink();

	$movieId = $_POST["movieId"];
	$title = $_POST["title"];
	$summary = $_POST["summary"];
	$release = $_POST["release"];
	$duration = $_POST["duration"];

	updateMovieTable($link, $_POST);
	updateLanguageTable($link, $_POST);
	updateGenreTable($link, $_POST);
	updateTagTable($link, $_POST);
	updateActorTable($link, $_POST);
	updateDirectorTable($link, $_POST);
	updateProducerTable($link, $_POST);
	updateScreenwriterTable($link, $_POST);
	updateEditorTable($link, $_POST);

	echo "Movie successfully updated!<br>";
        echo "<a href=\"main.php\">Return to Search</a>";


