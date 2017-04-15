<html>
<head>
	<title>Add Movie</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>

<?php
	session_start();
        if(!isset($_SESSION["username"]) || !$_SESSION["manager"]) {
                header("Location: /~twecto2/CS405/Movie-Database/home.html");
                exit;
        }
	
	echo "<div id=\"top\">";
        echo "\t<p style=\"font-size:75%\">Logged in as: ".$username."<br>";
        echo "You have manager privileges!<br>";
	echo "<a href=\"addManagers.php\">Add Manager</a><br>";
        echo "\t<a href=\"logout.php\">Log Out</a>";
	echo "<br><br><a href=\"myWatchlist.php\">My Watchlist</a>";
	echo "<br><a href=\"main.php\">Search</a></p>";
        echo "</div>";
?>

<h1 class="bigwords">Add a New Movie</h1>

<div id="form">
<form action="insertNewMovie.php" method="POST">
	Title:<br><input type="text" name="title"><br><br>
	Summary:<br><input type="text" name="summary" style="width:260px">
	<br><br>
	Release Date:<br>
	<input type="text" name="release" placeholder="YYYY-MM-DD"><br><br>
	Duration:<br>
	<input type="text" name="duration" placeholder="HH:MM:SS"><br><br>
	Language(s):<br>
	<input type="text" name="lang0"><br>
	<input type="text" name="lang1"><br>
	<input type="text" name="lang2"><br><br><br>
	Genre(s):<br>
	<input type="text" name="gen0"><br>
	<input type="text" name="gen1"><br>
	<input type="text" name="gen2"><br><br>
	Tag(s):<br>
	<input type="text" name="tag0"><br>
	<input type="text" name="tag1"><br>
	<input type="text" name="tag2"><br><br>
	Actors:<br>
	<input type="text" name="actor0"><br>
        <input type="text" name="actor1"><br>
        <input type="text" name="actor2"><br><br>
	Director(s):<br>
	<input type="text" name="direc0"><br>
	<input type="text" name="direc1"><br><br>
	Producer(s):<br>
	<input type="text" name="prod0"><br>
        <input type="text" name="prod1"><br>
        <input type="text" name="prod2"><br><br>
	Screenwrtier(s):<br>
	<input type="text" name="screen0"><br>
        <input type="text" name="screen1"><br>
        <input type="text" name="screen2"><br><br>
	Editor(s):<br>
	<input type="text" name="edit0"><br>
	<input type="text" name="edit1"><br>
	<input type="text" name="edit2"><br><br>

	<input type="submit" value="Add Movie">
	
</form>
</div>	

</body>
</html>
