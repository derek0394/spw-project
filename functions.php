<?php 
session_start();
session_regenerate_id();
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

    $ip_address = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ip_address = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ip_address = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ip_address = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ip_address = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ip_address = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ip_address = getenv('REMOTE_ADDR');
    else
        $ip_address = 'UNKNOWN';
$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() { 

    global $user_agent, $user_os;
    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser() {

    global $user_agent, $user_browser;

    $browser        = "Unknown Browser";

    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}


$user_os        = getOS();
$user_browser   = getBrowser();

//$device_details = "<strong>Browser: </strong>".$user_browser."<br /><strong>Operating System: </strong>".$user_os."";

//print_r($device_details);


// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}



// REGISTER USER
function register()
{

	// call these variables with the global keyword to make them available in function
	global $conn, $errors, $username, $email, $ip_address, $user_os, $user_browser;
	$username    = strtolower(e($_POST['username'])); 
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	$mysqli = new mysqli('localhost', 'root', '', 'application');
		
	$stmt = $mysqli->prepare("SELECT * FROM registered_users WHERE username = ?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();

	while($row = $result->fetch_assoc()) {
	  $username_from_DB = $row['username'];
	 
	}
	$stmt->close();

	$stmt = $mysqli->prepare("SELECT * FROM registered_users WHERE email = ?");
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$result = $stmt->get_result();

	while($row = $result->fetch_assoc()) {
	  $email_from_DB = $row['email'];
	 
	}
	$stmt->close();


	if(isset($_POST['g-recaptcha-response'])){
      $captcha=$_POST['g-recaptcha-response'];
    }
      if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
          array_push($errors, "Invalid Captcha");
        }
        $secretKey = "Your Secret KEY";
        $ip = $_SERVER['REMOTE_ADDR'];
        // post request to server
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true); 


	if(!preg_match("/^[a-zA-Z0-9]+$/", $username))
	{
		array_push($errors, "Only alphabets and numbers are allowed in username"); 
	}
	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if(strlen($username) >= 11)
	{
		array_push($errors, "Max username length should be 10"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "Passwords do not match"); 
	}
	if(strlen($password_1) <= 9)
	{
		array_push($errors, "Minimum password length should be 10"); 
	}
	
	if ((!filter_var($email, FILTER_VALIDATE_EMAIL)) && ($email != '')) {
    	array_push($errors, "Invalid Email ID");
	}
	
	if($username == $username_from_DB)
	{
		array_push($errors, "Username already exists");
	}
	if(($email == $email_from_DB) && ($email != ''))
	{
		array_push($errors, "Email already exists");
	}

	date_default_timezone_set("Europe/Dublin");
 	$date_time = date("Y-m-d h:i:sa");
	// register user if there are no errors in the form
	if (count($errors) == 0) 
	{
		 
		//To generate hash for password
		$options = [
		'cost' => 11
		];

		$password = password_hash($password_1, PASSWORD_BCRYPT, $options);

		if (isset($_POST['user_type'])) 
		{
			$query = "INSERT INTO registered_users (username, email, user_type, password, date_time, ip_address, user_os, user_browser) 
					  VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
					  $user_type = 'user';
					  
			$stmt = mysqli_prepare($conn, $query);
			mysqli_stmt_bind_param($stmt, "ssssssss", $username, $email, $user_type, $password, $date_time, $ip_address, $user_os, $user_browser);
			mysqli_stmt_execute($stmt);
			$_SESSION['success']  = "New user successfully created!!";
			header('location: home.php');
		}
		else
		{
			$query = "INSERT INTO registered_users (username, email, user_type, password, date_time, ip_address, user_os, user_browser) 
					  VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
					  $user_type = 'user';
					  
			$stmt = mysqli_prepare($conn, $query);
			mysqli_stmt_bind_param($stmt, "ssssssss", $username, $email, $user_type, $password, $date_time, $ip_address, $user_os, $user_browser);
			mysqli_stmt_execute($stmt);
			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($conn);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: index.php');				
		}
	}
}

