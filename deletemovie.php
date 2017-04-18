<html>
<head>
        <title>Deleting Movie...</title>
        <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>

<?php
        include 'movie_db_funcs.php';
        session_start(); // can use this to verify user is logged in
        if (!isset($_SESSION["username"])) {
                header("Location: /~twecto2/CS405/Movie-Database/home.html");
                exit;
        }
        if (!isset($_GET["id"])) {
                header("Location: /~twecto2/CS405/Movie-Database/main.php");
                exit;
        }
        $username = $_SESSION["username"];
        echo "<div id=\"top\">";
        echo "\t<p style=\"font-size:75%\">Logged in as: ".$username."<br>";
        echo "\t<a href=\"logout.php\">Log Out</a>";
        echo "<br><br><a href=\"myWatchlist.php\">My Watchlist</a>";
        echo "<br><a href=\"main.php\">Search</a></p>";
        echo "</div>";
        echo "<div id=\"padding\"></div>";

        $link = establishLink();
        $movieId = $_GET["id"];

        deleteMovie($link, $movieId);

        echo "<div class=\"info\">";
        echo "Movie successfully deleted<br>";
        echo "<a href=\"main.php\">Return to Search</a>";
	echo "</div>";
?>


</body>
</html>
