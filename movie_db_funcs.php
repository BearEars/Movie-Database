<?php

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
//--------------------------------SEARCH FUNC--------------------------------
function doSearch($link, $match, $searchString)
{
        switch($match) {
                case "title":
                {
                        echo "<div class=\"bigwords\">";
                        echo "<h1>Showing results for movies with '"
			     .$searchString."' in the title...</h1>";
                        echo "</div>";
                        $queryString = "SELECT * FROM MOVIES WHERE TITLE LIKE"
                                       ." '%".$searchString."%';";
                        $searchResult = $link->query($queryString);
                        return $searchResult;
                }
                case "genre":
                {
                        echo "<div class=\"bigwords\">";
                        echo "<h1>Showing results for movies in the '"
                             .$searchString."' genre...</h1>";
                        echo "</div>";
                        $queryString = "SELECT * FROM MOVIES AS M"
                                      ." WHERE M.MOVIE_ID IN (SELECT MOVIE_ID"
                                      . " FROM MOVIE_GENRE WHERE GENRE_TYPE "
                                      ."LIKE '%".$searchString."%');";
                        $searchResult = $link->query($queryString);
                        return $searchResult;
                }
                case "director":
		{
                        echo "<div class=\"bigwords\">";
                        echo "<h1>Showing results for movies directed by '"
                             .$searchString."'...</h1>";
                        echo "</div>";
                        $queryString = "SELECT * FROM MOVIES AS M WHERE "
                                      ."M.MOVIE_ID IN (SELECT MOVIE_ID FROM "
                                      ."DIRECTORS WHERE DIRECTOR LIKE '%"
                                      .$searchString."%');";
                        $searchResult = $link->query($queryString);
                        return $searchResult;
                }
                case "actor":
                {
                        echo "<div class=\"bigwords\">";
                        echo "<h1>Showing results for movies starring '"
                             .$searchString."'...</h1>";
                        echo "</div>";
                        $queryString = "SELECT * FROM MOVIES AS M WHERE "
                                      ."M.MOVIE_ID IN (SELECT MOVIE_ID FROM "
                                      ."ACTORS WHERE ACTOR LIKE '%"
                                      .$searchString."%');";
                        $searchResult = $link->query($queryString);
                        return $searchResult;
                }
		case "language":
		{
			echo "<div class=\"bigwords\">";
                        echo "<h1>Showing results for movies in '"
                             .$searchString."'...</h1>";
                        echo "</div>";
                        $queryString = "SELECT * FROM MOVIES AS M WHERE "
                                      ."M.MOVIE_ID IN (SELECT MOVIE_ID FROM "
                                      ."LANGUAGES WHERE LANGUAGE LIKE '%"
                                      .$searchString."%');";
                        $searchResult = $link->query($queryString);
                        return $searchResult;
		}
		case "producer":
		{
			echo "<div class=\"bigwords\">";
                        echo "<h1>Showing results for movies produced by '"
                             .$searchString."'...</h1>";
                        echo "</div>";
                        $queryString = "SELECT * FROM MOVIES AS M WHERE "
                                      ."M.MOVIE_ID IN (SELECT MOVIE_ID FROM "
                                      ."PRODUCER WHERE PRODUCER LIKE '%"
                                      .$searchString."%');";
                        $searchResult = $link->query($queryString);
                        return $searchResult;
		}
		case "editor":
		{
			echo "<div class=\"bigwords\">";
                        echo "<h1>Showing results for movies edited by '"
                             .$searchString."'...</h1>";
                        echo "</div>";
                        $queryString = "SELECT * FROM MOVIES AS M WHERE "
                                      ."M.MOVIE_ID IN (SELECT MOVIE_ID FROM "
                                      ."EDITORS WHERE EDITOR LIKE '%"
                                      .$searchString."%');";
                        $searchResult = $link->query($queryString);
                        return $searchResult;
		}
		case "screenwriter":
		{
			echo "<div class=\"bigwords\">";
                        echo "<h1>Showing results for movies written by '"
                             .$searchString."'...</h1>";
                        echo "</div>";
                        $queryString = "SELECT * FROM MOVIES AS M WHERE "
                                      ."M.MOVIE_ID IN (SELECT MOVIE_ID FROM "
                                      ."SCREENWRITER WHERE SCREENWRITER LIKE '%"
                                      .$searchString."%');";
                        $searchResult = $link->query($queryString);
                        return $searchResult;
		}
		case "tag":
		{
			echo "<div class=\"bigwords\">";
                        echo "<h1>Showing results for movies tagged with '"
                             .$searchString."'...</h1>";
                        echo "</div>";
                        $queryString = "SELECT * FROM MOVIES AS M WHERE "
                                      ."M.MOVIE_ID IN (SELECT MOVIE_ID FROM "
                                      ."MOVIE_TAG WHERE TAG_TYPE LIKE '%"
                                      .$searchString."%');";
                        $searchResult = $link->query($queryString);
                        return $searchResult;
		}
                default:
                {
                        return;
                }
        }
}
// ------------------------RETRIEVING FROM DATABASE-------------------------
function getFromMovieTable($link, $movieId)
{
        $queryString = "SELECT * FROM MOVIES WHERE MOVIE_ID = ".$movieId.";";
        $searchResult = $link->query($queryString);
        return mysqli_fetch_assoc($searchResult);
}

