<html>
<head>
	<title>Search Results</title>
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

	$results = doSearch($link, $match, $searchString);



	echo "<form action=\"search.php\" method=\"GET\">";
	echo "<input type=\"hidden\" name=\"match\" value=\"".$match."\">";
	echo "<input type=\"hidden\" name=\"search\" value=\""
	     .$searchString."\">";
	echo "<div style=\"color:white\">Sort by:</div> ";
	echo "<select name=\"sortBy\">";
	echo "<option value=\"nothing\"></option>";
	echo "<option value=\"title\">Title</option>";
	echo "<option value=\"release_date\">Release Date</option>";
	echo "<option value=\"duration\">Duration</option>";
	echo "</select>";
	echo "    <div style=\"color:white\"> Order:</div> ";
	echo "<select name=\"sortOrder\">";
	echo "<option></option>";
	echo "<option value=\"ascending\">Ascending</option>";
	echo "<option value=\"descending\">Descending</option>";
	echo "</select><br>";
	echo "<input type=\"submit\" value=\"Sort Results\">";
	echo "</form><br>";

	if ($_SESSION["manager"]) {
		echo "<div class=\"info\"><a href=\"addmovie.php\">";
		echo "Add a New Movie</a></div>";
	}
/*
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
		echo "<h2 class=\"bigwords\">No results found!</h2>";
	}
*/
	if (mysqli_num_rows($results) > 0) {
		$movieArray = array();
		
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($movieArray, $row);
		}

		if ($_GET["sortBy"] == "title" 
		   || $_GET["sortBy"] == "release_date"
		   || $_GET["sortBy"] == "duration") {
			$sortBy = $_GET["sortBy"];
			$sortOrder = $_GET["sortOrder"];
			$movieArray = quicksort($movieArray, $sortBy, 
						$sortOrder);
		}

		foreach ($movieArray as $key => $value) {
			$avgRating = getAverageRating($link, $value["movie_id"]);
			$avgRating = round($avgRating, 1, PHP_ROUND_HALF_UP);
			echo "<div class=\"info\">";
                        echo "<h2>Title: <a href=\"movie.php?id="
                             .$value["movie_id"]."\">".$value["title"]
			     ."</a></h2><strong>Avg. Rating: ".$avgRating
			     ."/10<br><br><strong>Summary:</strong><br>"
			     .$value["summary"]
			     ."<br><br><strong>Release</strong>: "
                             .$value["release_date"]."<br><strong>"
                             ."Duration:</strong> ".$value["duration"]."<br>";
			echo "<br><form action=\"addToWatchlist.php\" "
			     ."method=\"POST\">";
			echo "<input type=\"hidden\" name=\"id\" value="
			     .$value["movie_id"].">";
			echo "<input type=\"submit\" value=\"Add to Watchlist"
			     ."\">";
			echo "</form>";
                        if ($_SESSION["manager"]) {
                                echo "<br><a href=\"editmovie.php?id="
                                     .$value["movie_id"]."\">";
                                echo "Edit Movie</a><br>";
				echo "<a href=\"deletemovie.php?id="
				     .$value["movie_id"]."\">";
				echo "Delete Movie</a>";
                        }
                        echo "</div>";
		}

	} else {
		echo "<h2 class=\"bigwords\">No results found!</h2>";
	}

	$link->close();

?>
</body>

</html>
