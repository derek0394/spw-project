<?php include '../database_connection.php'; ?>
<?php include'../functions.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL - Create user</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<style>
		.header {
			background: #d25309;
			height:50px;
			text-align: center;
			vertical-align: center;
			margin-top: 0;

		}
		button[name=register_btn] {
			background: #d25309;
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
		<h2>Admin - create user</h2>
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