function getFromLanguageTable($link, $movieId)
{
        $queryString = "SELECT * FROM LANGUAGES WHERE MOVIE_ID = ".$movieId.";";
        return $link->query($queryString);
}

function getFromGenreTable($link, $movieId)
{
        $queryString = "SELECT * FROM MOVIE_GENRE WHERE MOVIE_ID = "
                       .$movieId.";";
        return $link->query($queryString);
}

function getFromTagTable($link, $movieId)
{
        $queryString = "SELECT * FROM MOVIE_TAG WHERE MOVIE_ID = "
                       .$movieId.";";
        return $link->query($queryString);
}

function getFromActorTable($link, $movieId)
{
        $queryString = "SELECT * FROM ACTORS WHERE MOVIE_ID = ".$movieId.";";
        return $link->query($queryString);
}

function getFromDirectors($link, $movieId) {
        $queryString = "SELECT * FROM DIRECTORS WHERE MOVIE_ID = "
                       .$movieId.";";
        return $link->query($queryString);
}

function getFromEditors($link, $movieId) {
        $queryString = "SELECT * FROM EDITORS WHERE MOVIE_ID = "
                       .$movieId.";";
        return $link->query($queryString);
}

function getFromScreenwriters($link, $movieId) {
        $queryString = "SELECT * FROM SCREENWRITER WHERE MOVIE_ID = "
                       .$movieId.";";
        return $link->query($queryString);
}

function getFromProducerTable($link, $movieId) {
        $queryString = "SELECT * FROM PRODUCER WHERE MOVIE_ID = ".$movieId.";";
        return $link->query($queryString);
}

function getFromRatingsTable($link, $movieId) {
        $queryString = "SELECT * FROM RATINGS WHERE MOVIE_ID = ".$movieId.";";
        return $link->query($queryString);
}

function getFromWatchList($link, $username) {
	$queryString = "SELECT * FROM MOVIES AS M WHERE "
			."M.MOVIE_ID IN (SELECT MOVIE_ID FROM "
			."WATCHLIST WHERE USERNAME = '".$username."');";
	$searchResult = $link->query($queryString);
	return $searchResult;
}
//--------------------INSERTING NEW MOVIE INFO--------------------------------
function insertMovieTable($post, $link)
{
        // inserts movie into MOVIES table and returns new movie_id
        $queryString = "INSERT INTO MOVIES(title, summary, release_date, "
                      ."duration) VALUES ('".$post["title"]
                      ."', '".$post["summary"]."', '".$post["release"]."', '"
                      .$post["duration"]."');";
        $retrievalString = "SELECT * FROM MOVIES WHERE TITLE = '"
                           .$post["title"]."';";

        $link->query($queryString);

        $result = $link->query($retrievalString);
        $row = mysqli_fetch_assoc($result);
        return $row["movie_id"];
}

