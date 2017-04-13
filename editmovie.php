<html>
<head>
	<title>Edit Movie</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>

<?php
	include 'movie_db_funcs.php';
	session_start();
        if(!isset($_SESSION["username"]) || !$_SESSION["manager"]) {
                header("Location: /~twecto2/CS405/Movie-Database/home.html");
                exit;
        }
	if(!isset($_GET["id"])) {
		exit("Error: invalid movid_id");
	}

	$username = $_SESSION["username"];

        echo "<div id=\"top\">";
        echo "\t<p style=\"font-size:75%\">Logged in as: ".$username."<br>";
        echo "You have manager privileges!<br>";
        echo "\t<a href=\"logout.php\">Log Out</a></p>";
        echo "</div>";

	$link = establishLink();
	$movieId = $_GET["id"];
	$fromMovieTable = getFromMovieTable($link, $movieId);
        $title = $fromMovieTable["title"];
        $summary = $fromMovieTable["summary"];
        $release = $fromMovieTable["release_date"];
        $duration = $fromMovieTable["duration"];

	$fromLanguageTable = getFromLanguageTable($link, $movieId);
	$languages = array_fill(0, 3, "");
	$langIndex = 0;
	while ($row = mysqli_fetch_assoc($fromLanguageTable)) {
		$languages[$langIndex] = $row["language"];
		$langIndex += 1;
	}

        $fromGenreTable = getFromGenreTable($link, $movieId);
	$genres = array_fill(0, 3, "");
	$genIndex = 0;
	while ($row = mysqli_fetch_assoc($fromGenreTable)) {
		$genres[$genIndex] = $row["genre_type"];
		$genIndex += 1;
	}

        $fromTagTable = getFromTagTable($link, $movieId);
	$tags = array_fill(0, 3, "");
        $tagIndex = 0;
        while ($row = mysqli_fetch_assoc($fromTagTable)) {
                $tags[$tagIndex] = $row["tag_type"];
                $tagIndex += 1;
        }

        $fromActorTable = getFromActorTable($link, $movieId);
	$actors = array_fill(0, 3, "");
	$actIndex = 0;
        while ($row = mysqli_fetch_assoc($fromActorTable)) {
                $actors[$actIndex] = $row["actor"];
                $actIndex += 1;
        }

// REMOVE BLOCK AFTER UPDATE TO DB -------------------------------------------
        $fromMovieCrew = getFromMovieCrew($link, $movieId);
        $director = $fromMovieCrew["director"];
        $editor = $fromMovieCrew["editor"];
// ---------------------------------------------------------------------------

/* UNCOMMENT AFTER DB UPDATE ------------------------------------------------
	$fromDirectorTable = getFromDirectors($link, $movieId);
	$directors = array_fill(0, 2, "");
        $dirIndex = 0;
        while ($row = mysqli_fetch_assoc($fromDirectorTable)) {
                $directors[$dirIndex] = $row["director"];
                $dirIndex += 1;
        }

        $fromEditorTable = getFromEditorTable($link, $movieId);
	$editors = array_fill(0, 3, "");
        $editIndex = 0;
        while ($row = mysqli_fetch_assoc($fromEditorTable)) {
                $editors[$editIndex] = $row["editor"];
                $editIndex += 1;
        }
---------------------------------------------------------------------------*/

        $fromScreenwriters = getFromScreenwriters($link, $movieId);
	$screenwriters = array_fill(0, 3, "");
        $screenIndex = 0;
        while ($row = mysqli_fetch_assoc($fromScreenwriters)) {
                $screenwriters[$screenIndex] = $row["screenwriter"];
                $screenIndex += 1;
        }

        $fromProducerTable = getFromProducerTable($link, $movieId);
	$producers = array_fill(0, 3, "");
        $prodIndex = 0;
        while ($row = mysqli_fetch_assoc($fromProducerTable)) {
                $producers[$prodIndex] = $row["producer"];
                $prodIndex += 1;
        }

?>

<h1 class="bigwords">Edit Movie</h1>

