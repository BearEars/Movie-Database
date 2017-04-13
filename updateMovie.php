<html>
<head>
        <title>Updating movie</title>
        <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>

<?php
	include 'movie_db_funcs.php';
        session_start(); // can use this to verify user is logged in
        if (!isset($_SESSION["username"]) || !$_SESSION["manager"]) {
                header("Location: /~twecto2/CS405/Movie-Database/home.html");
                exit;
        }
        $username = $_SESSION["username"];

        echo "<div id=\"top\">";
        echo "\t<p style=\"font-size:75%\">Logged in as: ".$username."<br>";
        echo "You have manager privileges!<br>";
        echo "\t<a href=\"logout.php\">Log Out</a></p>";
        echo "</div>";

        $link = establishLink();

	echo "Movie successfully updated!<br>";
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
