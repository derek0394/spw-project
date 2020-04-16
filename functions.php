<?php 
session_start();
error_reporting(0);
ini_set('display_errors', 0);
// connect to database
include 'database_connection.php';

// variable declaration
$username = "";
$email    = "";
$dob  		=  "";
$address  	=  "";
$city  		=  "";
$occupation =  "";
$errors   = array(); 
$success  = array();
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
	$username    = strtolower(e($_POST['username'])); 
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

function display_success() {
	global $success;

	if (count($success) > 0){
		echo '<div class="success1">';
			foreach ($success as $success1){
				echo $success1 .'<br>';
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
	$username = strtolower(e($_POST['username'])); 
	$password = e($_POST['password']);



	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	
				$query_password = "SELECT password FROM registered_users WHERE username='$username'";
					$result = mysqli_query($conn, $query_password);
					if ($result->num_rows > 0) {
   						while($row = $result->fetch_assoc()) {
   							$hashedPassword_fromDB = $row['password'];
   							
   							
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
			
		
				
				if(password_verify($password, $hashedPassword_fromDB))
				{
					$user=1;
					
				
} else{
	$user=0;
	
}

				
		if ($user == 1) { // user found
				$query ="SELECT * FROM registered_users WHERE username='$username' AND password='$hashedPassword_fromDB' LIMIT 1";
					$results = mysqli_query($conn, $query);

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
	//sql_inject();

}

if (isset($_POST['add'])) 
{
	uploadProfileDetails();
}



function uploadProfileDetails()
{
	global $conn, $username, $errors, $success;
	$username = $_SESSION['user']['username'];
	$dob  		=  e($_POST['dob']);
	//$address  	=  e($_POST['address']);
	$city  		=  e($_POST['city']);
	$occupation =  e($_POST['occupation']);

	if((preg_match("/^[a-zA-Z0-9,]+$/", $dob)) || (preg_match("/^[a-zA-Z,]+$/", $city)) || (preg_match("/^[a-zA-Z,]+$/", $occupation)))
{
   if($dob !='')
   {
      	 $query_dob = "UPDATE registered_users SET dob = '$dob' WHERE username = '$username'";
      	 mysqli_query($conn, $query_dob);
      	}
      
        //$query_address = "UPDATE registered_users SET address = '$address' WHERE username = '$username'";
      	 if($city !='')
   {
        $query_city = "UPDATE registered_users SET city = '$city' WHERE username = '$username'";
         mysqli_query($conn, $query_city);
     }
        if($occupation !='')
   {
        $query_occupation = "UPDATE registered_users SET occupation = '$occupation' WHERE username = '$username'";
         mysqli_query($conn, $query_occupation);
     }
        
       // mysqli_query($conn, $query_address);
       
       

    }else{
    	   array_push($errors, "Sorry, special characters are not allowed.");
}
 

}

if (isset($_POST['add_image'])) 
{
	uploadImage();
}

function uploadImage()
{
	global $conn, $username, $errors, $success;
	$username = $_SESSION['user']['username'];

	$target_dir = "images/";
$target_file = $target_dir . basename($username."profile_picture.png");
$original_name = basename($_FILES['image']["name"]);
$profile_url = basename($username."profile_picture.png");
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($original_name,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["add_image"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        //array_push($errors, "File is not an image.");
        $uploadOk = 0;
    }
}
if(basename($_FILES["image"]["name"]) != '')
{

// Check file size
if ($_FILES["image"]["size"] > 500000) {
    array_push($errors, "Sorry, your file is too large.");
    $uploadOk = 0;
}
// Allow certain file formats
/* Valid Extensions */
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    array_push($errors, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    $uploadOk = 0;
}
		
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    array_push($errors, "Sorry, your file is not uploaded.");
// if everything is ok, try to upload file
} else {

	 if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        array_push($success, "Your profile picture was successfully updated.");
         $query_profile_url = "UPDATE registered_users SET profile_url = '$profile_url' WHERE username = '$username'";
      	 mysqli_query($conn, $query_profile_url);
       }
       else {
        array_push($errors, "Sorry, there was an error uploading your file.");
    }
}}
	
}

if (isset($_POST['delete-user-btn'])) {
	deleteUser();
}

// LOGIN USER
function deleteUser(){
global $conn, $username, $errors, $success, $password;
	$username = $_SESSION['user']['username'];
	$user_to_delete = $_POST['user_to_delete'];
	$password = $_POST['password'];
$query_password = "SELECT password FROM registered_users WHERE username = '$username'";
					$result = mysqli_query($conn, $query_password);
					if ($result->num_rows > 0) {
   						while($row = $result->fetch_assoc()) {
   							$hashPassword_DB = $row['password'];
   								}
   					}
   					
   							
   				if(password_verify($password, $hashPassword_DB))
   				{
   					$user = 1;
   					
   				}
   				else
   				{
   					$user = 0;
   				
   					array_push($errors, "Wrong password");
   				}

   				if($user ==1)
   				{
   					array_push($success, "User was successfully deleted");
   					$query_delete = "DELETE FROM registered_users WHERE username = '$user_to_delete'";
   					mysqli_query($conn, $query_delete);
   				}
   							
   					
}

if (isset($_POST['add_comment'])) 
{
	addComment();
}

function addComment()
{
	global $conn, $username, $errors, $success;

	$username = $_SESSION['user']['username'];
	$error = '';
$comment_content = $_POST["comment_content"];



if(empty($_POST["comment_content"]))
{
array_push($errors, "Comment is required");
}

if($comment_content != '')
{
 $query = "INSERT INTO tbl_comment (parent_comment_id, comment, comment_sender_name) VALUES ('0', '$comment_content', 
 '$username')";
 mysqli_query($conn, $query);
 
 array_push($success, "Comment was added");
}

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

?>
