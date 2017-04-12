<html>
<head>
	<title>Main Page</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
<?php
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

	echo "\t<a href=\"logout.php\">Log Out</a></p>";
	echo "</div>\n";
	echo "<div id=\"padding\"></div>";
	// form for searching for movies
	echo "<div id=\"searchBox\">";
	echo "\t<h2>Search for Movies:</h2>\n";
	echo "\t<form action=\"search.php\" method=\"GET\">\n";
	// <----   FILL IN FORM HERE   ---->
	echo "\t\t<select name=\"match\" class=\"search\">\n";
	echo "\t\t\t<option value=\"nothing\"></option>\n";
	echo "\t\t\t<option value=\"title\">Title</option>\n";
	echo "\t\t\t<option value=\"genre\">Genre</option>\n";
	echo "\t\t\t<option value=\"director\">Director</option>\n";
	echo "\t\t\t<option value=\"actor\">Actor</option>\n";
	echo "\t\t</select>\n";
	echo "\t\t<input type=\"text\" name=\"search\" size=\"50\"
	      class=\"search\">\n";
	echo "\t\t<input type=\"submit\" value=\"Search\" class=\"search\">\n";
	echo "\t</form>";
	echo "</div>";

	$link->close();

// ------------------------ FUNCTIONS -----------------------------------------
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
// ------------------ USER LOGIN FROM MAIN.HTML -------------------------------
function fromHome($postVars) {
	/* Function checks if post variables from home.html are set;
           returns true if they are, false otherwise */
	$varsSet = True; 
        if (!isset($postVars["Username"]))
                $varsSet = False;
        if (!isset($postVars["Password"]))
                $varsSet = False;
	return $varsSet;
}

function login($postVars, $link) {
	// log an existing user in; check username/password combo
	$username = $postVars["Username"];
	$password = $postVars["Password"];

	// construct query string for password
	$passQueryString = "SELECT * FROM USERS WHERE username = '"
			.$username."';";

	// get result from database and store in an associative array
	$passResult = $link->query($passQueryString);
	$passRow = mysqli_fetch_assoc($passResult);

	// check user entered password against the queried result
	if ($password != $passRow["password"]) {
		exit("Access denied: Password could not be verified");
	}

	return $passRow["_manager"];
}
// ----------------------------------------------------------------------------

// ------------- USER REGISTRATION FROM USER_REGISTRATION.HTML ----------------
function fromUserReg($postVars) {
	/* Function checks if post variables from user_registration.html
	   are set; returns true if they are, false otherwise */
	$varsSet = True;
	if (!isset($postVars["Username"]))
		$varsSet = False;
	if (!isset($postVars["Password"]))
		$varsSet = False;
	if (!isset($postVars["Fname"]))
		$varsSet = False;
	if (!isset($postVars["Mname"]))
		$varsSet = False;
	if (!isset($postVars["Lname"]))
		$varsSet = False;
	if (!isset($postVars["month"]))
		$varsSet = False;
	if (!isset($postVars["day"]))
		$varsSet = False;
	if (!isset($postVars["year"]))
		$varsSet = False;
	if (!isset($postVars["Gender"]))
		$varsSet = False;
	return $varsSet;
}

function registerUser($postVars, $link) {
	// Do the things to create a new user in database
	$username = $postVars["Username"];
	$password = $postVars["Password"];
	$fName = $postVars["Fname"];
	$mName = $postVars["Mname"];
	$lName = $postVars["Lname"];
	$dob = $postVars["year"]."-".$_POST["month"]."-".$_POST["day"];
	$gender = $postVars["Gender"];
	$isManager = 0;

	// construct string to insert into USERS tables
	$insertUserString = "INSERT INTO USERS(username, fname, mname,"
			   ."lname, dob, gender, _manager, password)"
			   ." VALUES ('".$username."', '".$fName."', '"
			   .$mName."', '".$lName."', '".$dob."', '"
			   .$gender."', '".$isManager."', '".$password
			   ."');";

	// insert user into table
	$link->query($insertUserString);
}
// ----------------------------------------------------------------------------
?>
</body>
</html>

