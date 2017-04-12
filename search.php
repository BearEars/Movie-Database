<html>
<head>
	<title>Search Results</title>
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
	echo "\t<p style=\"font-size:75%\">Logged in as: ".$username."<br>";

	if ($_SESSION["manager"]) {
                echo "You have manager privileges!<br>";
        } else {
                echo "Click <a href=\"managerApp.php\">here</a> to apply for"
                     ." manager privileges.<br>";
        }

	echo "\t<a href=\"logout.php\">Log Out</a></p>";

	$results = doSearch($link, $match, $searchString);

	if (mysqli_num_rows($results) > 0) {
		while($row = mysqli_fetch_assoc($results)) {
			echo "Title: <a href=\"movie.php?id=".$row["movie_id"]
			     ."\">".$row["title"]."</a> Summary: "
			     .$row["summary"]." Release: ".$row["release_date"]
			     ." Duration: ".$row["duration"]."<br>";
		}
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
			$queryString = "SELECT * FROM MOVIES WHERE TITLE LIKE"
				       ." '%".$searchString."%';";
			$searchResult = $link->query($queryString);
			return $searchResult;
		}
	}
}
?>
</body>

</html>
