<?php include '../database_connection.php'; ?>
<?php include'../functions.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL - Create user</title>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="login.css">
<link rel="stylesheet" type="text/css" href="/Web1/css/style.css">
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
		button[name=delete-user-btn] {
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
		<h2>Admin - Remove User</h2>
	</div>
	<?php
		$query_username = "SELECT username FROM registered_users";
					$result = mysqli_query($conn, $query_username);
					if ($result->num_rows > 0) {
   						while($row = $result->fetch_assoc()) {
   							$username_select[] = $row['username'];
   							
   							
   						}
   					}
   					?>
	<form class="" method="post" action="delete-user.php" style = "text-align: center; margin-top: 10%;">

		<?php echo display_error(); ?>
		<?php echo display_success(); ?>

		<div class="form-group row">
			<div class="col-sm-4"></div>
		
		<select class="col-sm-4" name="user_to_delete">
			<?php for($i=0; $i< count($username_select); $i++)
			{
				?>
				<option value=<?php print($username_select[$i]); ?> ><?php print($username_select[$i]); ?></option>
				<?php } ?>
			</select>

		</div>
		<div class="form-group row">
			<div class="col-sm-4"></div>
			
			<input class="col-sm-4" type="password" name="password" placeholder="Admin Password">
		</div>
		
		<div class="form-group">
			<button type="submit" class="btn" name="delete-user-btn" style="margin-top: 2%"> x Delete user</button>
		</div>
	</form>
	</div>
</body>
</html>