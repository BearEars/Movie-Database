<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php 
	session_start();//can use this to verify user is logged in
	if(!isset($_SESSION["username"])){
		header("Location: /~twecto2/CS405/Movie_Database/home.html");
		exit;
	}
	if(!isset($_GET['movie_id'])){
		echo "Invalid movie";
	}
	echo"<div id=\"top\">";
	echo "\t<p style=\"font-size:75%\">Logged in as: ".$username."<br>";

	if($_SESSION["manager"]){
		echo "You have manager privileges!<br>";
	}
	else{
		echo "Click <a href=\"managerApp.php\">here</a> to apply for"."manager privileges . <br>";
	}
	echo "\t<a href=\"logout.php\">Log Out</a></p>";
	echo"</div>";
 ?>
	<div id=addtag>
		<form method="POST">
			<input type="text" name="newtag">
			<input type="button" value="Submit" name="tagsubmit">
		</form>
</body>
 