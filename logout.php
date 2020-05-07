<?php session_start(); ?>


<?php

$_SESSION['user_id'] = null;
$_SESSION['user_major'] = null;
$_SESSION['user_auth'] = null;

header("Location: index.php");

?>