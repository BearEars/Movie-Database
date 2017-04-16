<html>
<head>
	<title>Updating Managers...</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>

<?php

	include 'movie_db_funcs.php';
        session_start();
        if(!isset($_SESSION["username"])) {
                header("Location: /~twecto2/CS405/Movie-Database/home.html");
                exit;
        }
        echo "<div id=\"top\">";
        echo "\t<p style=\"font-size:75%\">Logged in as: "
                .$_SESSION["username"]."<br>";
        
        echo "You have manager privileges!<br>";
        echo "<a href=\"addManagers.php\">Add Manager</a><br>";
        echo "\t<a href=\"logout.php\">Log Out</a>";
        echo "<br><br><a href=\"myWatchlist.php\">My Watchlist</a>";
        echo "<br><a href=\"main.php\">Search</a></p>";
        echo "</div>";
        echo "<div id=\"padding\"></div>";

        $link = establishLink();
	
	for ($i = 0; $i < $_POST["i"]; $i++) {
		$key = "user".$i;
		if ($_POST[$key] != "") {
			updatePrivileges($link, $_POST[$key]);
		}
	}

	echo "<div class=\"info\">";
	echo "User privileges updated.<br>";
	echo "<a href=\"main.php\">Return to Search</a>";
	echo "</div>";
?>

</body>
</html>