// return user array from their id
function getUserById($id)
{
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
if (isset($_GET['logout'])) 
{
	global $conn, $username;
	$username = $_SESSION['user']['username'];
	date_default_timezone_set("Europe/Dublin");
 	$date_time = date("Y-m-d h:i:sa");


	$query_password = "SELECT date_time FROM registered_users WHERE username='$username'";
		$result = mysqli_query($conn, $query_password);
		if ($result->num_rows > 0) 
		{
			while($row = $result->fetch_assoc()) 
			{
				$date_time_from_DB = $row['date_time'];			
			}
		}

	$query_logout_time = "UPDATE user_logs SET logout_time = '$date_time' WHERE username = '$username' AND logout_time =' '";
				//echo $query_logout_time;
				mysqli_query($conn, $query_logout_time);

	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");

}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) 
{
	login();
}

// LOGIN USER
function login(){
	
	global $conn, $username, $errors, $ip_address, $user_os, $user_browser;
	date_default_timezone_set("Europe/Dublin");
 	$date_time = date("Y-m-d h:i:sa");

	// grap form values
	$username = strtolower(e($_POST['username'])); 
	$password = e($_POST['password']);
	if(isset($_POST['g-recaptcha-response'])){
      $captcha=$_POST['g-recaptcha-response'];
    }
      if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
          array_push($errors, "Invalid Captcha");
        }
        $secretKey = "Your secret Key";
        $ip = $_SERVER['REMOTE_ADDR'];
        // post request to server
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true); 
       
	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}
	if(!preg_match("/^[a-zA-Z0-9]+$/", $username))
	{
		array_push($errors, "Wrong username/password combination");
	}
	
	$query_password = "SELECT password FROM registered_users WHERE username='$username'";
		$result = mysqli_query($conn, $query_password);
		if ($result->num_rows > 0) 
		{
			while($row = $result->fetch_assoc()) 
			{
				$hashedPassword_fromDB = $row['password'];			
			}
		}

	$query_failed_attempts = "SELECT failed_attempts FROM registered_users WHERE username = '$username'";

		$result1 = mysqli_query($conn, $query_failed_attempts);
		if ($result1->num_rows > 0) 
		{
				while($row = $result1->fetch_assoc()) 
				{
					$failed_attempts = $row['failed_attempts'];
					
				}
		}
   				
   							
