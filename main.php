<html>
<head>
	<title>Main Page</title>
</head>

<body>
<?php
	if (fromUserReg($_POST)) {
		echo "User registration form filled out.<br>";

		/* TESTLINK IS SPECIFIC TO IP ADDRESS I'M RUNNING IN LIBRARY
		   AND DATABASE ON MY MACHINE; CHANGE FOR LATER ACCESS */
		$testlink = mysqli_connect("10.20.4.126", "cs405team", 
                                           "2017CS405Project", "movie_db");
		if (!$testlink) {
			echo "Connection failed: " . mysqli_connect_error();
			exit;
		}
		
		echo "Successfully connected to MySQL database!<br>";
		var_dump($testlink);
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

function registerUser() {
	// Do the things to create a new user in database
}
// ----------------------------------------------------------------------------
?>
</body>
</html>

