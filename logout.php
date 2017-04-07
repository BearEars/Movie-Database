<?php

// short script to log a user out
session_start();
unset($_SESSION["username"]);
header("Location: /~twecto2/CS405/Movie-Database/home.html");
exit;

?>