if($failed_attempts < 4){	
	if (count($errors) == 0) 
	{	
			
				if(password_verify($password, $hashedPassword_fromDB))
				{
					$user=1;
				} 
				else
				{
					$user=0;
				}

				
		if ($user == 1) { // user found
			$query ="SELECT * FROM registered_users WHERE username='$username' AND 
			password='$hashedPassword_fromDB' LIMIT 1";
			$results = mysqli_query($conn, $query);

			$query1 = "UPDATE registered_users SET failed_attempts = 0 WHERE username = '$username'";
				//echo $query1;
				mysqli_query($conn, $query1);

			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['user_type'] == 'admin') {
				$user_type = "admin";
				$query = "INSERT INTO user_logs (username, user_type, date_time, ip_address, user_os, user_browser) 
					  VALUES(?, ?, ?, ?, ?, ?)";
					  
			$stmt = mysqli_prepare($conn, $query);
			mysqli_stmt_bind_param($stmt, "ssssss", $username, $user_type, $date_time, $ip_address, $user_os, $user_browser);
			mysqli_stmt_execute($stmt);

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: admin/home.php');		  
			}else{
				$user_type = "user";
				$query = "INSERT INTO user_logs (username, user_type, date_time, ip_address, user_os, user_browser) 
					  VALUES(?, ?, ?, ?, ?, ?)";
					  
			$stmt = mysqli_prepare($conn, $query);
			mysqli_stmt_bind_param($stmt, "ssssss", $username, $user_type, $date_time, $ip_address, $user_os, $user_browser);
			mysqli_stmt_execute($stmt);

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: index.php');

				

			}
			}
			
		else {
		
			$query = "INSERT INTO wrong_user_logs (username, date_time, ip_address, user_os, user_browser) 
					  VALUES(?, ?, ?, ?, ?)";
					  
			$stmt = mysqli_prepare($conn, $query);
			mysqli_stmt_bind_param($stmt, "sssss", $username, $date_time, $ip_address, $user_os, $user_browser);
			mysqli_stmt_execute($stmt);
			$number = 1;
   							$failed_attempts_1 = $failed_attempts + $number;
			
				if($failed_attempts < 5)
				{
				$query1 = "UPDATE registered_users SET failed_attempts = ? WHERE username = ?";
				
				$stmt = mysqli_prepare($conn, $query1);
			mysqli_stmt_bind_param($stmt, "si", $failed_attempts_1, $username);
			mysqli_stmt_execute($stmt);
			}
			
			
			if($failed_attempts < 5)
				{
					sleep($failed_attempts);
					array_push($errors, "Wrong username/password combination");
				}
			
			
		
			}
		}
	}
	else
	{
		array_push($errors, "User has used max login attempts. Please use Forgot password to reset password");
	}
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
	$city  		=  strtoupper(e($_POST['city']));
	$occupation =  strtoupper(e($_POST['occupation']));

	if((preg_match("/^[0-9-]+$/", $dob)) || (preg_match("/^[a-zA-Z ]+$/", $city)) || (preg_match("/^[a-zA-Z ]+$/", $occupation)))
	{
   		if($dob !='')
   		{
	      	 $query_dob = "UPDATE registered_users SET dob = ? WHERE username = ?";
	      	$stmt = mysqli_prepare($conn, $query_dob);
			mysqli_stmt_bind_param($stmt, "ss", $dob, $username);
			mysqli_stmt_execute($stmt);
      	}
      
        //$query_address = "UPDATE registered_users SET address = '$address' WHERE username = '$username'";
      	if($city !='')
   			{
			    $query_city = "UPDATE registered_users SET city = ? WHERE username = ?";
	      	$stmt = mysqli_prepare($conn, $query_city);
			mysqli_stmt_bind_param($stmt, "ss", $city, $username);
			mysqli_stmt_execute($stmt);
     		}
        if($occupation !='')
   			{
		        $query_occupation = "UPDATE registered_users SET occupation = ? WHERE username = ?";
	      	$stmt = mysqli_prepare($conn, $query_occupation);
			mysqli_stmt_bind_param($stmt, "ss", $occupation, $username);
			mysqli_stmt_execute($stmt);
     		}
        
       // mysqli_query($conn, $query_address);
       
       	}
       	else
       	{
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

	function random_string($length) {
	    $key = '';
	    $keys = array_merge(range(0, 9), range('a', 'z'));

	    for ($i = 0; $i < $length; $i++) {
	        $key .= $keys[array_rand($keys)];
	    }
	    return $key;
	}
	$random_name = random_string(10);
	$target_dir = "images/";
	$target_file = $target_dir . basename($random_name.".png");
	$original_name = basename($_FILES['image']["name"]);
	$profile_url = basename($random_name.".png");
	$tmp_name = $_FILES["image"]["tmp_name"];
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($original_name,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	
	if(isset($_POST["add_image"])) {
	    $check = getimagesize($_FILES["image"]["tmp_name"]);
	    if($check !== false) {
	        $uploadOk = 1;
	    } else {
	        $uploadOk = 0;
	    }
	}

	if(basename($_FILES["image"]["name"]) != '')
	{
		$pattern = "#^(image/)[^\s\n<]+$#i";
		if(!preg_match($pattern, $check['mime'])){
        array_push($errors, "Only image files are allowed");
	    $uploadOk = 0;
    }
		if((!preg_match("`^[-0-9A-Z_\.]+$`i",$original_name)))
			{
	    array_push($errors, "Special characters aren't allowed in file name");
	    $uploadOk = 0;
	}
	// Check file size
	if ($_FILES["image"]["size"] > 500000) {
	    array_push($errors, "Sorry, your file is too large.");
	    $uploadOk = 0;
	}
	// Allow certain file formats
	/* Valid Extensions */
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
	    array_push($errors, "Sorry, only JPG, JPEG, PNG files are allowed.");
	    $uploadOk = 0;
	}
		
// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    array_push($errors, "Sorry, your file is not uploaded.");
	// if everything is ok, try to upload file
	} else {

		 if (move_uploaded_file($tmp_name, $target_file)) {
	        array_push($success, "Your profile picture was successfully updated.");
	         $query_profile_url = "UPDATE registered_users SET profile_url = ? WHERE username = ?";
	      	 $stmt = mysqli_prepare($conn, $query_profile_url);
			mysqli_stmt_bind_param($stmt, "ss", $profile_url, $username);
			mysqli_stmt_execute($stmt);
	       }
	       else {
	        array_push($errors, "Sorry, there was an error uploading your file.");
	    }
	}
		}
	}

