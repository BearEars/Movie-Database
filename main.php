<html>
<head>
	<title>Main Page</title>
</head>

<body>
<?php
	if (fromUserReg($_POST)) {
		registerUser($_POST);
	}
	elseif (fromHome($_POST)) {
		echo "User login from main page.";
	}
	if (!fromUserReg($_POST) && !fromHome($_POST)) {
		// redirect user to login page if not signed in
		header("Location: /~twecto2/CS405/Movie-Database/home.html");
		exit;
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

function login() {
	// log an existing user in; check username/password combo
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

function registerUser($postVars) {
	// Do the things to create a new user in database
	$username = $postVars["Username"];
	$password = $postVars["Password"];
	$fName = $postVars["Fname"];
	$mName = $postVars["Mname"];
	$lName = $postVars["Lname"];
	$dob = $postVars["year"]."-".$_POST["month"]."-".$_POST["day"];
	$gender = $postVars["Gender"];
	$isManager = 0;

	/* TESTLINK IS SPECIFIC TO IP ADDRESS I'M RUNNING IN LIBRARY
	   AND DATABASE ON MY MACHINE; CHANGE FOR LATER ACCESS */
	$link = mysqli_connect("10.20.4.126", "root",
	                       "2017CS405Project", "movie_db");
	if (!$link) {
		echo "Connection failed: " . mysqli_connect_error();
		exit;
	}

	// construct string to create database user; I think we should create
	// database users for each user so everyone isn't running as root...
	$createUserString = "CREATE USER '".$username."'@'%' IDENTIFIED BY '"
			   .$password."';";

	$grantPrivs = "GRANT ALL PRIVELEGES ON movie_db.* TO '".$username
		     ."'@'%';";

	// construct string to insert into USERS tables
	$insertUserString = "INSERT INTO USERS(username, fname, mname,"
			   ."lname, dob, gender, _manager, password)"
			   ." VALUES ('".$username."', '".$fName."', '"
			   .$mName."', '".$lName."', '".$dob."', '"
			   .$gender."', '".$isManager."', '".$password
			   ."');";
	var_dump($link);
	echo "<br>";
	echo $createUserString."<br>";
	echo $grantPrivs."<br>";
	echo $insertUserString;
	$link->query($createUserString);
	$link->query($grantPrivs);
	$link->query($insertUserString);
	$link->close();
}
// ----------------------------------------------------------------------------
?>
</body>
</html>

