<?php include '../database_connection.php'; ?>
<?php include'../functions.php'; ?>
<?php $user_type = $_SESSION['user']['user_type'];


if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}else{
 if ($user_type != 'admin') {
	$_SESSION['msg'] = "You are not an admin";
	header('location: ../index.php');
}} ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL - Create user</title>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="login.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<style>
		input{
			border-color: grey !important;
		}
		.header {
			background: #d49328;
			height:50px;
			text-align: center;
			vertical-align: center;
			margin-top: 0;

		}
		button[name=register_btn] {
			background: #d49328;
		}
		input, select{
			text-align: center;
			height:30px;
			margin-top: 1%;
			border-radius: 25px;
  			background: white;

		}
	</style>
</head>
<body>
	<div class="container">
	<div class="header">
		<h2>Admin - Create User</h2>
	</div>
	
	<form class="" method="post" action="create_user.php" style = "text-align: center; margin-top: 10%;">

		<?php echo display_error(); ?>

		<div class="form-group row">
			<div class="col-sm-4"></div>
			<input class="col-sm-4" type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" >
		</div>
		
		<div class="form-group row">
			<div class="col-sm-4"></div>
			<input class="col-sm-4" type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
		</div>

		<div class="form-group row">
			<div class="col-sm-4"></div>
			
			<select class="col-sm-4" name="user_type" id="user_type" >
				<!--<option value="" disabled selected>Select your option</option> -->
				<option value="admin">Admin</option>
				<option value="user">User</option>
			</select>
		</div>
		<div class="form-group row">
			<div class="col-sm-4"></div>
			
			<input class="col-sm-4" type="password" name="password_1" placeholder="Password">
		</div>
		<div class="form-group row">
			<div class="col-sm-4"></div>
			
			<input class="col-sm-4" type="password" name="password_2" placeholder="Confirm Password">
		</div>
		<div class="form-group">
			<button type="submit" class="btn" name="register_btn" style="margin-top: 2%"> + Create user</button>
		</div>
	</form>
	</div>
</body>
</html>