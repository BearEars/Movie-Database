<html>
<head>
	<title>Sending Manager Application...</title>
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

	$to = "taylor.ecton@gmail.com";
	$from = $_POST["email"];
	$subject = "Movie-Database Manager Application";
	$message = $_POST["message"];
	$headers = "From:".$from;

	mail($to, $subject, $message, $headers);

	echo "<div class=\"info\">";
        echo "Application successfully submitted!<br>";
        echo "<a href=\"main.php\">Return to Search</a>";
        echo "</div>";

?>

</body>
</html>
