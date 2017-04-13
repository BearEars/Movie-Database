<html>
<head>
	<title>Review Submission</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>

<?php
	session_start(); // can use this to verify user is logged in
        if (!isset($_SESSION["username"])) {
                header("Location: /~twecto2/CS405/Movie-Database/home.html");
                exit;
        }
	if (!isset($_POST["movie_id"])) {
		header("Location: /~twecto2/CS405/Movie-Database/main.php");
		exit;
	}
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

	$link = establishLink();
	$rating = $_POST["rating"];
	$review = $_POST["review"];
	$movieId = $_POST["movie_id"];
	$username = $_SESSION["username"];

	addReview($link, $username, $rating, $review, $movieId);
	echo "Review successfully added!<br>";
	echo "<a href=\"main.php\">Return to Search</a>";

//---------------------------- FUNCTIONS --------------------------------------
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

function addReview($link, $username, $rating, $review, $movieId)
{
	$queryString = "INSERT INTO RATINGS VALUES ('"
		       .$username."', ".$movieId.", "
		       .$rating.", '".$review."');";
	$link->query($queryString);
}

?>


</body>
</html>
