<?php
	include 'movie_db_funcs.php';

	session_start();

	if (!$_SESSION["manager"]) {
		header("Location: /~twecto2/CS405/Movie-Database/main.php");
		exit;
	}

	$link = establishLink();
	$movieId = $_GET["id"];
	$table = $_GET["table"];
	$column = $_GET["column"];
	$value = $_GET["value"];

	deleteValue($link, $movieId, $value, $table, $column);
	header("Location: /~twecto2/CS405/Movie-Database/editmovie.php?id=".$movieId);
	exit;

?>
