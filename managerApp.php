<html>
<head>
	<title>Manager Application</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>

<?php
	session_start();
	$username = $_SESSION["username"];
	echo "<div id=\"top\">";
        echo "\t<p style=\"font-size:75%\">Logged in as: ".$username."<br>";

        if ($_SESSION["manager"]) {
                echo "You have manager privileges!<br>";
		echo "<a href=\"addManagers.php\">Add Manager</a><br>";
        } else {
                echo "Click <a href=\"managerApp.php\">here</a> to apply for"
                     ." manager privileges.<br>";
        }

        echo "\t<a href=\"logout.php\">Log Out</a>";
        echo "<br><br><a href=\"myWatchlist.php\">My Watchlist</a>";
        echo "<br><a href=\"main.php\">Search</a></p>";
        echo "</div>\n";
        echo "<div id=\"padding\"></div>";

?>

	<form action="sendApplication.php" method="POST" class="info">
		Email:<br>
		<input type="text" name="email" placeholder="you@example.com">
		<br><br>
		Why should you be a manager on this site?<br>
		<input type="text" name="message" style="width:350px"><br>
		<input type="submit" value="Submit Application">
	</form>

</body>
</html>
