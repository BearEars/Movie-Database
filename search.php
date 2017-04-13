<html>
<head>
	<title>Search Results</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
<?php

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
        } else {
                echo "Click <a href=\"managerApp.php\">here</a> to apply for"
                     ." manager privileges.<br>";
        }

	echo "\t<a href=\"logout.php\">Log Out</a></p>";
	echo "</div>";

	$results = doSearch($link, $match, $searchString);

	echo "<form action=\"search.php\" method=\"GET\">";
	echo "<input type=\"hidden\" name=\"match\" value=\"".$match."\">";
	echo "<input type=\"hidden\" name=\"search\" value=\""
	     .$searchString."\">";
	echo "<div style=\"color:white\">Sort by:</div> ";
	echo "<select name=\"sortBy\">";
	echo "<option value=\"title\">Title</option>";
	echo "<option value=\"release\">Release Date</option>";
	echo "<option value=\"duration\">Duration</option>";
	echo "</select>";
	echo "    <div style=\"color:white\"> Order:</div> ";
	echo "<select name=\"sortOrder\">";
	echo "<option value=\"ascending\">Ascending</option>";
	echo "<option value=\"descending\">Descending</option>";
	echo "</select><br>";
	echo "<input type=\"submit\" value=\"Sort Results\">";
	echo "</form><br>";

	if ($_SESSION["manager"]) {
		echo "<div class=\"info\"><a href=\"addmovie.php\">";
		echo "Add a New Movie</a></div>";
	}

	if (mysqli_num_rows($results) > 0) {
		while($row = mysqli_fetch_assoc($results)) {
			echo "<div class=\"info\">";
			echo "<h2>Title: <a href=\"movie.php?id="
			     .$row["movie_id"]."\">".$row["title"]."</a></h2>"
			     ." Summary:<br>".$row["summary"]
			     ."<br><br>Release: ".$row["release_date"]
			     ."<br>Duration: ".$row["duration"]."<br>";
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


	$link->close();

//----------------------------- FUNCTIONS -------------------------------------
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

function doSearch($link, $match, $searchString)
{
	switch($match) {
		case "title":
		{
			echo "<div class=\"bigwords\">";
			echo "<h1>Showing results for movies with ".$searchString
			     ." in the title...</h1>";
			echo "</div>";
			$queryString = "SELECT * FROM MOVIES WHERE TITLE LIKE"
				       ." '%".$searchString."%';";
			$searchResult = $link->query($queryString);
			return $searchResult;
		}
		case "genre":
		{
			echo "<div class=\"bigwords\">";
			echo "<h1>Showing results for movies in the "
			     .$searchString." genre...</h1>";
			echo "</div>";
			$queryString = "SELECT * FROM MOVIES AS M"
				      ." WHERE M.MOVIE_ID IN (SELECT MOVIE_ID"
				      . " FROM MOVIE_GENRE WHERE GENRE_TYPE "
				      ."LIKE '%".$searchString."%');";
			$searchResult = $link->query($queryString);
			return $searchResult;
		}
		case "director":
		{
			echo "<div class=\"bigwords\">";
			echo "<h1>Showing results for movies directed by "
			     .$searchString."...</h1>";
			echo "</div>";
			$queryString = "SELECT * FROM MOVIES AS M WHERE "
				      ."M.MOVIE_ID IN (SELECT MOVIE_ID FROM "
				      ."MOVIE_CREW WHERE DIRECTOR LIKE '%"
				      .$searchString."%');";
			$searchResult = $link->query($queryString);
			return $searchResult;
		}
		case "actor":
		{
			echo "<div class=\"bigwords\">";
			echo "<h1>Showing results for movies starring "
			     .$searchString."...</h1>";
			echo "</div>";
			$queryString = "SELECT * FROM MOVIES AS M WHERE "
                                      ."M.MOVIE_ID IN (SELECT MOVIE_ID FROM "
                                      ."ACTORS WHERE ACTOR LIKE '%"
                                      .$searchString."%');";
                        $searchResult = $link->query($queryString);
                        return $searchResult;
		}
		default:
		{
			return;
		}
	}
}
?>
</body>

</html>
