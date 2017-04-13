<html>
<head>
	<title>Review Submission</title>
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
	if (!isset($_POST["movie_id"])) {
		header("Location: /~twecto2/CS405/Movie-Database/main.php");
		exit;
	}
	$username = $_SESSION["username"];
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

	addReview($link, $username, $rating, $review, $movieId);
	echo "Review successfully added!<br>";
	echo "<a href=\"main.php\">Return to Search</a>";

?>


</body>
</html>