if (isset($_POST['delete-user-btn'])) {
	deleteUser();
}

// LOGIN USER
function deleteUser(){
global $conn, $username, $errors, $success, $password;
	$username = $_SESSION['user']['username'];
	$user_to_delete = strtolower(e($_POST['user_to_delete']));
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
   					$query_delete = "DELETE FROM registered_users WHERE username = ?";
   					$stmt = mysqli_prepare($conn, $query_delete);
					mysqli_stmt_bind_param($stmt, "s", $user_to_delete);
					mysqli_stmt_execute($stmt);
   				}
   							
   					
}

if (isset($_POST['add_comment'])) 
{
	addComment();
}

function addComment()
{
	global $conn, $username, $errors, $success, $ip_address, $user_os, $user_browser;
	$username = $_SESSION['user']['username'];
	$error = '';
	$comment_content = e($_POST["comment_content"]);
	date_default_timezone_set("Europe/Dublin");
	$date_time = date("Y-m-d h:i:sa");
			

	if(empty($_POST["comment_content"]))
		{
			array_push($errors, "Comment is required");
		}
	if (strlen($comment_content) > 80)
	{
		array_push($errors, "Only 80 characters are allowed");
	}
if(count($errors) == 0)
{
	if($comment_content != '')
		{
			if(preg_match("/^[a-zA-Z0-9 ]+$/", $comment_content))
				{
					$parent_comment_id = 0;
					$query = "INSERT INTO tbl_comment (parent_comment_id, comment, comment_sender_name, ip_address, user_os, user_browser, date) VALUES (?,?,?,?,?,?,?)";
	 				$stmt = mysqli_prepare($conn, $query);
					mysqli_stmt_bind_param($stmt, "sssssss", $parent_comment_id, $comment_content, $username, $ip_address, $user_os, $user_browser, $date_time);
					mysqli_stmt_execute($stmt);
	 
	 				array_push($success, "Comment was added");
	 				header('Location: index.php');
				}
			else{
					array_push($errors, "Special characters are not allowed");
				}
		}
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
	global $conn, $username, $ip_address, $user_os, $user_browser;
	date_default_timezone_set("Europe/Dublin");
	$date_time = date("Y-m-d h:i:sa");
	$username = $_SESSION['user']['username'];
	if($username == '')
	{
		$username = "UNKNOWN";
	}
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		if($username != ' ')
		{


		$query_insert = "INSERT INTO tried_to_access_admin_page (username, date_time, ip_address, user_os, user_browser) VALUES(?, ?, ?, ?, ?)";
					  
			$stmt = mysqli_prepare($conn, $query_insert);
					mysqli_stmt_bind_param($stmt, "sssss", $username, $date_time, $ip_address, $user_os, 
						$user_browser);
					mysqli_stmt_ewxecute($stmt);
		}else {
			
				$query_insert = "INSERT INTO tried_to_access_admin_page (username, date_time, ip_address, user_os, user_browser) VALUES(?, ?, ?, ?, ?)";
					  
			$stmt = mysqli_prepare($conn, $query_insert);
					mysqli_stmt_bind_param($stmt, "sssss", $username, $date_time, $ip_address, $user_os, 
						$user_browser);
					mysqli_stmt_execute($stmt);
			
		}
		return false;
	}
}


?>
