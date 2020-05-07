<?php

function confirmQuery($result) {
	
	global $connection;
	
	if(!$result) {
		die("クエリに失敗しました。" . mysqli_error($connection));
	}
			
}



function escape($string) {

	global $connection;

	return mysqli_real_escape_string($connection, trim($string));

}



function userID_exists($user_id) {
	
	global $connection;
	
	$idexist_query = "SELECT user_id FROM users WHERE user_id = '$user_id' ";
	$result = mysqli_query($connection, $idexist_query);
	confirmQuery($result);
	
	if(mysqli_num_rows($result) > 0) {
		
		return true;
		
	} else {
		
		return false;
		
	}
	
}



function email_exists($user_email) {
	
	global $connection;
	
	$query = "SELECT user_email FROM users WHERE user_email = '$user_email' ";
	$result = mysqli_query($connection, $query);
	confirmQuery($result);
	
	if(mysqli_num_rows($result) > 0) {
		
		return true;
		
	} else {
		
		return false;
		
	}
	
}


function validate_account($user_id, $user_email) {
	
	global $connection;
	
	$query = "SELECT user_id, user_email FROM users WHERE user_id = '$user_id' and user_email = '$user_email' ";
	$result = mysqli_query($connection, $query);
	confirmQuery($result);
	
	if(mysqli_num_rows($result) > 0) {
		return true;
	} else {
		return false;
	}
	
}



function redirect($location) {
	
	header("Location: " . $location);
	exit;
	
}



function loggedInUserNum() {
	
	global $connection;
	
	if(isLoggedIn()) {
		
		$result = mysqli_query($connection, "SELECT * FROM users WHERE user_id = '" . $_SESSION['user_id'] . "'");
		$user = mysqli_fetch_array($result);
		confirmQuery($result);
		
		if(mysqli_num_rows($result) >= 1) {
			return $user['user_num'];
		}
		
	}
	
	return false;
	
}



function userUp($post_id) {
	
	global $connection;
	
	$result = mysqli_query($connection, "SELECT * FROM up_stage WHERE user_num=" . loggedInUserNum() . " AND post_id = {$post_id}");
	confirmQuery($result);
	
	return mysqli_num_rows($result) >= 1 ? true : false;
	
}



function getPostUp($post_id) {
	
	global $connection;
	$result = mysqli_query($connection, "SELECT * FROM up_stage WHERE post_id = $post_id");
	confirmQuery($result);
	echo mysqli_num_rows($result);
	
}



function ifItIsMethod($method=null) {
	
	if($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
		
		return true;
		
	}
	
	return false;
	
}


function isLoggedIn() {
	
	if(isset($_SESSION['user_id'])) {
		
		return true;
		
	}
	
	return false;
	
}



function checkIfLoggedIn($redirectLocation) {
	
	if(isLoggedIn()) {
		
		header("Location: " . $redirectLocation);
		exit;
		
	}
	
}



function register_user($user_id, $user_password, $user_email, $user_major) {
	
	global $connection;

	$user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

	$query = "INSERT INTO users (user_id, user_password, user_email, user_major) ";
	$query .= "VALUES('{$user_id}', '{$user_password}', '{$user_email}', '{$user_major}')";
	$register_user_query = mysqli_query($connection, $query);

	confirmQuery($register_user_query);

}

	
	
function login_user($user_id, $user_password) {
	
	global $connection;
	
	$user_id = trim($user_id);
	$user_password = trim($user_password);
	
	$user_id = mysqli_real_escape_string($connection, $user_id);
	$user_password = mysqli_real_escape_string($connection, $user_password);
	
	$query = "SELECT * FROM users WHERE user_id = '{$user_id}' ";
	$select_user_query = mysqli_query($connection, $query);
	
	if(!$select_user_query) {
		die("クエリに失敗しました。" . mysqli_error($connection));
	}
	
	while($row = mysqli_fetch_array($select_user_query)) {
		$db_user_num = $row['user_num'];
		$db_user_id = $row['user_id'];
		$db_user_password = $row['user_password'];
		$db_user_email = $row['user_email'];
		$db_user_major = $row['user_major'];
		$db_user_auth = $row['user_auth'];
	}
		
	if(password_verify($user_password, $db_user_password)) {

		if (session_status() == PHP_SESSION_NONE) session_start();
		
		$_SESSION['user_id'] = $db_user_id;
		$_SESSION['user_major'] = $db_user_major;
		$_SESSION['user_auth'] = $db_user_auth;
		
		header("Location: home.php");


	} else {
		
		header("Location: index.php?msg=error");
	
	}
	
}


?> 