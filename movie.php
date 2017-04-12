<html>
<head>
	<title>Movie Info</title>
</head>
<body>
<?php

	session_start();
	if(!isset($_SESSION["username"])) {
		header("Location: /~twecto2/CS405/Movie-Database/home.html");
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

	echo "\t<p style=\"font-size:75%\">Logged in as: ".$username."<br>";

	if ($_SESSION["manager"]) {
                echo "You have manager privileges!<br>";
        } else {
                echo "Click <a href=\"managerApp.php\">here</a> to apply for"
                     ." manager privileges.<br>";
        }

        echo "\t<a href=\"logout.php\">Log Out</a></p>";

	echo "<h3>Title: ".$title."</h3>";
	echo "<strong>Summary:</strong><br>".$summary."<br><br>";
	echo "<strong>Release Date:</strong> ".$release."<br>";
	echo "<strong>Duration:</strong> ".$duration."<br>";

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

?>
</body>
</html>