function insertLanguages($link, $movieId, $post) {
        // checks to see if languages are filled out, inserts them into table
        for ($i = 0; $i < 3; $i++) {
                $pVar = "lang".$i;
                if ($post[$pVar] != "") {
                        $queryString = "INSERT INTO LANGUAGES(movie_id, "
                                ."language) VALUES ("
                                .$movieId.", '".$post[$pVar]."');";
                        $link->query($queryString);
                }
        }
}

function insertGenres($link, $movieId, $post) {
        // checks to see if genres are filled out, inserts them into table
        for ($i = 0; $i < 3; $i++) {
                $pVar = "gen".$i;
                if ($post[$pVar] != "") {
                        $queryString = "INSERT INTO MOVIE_GENRE VALUES ('"
                                .$post[$pVar]."', ".$movieId.");";
                        $link->query($queryString);
                }
        }
}

function insertTags($link, $movieId, $post) {
        // checks to see if tags are filled out, inserts them into table
        for ($i = 0; $i < 3; $i++) {
                $pVar = "tag".$i;
                if ($post[$pVar] != "") {
                        $queryString = "INSERT INTO MOVIE_TAG VALUES ('"
                                .$post[$pVar]."', ".$movieId.");";
                        $link->query($queryString);
                }
        }
}

function insertActors($link, $movieId, $post) {
        // checks to see if actors are filled out, inserts them into table
        for ($i = 0; $i < 3; $i++) {
                $pVar = "actor".$i;
                if ($post[$pVar] != "") {
                        $queryString = "INSERT INTO ACTORS VALUES ("
                                .$movieId.", '".$post[$pVar]."');";
                        $link->query($queryString);
                }
        }
}

function insertDirectors($link, $movieId, $post) {
        // checks to see if directors are filled out, inserts them into table
        for ($i = 0; $i < 2; $i++) {
                $pVar = "direc".$i;
                if ($post[$pVar] != "") {
                        $queryString = "INSERT INTO DIRECTORS VALUES ("
                                .$movieId.", '".$post[$pVar]."');";
                        $link->query($queryString);
                }
        }
}

function insertProducers($link, $movieId, $post) {
        // checks to see if producers are filled out, inserts them into table
        for ($i = 0; $i < 3; $i++) {
                $pVar = "prod".$i;
                if ($post[$pVar] != "") {
                        $queryString = "INSERT INTO PRODUCER VALUES ("
                                .$movieId.", '".$post[$pVar]."');";
                        $link->query($queryString);
                }
        }
}

function insertEditors($link, $movieId, $post) {
        // checks to see if editors are filled out, inserts them into table
        for ($i = 0; $i < 3; $i++) {
                $pVar = "edit".$i;
                if ($post[$pVar] != "") {
                        $queryString = "INSERT INTO EDITORS VALUES ("
                                .$movieId.", '".$post[$pVar]."');";
                        $link->query($queryString);
                }
        }
}

function insertScreenwriters($link, $movieId, $post) {
        // checks to see if screenwriters are filled out, inserts them into table
        for ($i = 0; $i < 3; $i++) {
                $pVar = "screen".$i;
                if ($post[$pVar] != "") {
                        $queryString = "INSERT INTO SCREENWRITER VALUES ("
                                .$movieId.", '".$post[$pVar]."');";
                        $link->query($queryString);
                }
        }
}
//-----------------INSERTING A NEW REVIEW--------------------------------------
function addReview($link, $username, $rating, $review, $movieId)
{
        $queryString = "INSERT INTO RATINGS VALUES ('"
                       .$username."', ".$movieId.", "
                       .$rating.", '".$review."');";
        $link->query($queryString);
}
//-------------------ADD MOVIE TO WATCHLIST-----------------------------------
function addToWatchList($link, $username, $movieId)
{
	$queryString = "INSERT INTO WATCHLIST VALUES('".$username."', "
			.$movieId.");";
	$link->query($queryString);
}
//-------------UPDATING THE DATABASE--------------------------------------
function updateMovieTable($link, $post) {
	$queryString = "UPDATE MOVIES SET title='".$post["title"]
		."', summary='".$post["summary"]."', release_date='"
		.$post["release"]."', duration='".$post["duration"]
		."' WHERE movie_id = ".$post["movieId"].";";
	$link->query($queryString);
}

