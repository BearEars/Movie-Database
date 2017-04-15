<!DOCTYPE html>
<html>
<head>
	<title>Add Tags</title>
	<style type="text/css">
		body{
			background-color:lightslategrey;
			font-family: Verdana, sans-serif;
		}
		#please{
			right:500px;
			position:absolute;
			bottom: 450px;
			color:#ffffff;
			font-family: 'Raleway',sans-serif;
			font-size:50px;
			text-align: center;
		}
		#addtag{
			position:absolute;
			bottom:400px;
			right:500px;
			width:300px;
		}

	</style>
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
	<div id=please>
 	<p>Please enter your tag</p>
 	</div>
	<div id=addtag>
		<form action="submittag.php" method="POST">
			<input type="text" name="newtag">
			<input type="button" value="Submit" name="tagsubmit">
		</form>
</body>
</html>
 
