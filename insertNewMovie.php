<html>
<head>
        <title>Inserting movie</title>
        <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>

<?php
        session_start(); // can use this to verify user is logged in
        if (!isset($_SESSION["username"]) || !$_SESSION["manager"]) {
                header("Location: /~twecto2/CS405/Movie-Database/home.html");
                exit;
        }
	$username = $_SESSION["username"];
        
        echo "<div id=\"top\">";
        echo "\t<p style=\"font-size:75%\">Logged in as: ".$username."<br>";
        echo "You have manager privileges!<br>";
        echo "\t<a href=\"logout.php\">Log Out</a></p>";
        echo "</div>";

        $link = establishLink();
        
	$movieId = insertMovieTable($_POST, $link);
	echo $movieId;

	insertLanguages($link, $movieId, $_POST);
	insertGenres($link, $movieId, $_POST);
	insertTags($link, $movieId, $_POST);
	insertActors($link, $movieId, $_POST);
//	insertDirectors($link, $movieId, $_POST);
	insertProducers($link, $movieId, $_POST);
//	insertEditors($link, $movieId, $_POST);
	insertScreenwriters($link, $movieId, $_POST);

        
        echo "Movie successfully added!<br>";
        echo "<a href=\"main.php\">Return to Search</a>";

//---------------------------- FUNCTIONS --------------------------------------
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


function insertMovieTable($post, $link)
{
	// inserts movie into MOVIES table and returns new movie_id
	$queryString = "INSERT INTO MOVIES(title, summary, release_date, "
		      ."duration, avg_rating) VALUES ('".$post["title"]
		      ."', '".$post["summary"]."', '".$post["release"]."', '"
		      .$post["duration"]."', 'NULL');";
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

?>


</body>
</html>
