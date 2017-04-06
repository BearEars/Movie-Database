<html>
<head>
	<title>Main Page</title>
</head>

<body>
<?php
	$link;
	if (fromUserReg($_POST)) {
		$link = establishLink();
		registerUser($_POST, $link);
		echo "User successfully registered.";
	}
	elseif (fromHome($_POST)) {
		$link = establishLink();
		login($_POST, $link);
		echo "User successfully logged in.";
	}
	if (!fromUserReg($_POST) && !fromHome($_POST)) {
		// redirect user to login page if not signed in
		header("Location: /~twecto2/CS405/Movie-Database/home.html");
		exit;
	}
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
	$passQueryString = "SELECT password FROM USERS WHERE username = '"
			.$username."';";

	// get result from database and store in an associative array
	$passResult = $link->query($passQueryString);
	$passRow = mysqli_fetch_assoc($passResult);

	// check user entered password against the queried result
	if ($password != $passRow["password"]) {
		exit("Access denied: Password could not be verified");
	}
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