<div id="form">
<form action="updateMovie.php" method="POST">
<?php
	echo "<input type=\"hidden\" name=\"movieId\" value=\""
	     .$_GET["id"]."\">";

        echo "Title:<br><input type=\"text\" name=\"title\" "
	     ."value=\"".$title."\"><br><br>";

        echo "Summary:<br><input type=\"text\" name=\"summary\" "
	    ."value=\"".$summary."\" style=\"width:260px\">";
        echo "<br><br>";

        echo "Release Date:<br>";
        echo "<input type=\"text\" name=\"release\" value=\""
	    .$release."\"><br><br>";

        echo "Duration:<br>";
        echo "<input type=\"text\" name=\"duration\" value=\""
	     .$duration."\"><br><br>";

        echo "Language(s):<br>";
	for ($i = 0; $i < 3; $i++) {
		if ($languages[$i] != "") {
			echo "<input type=\"text\" name=\"lang".$i."\" "
			    ."value=\"".$languages[$i]."\"><br>";
		} else {
			echo "<input type=\"text\" name=\"lang".$i."\"><br>";
		}
	}
        echo "<br><br>";

	echo "Genre(s):<br>";
        for ($i = 0; $i < 3; $i++) {
                if ($genres[$i] != "") {
                        echo "<input type=\"text\" name=\"gen".$i."\" "
                            ."value=\"".$genres[$i]."\"><br>";
                } else {
                        echo "<input type=\"text\" name=\"gen".$i."\"><br>";
                }
        }
        echo "<br><br>";

	echo "Tag(s):<br>";
        for ($i = 0; $i < 3; $i++) {
                if ($tags[$i] != "") {
                        echo "<input type=\"text\" name=\"tag".$i."\" "
                            ."value=\"".$tags[$i]."\"><br>";
                } else {
                        echo "<input type=\"text\" name=\"tag".$i."\"><br>";
                }
        }
        echo "<br><br>";

	echo "Actors:<br>";
        for ($i = 0; $i < 3; $i++) {
                if ($actors[$i] != "") {
                        echo "<input type=\"text\" name=\"actor".$i."\" "
                            ."value=\"".$actors[$i]."\"><br>";
                } else {
                        echo "<input type=\"text\" name=\"actor".$i."\"><br>";
                }
        }
        echo "<br><br>";

	echo "Director(s):<br>";
	
// DELETE THIS NEXT LINE WHEN DB UPDATED ---------------------------------
	echo "<input type=\"text\" name=\"direc0\" value=\"".$director."\">";
/* UNCOMMENT WHEN DB UPDATE --------------------------------------------
        for ($i = 0; $i < 2; $i++) {
                if ($directors[$i] != "") {
                        echo "<input type=\"text\" name=\"direc".$i."\" "
                            ."value=\"".$directors[$i]."\"><br>";
                } else {
                        echo "<input type=\"text\" name=\"direc".$i."\"><br>";
                }
        }
-----------------------------------------------------------------------*/
        echo "<br><br>";

	echo "Producer(s):<br>";
        for ($i = 0; $i < 3; $i++) {
                if ($producers[$i] != "") {
                        echo "<input type=\"text\" name=\"prod".$i."\" "
                            ."value=\"".$producers[$i]."\"><br>";
                } else {
                        echo "<input type=\"text\" name=\"prod".$i."\"><br>";
                }
        }
        echo "<br><br>";

	echo "Screenwriter(s):<br>";
        for ($i = 0; $i < 3; $i++) {
                if ($screenwriters[$i] != "") {
                        echo "<input type=\"text\" name=\"screen".$i."\" "
                            ."value=\"".$screenwriters[$i]."\"><br>";
                } else {
                        echo "<input type=\"text\" name=\"screen".$i."\"><br>";
                }
        }
        echo "<br><br>";

	echo "Editor(s):<br>";
// REMOVE WHEN DB UPDATED----------------------------
	echo "<input type=\"text\" name=\"edit0\" value=\"".$editor."\">";
/* UNCOMMENT WHEN DB UPDATED ---------------------------------------------
        for ($i = 0; $i < 3; $i++) {
                if ($editors[$i] != "") {
                        echo "<input type=\"text\" name=\"edit".$i."\" "
                            ."value=\"".$editors[$i]."\"><br>";
                } else {
                        echo "<input type=\"text\" name=\"edit".$i."\"><br>";
                }
        }
----------------------------------------*/
        echo "<br><br>";
?>

        <input type="submit" value="Update Movie">

</form>
</div>

<?php
/*
//-------------------------------- FUNCTIONS ----------------------------------

function establishLink()
{
        // create link to MySQL database
        /* Connects to database hosted by mysql.cs.uky.edu with username
           equal to linkblue account; cannot rename database or add
           users to MySQL this way, so connection will have to be established 
           this way for all users, and authentication will occur within db
           for each user 
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

function getFromDirectors($link, $movieId) {
        $queryString = "SELECT * FROM DIRECTORS WHERE MOVIE_ID = "
                       .$movieId.";";
        return $link->query($queryString);
}

function getFromEditors($link, $movieId) {
        $queryString = "SELECT * FROM EDITORS WHERE MOVIE_ID = "
                       .$movieId.";";
        return $link->query($queryString);
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
*/
?>

</body>
</html>
