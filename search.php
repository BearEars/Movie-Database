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

	// display username at top of page with a log out link
	echo "\t<p style=\"font-size:75%\">Logged in as: ".$username."<br>";
        echo "\t<a href=\"logout.php\">Log Out</a></p>";

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
?>
</body>

</html>
