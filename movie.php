<html>
<head>
	<title>Movie Info</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<?php
	include 'movie_db_funcs.php';
	session_start();
	if(!isset($_SESSION["username"])) {
		header("Location: /~twecto2/CS405/Movie-Database/home.html");
               exit;
	}
	if(!isset($_GET["id"]) || $_GET["id"] == "") {
		echo "<div id=\"top\">";
		echo "Error: invalid movie_id<br><br>";
		echo "<a href=\"main.php\">Return to Search</a>";
		echo "</div>";
		exit;
	}
	$link = establishLink();
	$username = $_SESSION["username"];
	$movieId = $_GET["id"];
	
	$fromMovieTable = getFromMovieTable($link, $movieId);
	$title = $fromMovieTable["title"];
	$summary = $fromMovieTable["summary"];
	$release = $fromMovieTable["release_date"];
	$duration = $fromMovieTable["duration"];

	$fromLanguageTable = getFromLanguageTable($link, $movieId);
	$fromGenreTable = getFromGenreTable($link, $movieId);
	$fromTagTable = getFromTagTable($link, $movieId);
	$fromActorTable = getFromActorTable($link, $movieId);

	$fromDirectorTable = getFromDirectors($link, $movieId);
	$fromEditorTable = getFromEditors($link, $movieId);

	$fromScreenwriters = getFromScreenwriters($link, $movieId);
	$fromProducerTable = getFromProducerTable($link, $movieId);

	$fromRatingsTable = getFromRatingsTable($link, $movieId);
	$avgRating = getAverageRating($link, $movieId);

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

	echo "<h1 class=\"bigwords\">Title: ".$title."</h1>";
	echo "<h2 class=\"bigwords\">Average Rating: ".round($avgRating, 1,
		PHP_ROUND_HALF_UP)."/10</h2>";
	
	echo "<div class=\"info\">";

	echo "<form action=\"addToWatchlist.php\" method=\"post\">";
	echo "<input type=\"hidden\" name=\"id\" value=".$movieId.">";
	echo "<input type=\"submit\" value=\"Add to Watchlist\">";
	echo "</form>";

	if ($_SESSION["manager"]) {
		echo "<a href=\"editmovie.php?id=".$movieId."\">";
		echo "Edit Movie</a><br>";
		echo "<a href=\"deletemovie.php?id=".$movieId."\">";
                echo "Delete Movie</a><br><br>";
	}
	echo "<strong>Summary:</strong><br>".$summary."<br><br>";
	echo "<strong>Release Date:</strong> ".$release."<br>";
	echo "<strong>Duration:</strong> ".$duration."<br><br>";

	echo "<strong>Language(s):</strong><br>";
	if (mysqli_num_rows($fromLanguageTable) > 0) {
		while($row = mysqli_fetch_assoc($fromLanguageTable)) {
			echo $row["language"]."<br>";
		}
	} else {
		echo "No language information available.<br>";
	}
	echo "<br>";

	echo "<strong>Genre(s):</strong><br>";
	if (mysqli_num_rows($fromGenreTable) > 0) {
		while($row = mysqli_fetch_assoc($fromGenreTable)) {
			echo $row["genre_type"]."<br>";
		}
	} else {
		echo "No genre information available.<br>";
	}
	echo "<br>";

	echo "<strong>Tag(s):</strong><br>";
        if (mysqli_num_rows($fromTagTable) > 0) {
                while($row = mysqli_fetch_assoc($fromTagTable)) {
                        echo $row["tag_type"]."<br>";
                }
        } else {
                echo "No tag information available.<br>";
        }
	echo "<br><br>";
	echo "<a href=\"addtag.php?movie_id=".$_GET["id"]
	     ."&username=".$username."\">Add a tag!</a>";
	echo "</div>";

	echo "<h2 class=\"bigwords\">Crew</h2>";

	echo "<div class=\"info\">";
	echo "<strong>Actors:</strong><br>";
        if (mysqli_num_rows($fromActorTable) > 0) {
                while($row = mysqli_fetch_assoc($fromActorTable)) {
                        echo $row["actor"]."<br>";
                }
        } else {
                echo "No actor information available.<br>";
        }
        echo "<br>";

	echo "<strong>Director(s):</strong><br>";
        if (mysqli_num_rows($fromDirectorTable) > 0) {
                while($row = mysqli_fetch_assoc($fromDirectorTable)) {
                        echo $row["director"]."<br>";
                }
        } else {
                echo "No director information available.<br>";
        }
        echo "<br>";

	echo "<strong>Producer(s):</strong><br>";
        if (mysqli_num_rows($fromProducerTable) > 0) {
                while($row = mysqli_fetch_assoc($fromProducerTable)) {
                        echo $row["producer"]."<br>";
                }
        } else {
                echo "No producer information available.<br>";
        }
        echo "<br>";

	echo "<strong>Screenwriter(s):</strong><br>";
        if (mysqli_num_rows($fromScreenwriters) > 0) {
                while($row = mysqli_fetch_assoc($fromScreenwriters)) {
                        echo $row["screenwriter"]."<br>";
                }
        } else {
                echo "No screenwriter information available.<br>";
        }
        echo "<br>";

	echo "<strong>Editor(s):</strong><br>";
        if (mysqli_num_rows($fromEditorTable) > 0) {
                while($row = mysqli_fetch_assoc($fromEditorTable)) {
                        echo $row["editor"]."<br>";
                }
        } else {
                echo "No editor information available.<br>";
        }
        echo "<br>";
	echo "</div>";	

	echo "<h2 class=\"bigwords\">Reviews:</h2><br>";
        if (mysqli_num_rows($fromRatingsTable) > 0) {
                while($row = mysqli_fetch_assoc($fromRatingsTable)) {
			echo "<div class=\"info\">";
                        echo $row["username"].": ".$row["ratings"]."/10<br>";
			echo $row["REVIEWS"]."<br><br>";
			echo "</div>";
                }
        } else {
                echo "No reviews yet!<br>";
        }
        echo "<br>";
	echo "<div class=\"info\">";
	echo "<a href=\"review.php?movie_id=".$_GET["id"]
	     ."\">Add a review!</a>";
	echo "</div>";

	$link->close();

?>
</body>
</html>
