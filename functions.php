<?php 
session_start();

// connect to database
include 'database_connection.php';

// variable declaration
$username = "";
$email    = "";
$errors   = array(); 
$ip_address = $_SERVER['REMOTE_ADDR'];

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}



// REGISTER USER
function register(){

	// call these variables with the global keyword to make them available in function
	global $conn, $errors, $username, $email, $ip_address;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}
	date_default_timezone_set("Europe/Dublin");
 	$date_time = date("Y-m-d h:i:sa");
	// register user if there are no errors in the form
	if (count($errors) == 0) {
				
		$options = [
		  'cost' => 11
		];
		$password = password_hash($password_1, PASSWORD_BCRYPT, $options);

		if (isset($_POST['user_type'])) {
			$user_type = e($_POST['user_type']);
			$query = "INSERT INTO registered_users (username, email, user_type, password, date_time, ip_address) 
					  VALUES('$username', '$email', '$user_type', '$password', '$date_time', '$ip_address')";
					  
			mysqli_query($conn, $query);
			$_SESSION['success']  = "New user successfully created!!";
			header('location: home.php');
		}else{
			$query = "INSERT INTO registered_users (username, email, user_type, password, date_time, ip_address) 
					  VALUES('$username', '$email', 'user', '$password','$date_time','$ip_address')";
			mysqli_query($conn, $query);

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($conn);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: index.php');				
		}
	}
}

// return user array from their id
function getUserById($id){
	global $conn;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($conn, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $conn;
	return mysqli_real_escape_string($conn, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}	



// log user out if logout button clicked
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN USER
function login(){
	
	global $conn, $username, $errors, $ip_address;
	date_default_timezone_set("Europe/Dublin");
 	$date_time = date("Y-m-d h:i:sa");

	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);



	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	
				$query_password = "SELECT password FROM registered_users";
					$result = mysqli_query($conn, $query_password);
					if ($result->num_rows > 0) {
   						while($row = $result->fetch_assoc()) {
   							$hashedPassword_fromDB[] = $row['password'];
   							
   							
   						}
   					}

   					$query_failed_attempts = "SELECT failed_attempts FROM registered_users WHERE username = '$username'";
			//echo $query_failed_attempts;
					$result1 = mysqli_query($conn, $query_failed_attempts);
					if ($result1->num_rows > 0) {
   						while($row = $result1->fetch_assoc()) {
   							$failed_attempts = $row['failed_attempts'];
   							
   						}}
   							
if($failed_attempts < 4){	
	if (count($errors) == 0) {	
			
		for($i=0;$i<=count($hashedPassword_fromDB);$i++)
			{
				
				if(password_verify($password, $hashedPassword_fromDB[$i]))
				{
					$query ="SELECT * FROM registered_users WHERE username='$username' AND password='$hashedPassword_fromDB[$i]' LIMIT 1";
					$results = mysqli_query($conn, $query);
}} 

				
		if (mysqli_num_rows($results) == 1) { // user found

			$query1 = "UPDATE registered_users SET failed_attempts = 0 WHERE username = '$username'";
				echo $query1;
				mysqli_query($conn, $query1);

			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['user_type'] == 'admin') {
				$user_type = "admin";
				$query = "INSERT INTO user_logs (username, user_type, date_time, ip_address) 
					  VALUES('$username', '$user_type', '$date_time', '$ip_address')";
					  
			mysqli_query($conn, $query);

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: admin/home.php');		  
			}else{
				$user_type = "user";
				$query = "INSERT INTO user_logs (username, user_type, date_time, ip_address) 
					  VALUES('$username', '$user_type', '$date_time', '$ip_address')";
					  
			mysqli_query($conn, $query);

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: index.php');

				

			}
			}
			

		else {
		
			$query = "INSERT INTO wrong_user_logs (username, date_time, ip_address) 
					  VALUES('$username', '$date_time', '$ip_address')";
					  
			mysqli_query($conn, $query);
			$number = 1;
   							$failed_attempts_1 = $failed_attempts + $number;
			
				if($failed_attempts < 5)
				{
				$query1 = "UPDATE registered_users SET failed_attempts = '$failed_attempts_1' WHERE username = '$username'";
				
				mysqli_query($conn, $query1);
			}
			
			
			if($failed_attempts < 5)
				{
					  sleep($failed_attempts);
				array_push($errors, "Wrong username/password combination");
			}
			
			
		
		}}
	}
	else{
				array_push($errors, "User has used max login attempts. Please use Forgot password to reset password");
			}
}

			if (isset($_POST['submit'])) {
	sql_inject();

}
function sql_inject()
{
	global $conn;
$query1 = "SELECT * FROM registered_users WHERE email = $_POST[email] AND password = $_POST[password]";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo $query1;
$result1 = mysqli_query($conn, $query1);
		if ($result1->num_rows > 0) {
				while($row = $result1->fetch_assoc()) {
					$username = $row['username'];
					$password = $row['password'];
					echo $username;
				}}
}	
			

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
		
	}
}

function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}

