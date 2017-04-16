<html>
<head>
        <title>Add Managers</title>
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
	$nonManagers = getNonManagers($link);

	if (mysqli_num_rows($nonManagers) > 0) {
                echo "<div class=\"info\">";
		echo "<form action=\"updateManagers.php\" method=\"POST\">";
		$i = 0;
		while ($row = mysqli_fetch_assoc($nonManagers)) {
			echo "<input type=\"checkbox\" name=\"user".$i."\" "
				."value=\"".$row["username"]."\"> "
				.$row["username"]."<br>";
			$i++;
                }
		echo "<input type=\"hidden\" name=\"i\" value=".$i.">";
		echo "<br>";
		echo "<input type=\"submit\" value=\"Submit\">";
		echo "</form>";
		echo "</div>";
        } else {
                echo "<h2 class=\"bigwords\">Everyone is a manager!</h2>";
		echo "<h3 class=\"bigwords\">Somehow sounds like a bad idea...
			</h3>";
        }

?>
</body>
</html>
