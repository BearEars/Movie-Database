<html>
<head>
	<title>Adding to Watchlist</title>
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
        if (!isset($_POST["id"])) {
                header("Location: /~twecto2/CS405/Movie-Database/main.php");
                exit;
        }
        $username = $_SESSION["username"];
        echo "<div id=\"top\">";
        echo "\t<p style=\"font-size:75%\">Logged in as: ".$username."<br>";

        if ($_SESSION["manager"]) {
                echo "You have manager privileges!<br>";
		echo "<a href=\"addManagers.php\">Add Manager</a><br>";
        } else {
                echo "Click <a href=\"managerApp.php\">here</a> to apply for"
                     ." manager privileges.<br>";
        }

        echo "\t<a href=\"logout.php\">Log Out</a>";
	echo "<br><br><a href=\"myWatchlist.php\">My Watchlist</a>";
        echo "<br><a href=\"main.php\">Search</a></p>";
        echo "</div>";

	$link = establishLink();
	$movieId = $_POST["id"];

	addToWatchList($link, $username, $movieId);
	echo "Movie successfully added to watchlist!<br>";
	echo "<a href=\"main.php\">Return to Search</a>";

?>

</body>
</html>
