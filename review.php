<head>
	<title>Review</title>
</head>
<body>
<?php
	session_start();
        if(!isset($_SESSION["username"])) {
                header("Location: /~twecto2/CS405/Movie-Database/home.html");
                exit;
        }
	echo "<div id=\"top\">";
        echo "\t<p style=\"font-size:75%\">Logged in as: ".$username."<br>";

        if ($_SESSION["manager"]) {
                echo "You have manager privileges!<br>";
        } else {
                echo "Click <a href=\"managerApp.php\">here</a> to apply for"
                     ." manager privileges.<br>";
        }

        echo "\t<a href=\"logout.php\">Log Out</a></p>";
        echo "</div>";
?>

<form action=\"submitreview.php\">
<select name="rating">
	<option value="0">0</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
</select>
<select

</body>
