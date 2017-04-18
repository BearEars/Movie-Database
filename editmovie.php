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
	echo "<a href=\"addManagers.php\">Add Manager</a><br>";
        echo "\t<a href=\"logout.php\">Log Out</a>";
	echo "<br><br><a href=\"myWatchlist.php\">My Watchlist</a>";
        echo "<br><a href=\"main.php\">Search</a></p>";
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

	$fromDirectorTable = getFromDirectors($link, $movieId);
	$directors = array_fill(0, 2, "");
        $dirIndex = 0;
        while ($row = mysqli_fetch_assoc($fromDirectorTable)) {
                $directors[$dirIndex] = $row["director"];
                $dirIndex += 1;
        }

        $fromEditorTable = getFromEditors($link, $movieId);
	$editors = array_fill(0, 3, "");
        $editIndex = 0;
        while ($row = mysqli_fetch_assoc($fromEditorTable)) {
                $editors[$editIndex] = $row["editor"];
                $editIndex += 1;
        }

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

<div id="editform">
<form action="updateMovie.php" method="POST">
<?php

	echo "<div class=\"editcolumn\">";
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
			    ."value=\"".$languages[$i]."\">";
			echo "<a href=\"deletevalue.php?id=<br>";
		} else {
			echo "<input type=\"text\" name=\"lang".$i."\"><br>";
		}
	}
        echo "<br><br>";

	echo "</div>";
	echo "<div class=\"editcolumn\">";

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
        for ($i = 0; $i < 2; $i++) {
                if ($directors[$i] != "") {
                        echo "<input type=\"text\" name=\"direc".$i."\" "
                            ."value=\"".$directors[$i]."\"><br>";
                } else {
                        echo "<input type=\"text\" name=\"direc".$i."\"><br>";
                }
        }

        echo "<br><br>";

	echo "<input type=\"submit\" value=\"Update Movie\">";

	echo "</div>";
	echo "<div class=\"editcolumn\">";

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
        for ($i = 0; $i < 3; $i++) {
                if ($editors[$i] != "") {
                        echo "<input type=\"text\" name=\"edit".$i."\" "
                            ."value=\"".$editors[$i]."\"><br>";
                } else {
                        echo "<input type=\"text\" name=\"edit".$i."\"><br>";
                }
        }
	echo "</div>";
        echo "<br><br>";
?>

</form>
</div>


</body>
</html>