function updateLanguageTable($link, $post) {
	for ($i = 0; $i < 3; $i++) {
		$key = "lang".$i;
		if ($post[$key] != "") {
			$queryString = "REPLACE INTO LANGUAGES VALUES ("
				.$post["movieId"].", '".$post[$key]
				."');";
			$link->query($queryString);
		}
	}	
}

function updateGenreTable($link, $post) {
	for ($i = 0; $i < 3; $i++) {
                $key = "gen".$i;
                if ($post[$key] != "") {
                        $queryString = "REPLACE INTO MOVIE_GENRE VALUES ('"
                                .$post[$key]."', ".$post["movieId"]
                                .");";
                        $link->query($queryString);
                }
        }  
}

function updateTagTable($link, $post) {
	for ($i = 0; $i < 3; $i++) {
                $key = "tag".$i;
                if ($post[$key] != "") {
                        $queryString = "REPLACE INTO MOVIE_TAG VALUES ('"
                                .$post[$key]."', ".$post["movieId"]
                                .");";
                        $link->query($queryString);
                }
        }
}

function updateActorTable($link, $post) {
	for ($i = 0; $i < 3; $i++) {
                $key = "actor".$i;
                if ($post[$key] != "") {
                        $queryString = "REPLACE INTO ACTORS VALUES ("
                                .$post["movieId"].", '".$post[$key]
                                ."');";
                        $link->query($queryString);
                }
        } 
}

function updateDirectorTable($link, $post) {
	for ($i = 0; $i < 2; $i++) {
                $key = "direc".$i;
                if ($post[$key] != "") {
                        $queryString = "REPLACE INTO DIRECTORS VALUES ("
                                .$post["movieId"].", '".$post[$key]
                                ."');";
                        $link->query($queryString);
                }
        } 
}

function updateProducerTable($link, $post) {
	for ($i = 0; $i < 3; $i++) {
                $key = "prod".$i;
                if ($post[$key] != "") {
                        $queryString = "REPLACE INTO PRODUCER VALUES ("
                                .$post["movieId"].", '".$post[$key]
                                ."');";
                        $link->query($queryString);
                }
        } 
}

function updateScreenwriterTable($link, $post) {
	for ($i = 0; $i < 3; $i++) {
                $key = "screen".$i;
                if ($post[$key] != "") {
                        $queryString = "REPLACE INTO SCREENWRITER VALUES ("
                                .$post["movieId"].", '".$post[$key]
                                ."');";
                        $link->query($queryString);
                }
        } 
}

function updateEditorTable($link, $post) {
	for ($i = 0; $i < 3; $i++) {
                $key = "edit".$i;
                if ($post[$key] != "") {
                        $queryString = "REPLACE INTO EDITORS VALUES ("
                                .$post["movieId"].", '".$post[$key]
                                ."');";
                        $link->query($queryString);
                }
        } 
}

//------------------SORTING-----------------------------------------------
function quicksort($movieArray, $sortBy, $sortOrder)
{
	if(count($movieArray) < 2) {
		return $movieArray;
	}
	$left = $right = array();
	reset($movieArray);
	$pivKey = key($movieArray);
	$pivot = array_shift($movieArray);
	if ($sortOrder == "ascending") {
		foreach($movieArray as $key => $value) {
			if ($value[$sortBy] < $pivot[$sortBy])
				$left[$key] = $value;
			else
				$right[$key] = $value;
		}
	} else {
		foreach($movieArray as $key => $value) {
                        if ($value[$sortBy] > $pivot[$sortBy])
                                $left[$key] = $value;
                        else
                                $right[$key] = $value;
		}
	}
	return array_merge(quicksort($left, $sortBy, $sortOrder),
			   array($pivKey => $pivot),
			   quicksort($right, $sortBy, $sortOrder));
}
//------------------------ADDING MANAGER PRIVILEGES---------------------------
function getNonManagers($link)
{
	$queryString = "SELECT * FROM USERS WHERE _manager = 0";
	return $link->query($queryString);
}

function updatePrivileges($link, $username)
{
	$queryString = "UPDATE USERS SET _manager = 1 WHERE username = '"
			.$username."';";
	$link->query($queryString);
}

?>
