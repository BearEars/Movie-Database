<html>
<head>
	<title>Movie Info</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<?php

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

	$fromMovieCrew = getFromMovieCrew($link, $movieId);
	$director = $fromMovieCrew["director"];
	$editor = $fromMovieCrew["editor"];

	$fromScreenwriters = getFromScreenwriters($link, $movieId);
	$fromProducerTable = getFromProducerTable($link, $movieId);

	$fromRatingsTable = getFromRatingsTable($link, $movieId);

	echo "<div id=\"top\">";
	echo "\t<p style=\"font-size:75%\">Logged in as: ".$username."<br>";

	if ($_SESSION["manager"]) {
                echo "You have manager privileges!<br>";
        } else {
                echo "Click <a href=\"managerApp.php\">here</a> to apply for"
                     ." manager privileges.<br>";
        }

        echo "\t<a href=\"logout.php\">Log Out</a></p>";
	echo "</div>";

	echo "<h1 class=\"bigwords\">Title: ".$title."</h1>";

	echo "<div class=\"info\">";
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
	echo "<a href=\"addtag.php?movie_id=".$_GET["id"].
	     ."\">Add a tag!</a>";
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

	echo "<strong>Director:</strong><br>".$director."<br><br>";

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

	echo "<strong>Editor:</strong><br>".$editor."<br><br>";
	echo "</div>";	

	echo "<h2 class=\"bigwords\">Reviews:</h2><br>";
        if (mysqli_num_rows($fromRatingsTable) > 0) {
                while($row = mysqli_fetch_assoc($fromRatingsTable)) {
			echo "<div class=\"info\">";
                        echo $row["username"].": ".$row["ratings"]."/10<br>";
			echo $row["reviews"]."<br><br>";
			echo "</div>";
                }
        } else {
                echo "No reviews yet!<br>";
        }
        echo "<br>";

	echo "<a href=\"review.php?movie_id=".$_GET["id"]
	     ."\">Add a review!</a>";

	$link->close();

//-------------------------------- FUNCTIONS ----------------------------------

function establishLink()
{
        // create link to MySQL database
        /* Connects to database hosted by mysql.cs.uky.edu with username
           equal to linkblue account; cannot rename database or add
           users to MySQL this way, so connection will have to be established 
           this way for all users, and authentication will occur within db
           for each user */
        $link = mysqli_connect("mysql.cs.uky.edu", "twecto2",
                               "2017CS405Project", "twecto2");
        if (!$link) {
                echo "Connection failed: " . mysqli_connect_error();
                exit;
        }
        return $link;
}

function getFromMovieTable($link, $movieId)
{
	$queryString = "SELECT * FROM MOVIES WHERE MOVIE_ID = ".$movieId.";";
	$searchResult = $link->query($queryString);
	return mysqli_fetch_assoc($searchResult);
}

function getFromLanguageTable($link, $movieId)
{
	$queryString = "SELECT * FROM LANGUAGES WHERE MOVIE_ID = ".$movieId.";";
	return $link->query($queryString);
}

function getFromGenreTable($link, $movieId)
{
	$queryString = "SELECT * FROM MOVIE_GENRE WHERE MOVIE_ID = "
		       .$movieId.";";
	return $link->query($queryString);
}

function getFromTagTable($link, $movieId)
{
        $queryString = "SELECT * FROM MOVIE_TAG WHERE MOVIE_ID = "
                       .$movieId.";";
        return $link->query($queryString);
}

function getFromActorTable($link, $movieId)
{
        $queryString = "SELECT * FROM ACTORS WHERE MOVIE_ID = ".$movieId.";";
        return $link->query($queryString);
}

function getFromMovieCrew($link, $movieId) {
	$queryString = "SELECT * FROM MOVIE_CREW WHERE MOVIE_ID = "
			.$movieId.";";
        $searchResult = $link->query($queryString);
        return mysqli_fetch_assoc($searchResult);
}

function getFromScreenwriters($link, $movieId) {
	$queryString = "SELECT * FROM SCREENWRITER WHERE MOVIE_ID = "
		       .$movieId.";";
        return $link->query($queryString);	
}

function getFromProducerTable($link, $movieId) {
	$queryString = "SELECT * FROM PRODUCER WHERE MOVIE_ID = ".$movieId.";";
        return $link->query($queryString);
}

function getFromRatingsTable($link, $movieId) {
        $queryString = "SELECT * FROM RATINGS WHERE MOVIE_ID = ".$movieId.";";
        return $link->query($queryString);
}

?>
</body>
</html>
