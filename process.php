<?php
session_start();

// initializing variables
$username = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'cafe');

// REGISTER USER
if(isset($_POST['reg_user'])) {
	// recieve all input values from the form
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);
	$confirm_password = mysqli_real_escape_string($db, $_POST['confirm_password']);
	// form validation: Ensure that the form is currently filled...
	// by adding (array_push()) corresponding error unto $errors array
	if (empty($username)) { array_push($errors, "Username is required"); }
	if (empty($password)) { array_push($errors, "Password is required"); }
	if ($password != $confirm_password) {
		array_push($errors, "The two passwords do not match");
	}

	$user_check_query = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);

	if ($user) {
		if ($user['username'] === $username) {
			array_push($errors, "Username already exists");
		}
	}

	if (count($errors) === 0) {
		$password = md5($password);

		$query = "INSERT INTO user (username, password) VALUES ('$username', $password')";
		mysqli_query($db, $query);
		$_SESSION['username'] = $username;
		$_SESSION['success'] = "You have signed up successfully.";
		header('location: index.php');
	}
}

	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);

	if ($user) {
		if ($user['username'] === $username) {
			array_push($errors, "Username already exists");
		}
	}

	if (count($errors) == 0) {
		$password = md5($password);
		$query = "INSERT INTO user (username, password) VALUES('$username', '$password')";
		mysqli_query($db, $query);
		$_SESSION['username'] = $username;
		$_SESSION['success'] = "You have signed up successfully.";
		header('location: index.php');
	}
}

if (isset($_POST['login_user'])) {
	$username = myqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);

	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Passwordis required");
	}

	if (count($errors) == 0) {
		$password = md5($password);
		$query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
		if (mysqli_num_rows($results) == 1) {
			$_SESSION['username'] = $username;
			$_SESSION['success'] = $username;
			header('location: index.php');
		}else {
			array_push($errors, "Wrong username/password");
		}
	}
}

?>
