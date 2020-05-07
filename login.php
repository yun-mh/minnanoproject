<?php session_start(); ?>
<?php include "includes/db.php"; ?>
<?php include "includes/functions.php"; ?>

<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<?php

if(isset($_POST['login'])) {
	
	$user_id = escape($_POST['user_id']);
	$user_password = escape($_POST['user_password']);
	
	login_user($user_id, $user_password);
	
} 




?>