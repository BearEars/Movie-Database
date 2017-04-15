<html>
<head>
	<title>My Watchlist</title>
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
        $link = establishLink();
        $username = $_SESSION["username"];
        $match = $_GET["match"];
        $searchString = $_GET["search"];
        $results;

        // display username at top of page with a log out link
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

	$results = getFromWatchlist($link, $username);

	echo "<h1 class=\"bigwords\">".$username."'s Watchlist</h1>";

	if (mysqli_num_rows($results) > 0) {
                while($row = mysqli_fetch_assoc($results)) {
                        echo "<div class=\"info\">";
                        echo "<h2>Title: <a href=\"movie.php?id="
                             .$row["movie_id"]."\">".$row["title"]."</a></h2>"
                             ." <strong>Summary:</strong><br>".$row["summary"]
                             ."<br><br><strong>Release</strong>: "
                             .$row["release_date"]."<br><strong>"
                             ."Duration:</strong> ".$row["duration"]."<br>";
                        if ($_SESSION["manager"]) {
                                echo "<br><a href=\"editmovie.php?id="
                                     .$row["movie_id"]."\">";
                                echo "Edit Movie</a>";
                        }
                        echo "</div>";
                }
        } else {
                echo "<h2 class=\"bigwords\">No movies in your list!</h2>";
        }

?>

</body>
</html>
