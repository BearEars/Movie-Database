<html>
<head>
	<title>Main Page</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
<?php
	include 'movie_db_funcs.php';
	$link;
	$username;
	session_start(); // I think this will let users stay logged in

	if (fromUserReg($_POST)) {
		$link = establishLink();
		registerUser($_POST, $link);
		$username = $_POST["Username"];
		$_SESSION["username"] = $username;
		$_SESSION["manager"] = 0;
	}
	elseif (fromHome($_POST)) {
		$link = establishLink();
		$_SESSION["manager"] = login($_POST, $link);
		$username = $_POST["Username"];
		$_SESSION["username"] = $username;
	}
	elseif (isset($_SESSION["username"])) {
		$username = $_SESSION["username"];
	}
	if (!fromUserReg($_POST) && !fromHome($_POST) 
			         && !isset($_SESSION["username"])) {
		// redirect user to login page if not signed in
		header("Location: /~twecto2/CS405/Movie-Database/home.html");
		exit;
	}
	
	// display username at top of page with a log out link
	echo "<div id=\"top\">";
	echo "\t<p style=\"font-size:75%\">Logged in as: ".$username."<br>";

	if ($_SESSION["manager"]) {
		echo "You have manager privileges!<br>";
	} else {
		echo "Click <a href=\"managerApp.php\">here</a> to apply for"
		     ." manager privileges.<br>";
	}

	echo "\t<a href=\"logout.php\">Log Out</a>";
	echo "<br><br><a href=\"myWatchlist.php\">My Watchlist</a>";
        echo "<br><a href=\"main.php\">Search</a></p>";
	echo "</div>\n";
	echo "<div id=\"padding\"></div>";
	// form for searching for movies
	echo "<div id=\"searchBox\">";
	echo "\t<h2>Search for Movies:</h2>\n";
	echo "\t<form action=\"search.php\" method=\"GET\">\n";
	// <----   FILL IN FORM HERE   ---->
	echo "\t\t<select name=\"match\" class=\"search\">\n";
//	echo "\t\t\t<option value=\"nothing\"></option>\n";
	echo "\t\t\t<option value=\"title\">Title</option>\n";
	echo "\t\t\t<option value=\"genre\">Genre</option>\n";
	echo "\t\t\t<option value=\"director\">Director</option>\n";
	echo "\t\t\t<option value=\"actor\">Actor</option>\n";
	echo "\t\t\t<option value=\"language\">Language</option>\n";
	echo "\t\t\t<option value=\"producer\">Producer</option>\n";
	echo "\t\t\t<option value=\"editor\">Editor</option>\n";
	echo "\t\t\t<option value=\"screenwriter\">Screenwriter</option>\n";
	echo "\t\t\t<option value=\"tag\">Tag</option>\n";
	echo "\t\t</select>\n";
	echo "\t\t<input type=\"text\" name=\"search\" size=\"50\"
	      class=\"search\">\n";
	echo "\t\t<input type=\"hidden\" name=\"sortBy\" value=\"nothing\">\n";
	echo "\t\t<input type=\"submit\" value=\"Search\" class=\"search\">\n";
	echo "\t</form>";
	if ($_SESSION["manager"]) {
		echo "<br>OR:";
		echo "<br><a href=\"addmovie.php\">Add a New Movie</a>";
	}
	echo "</div>";

	$link->close();

?>
</body>
</html>

