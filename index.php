<?php 
include 'database_connection.php';
	include 'functions.php';
	
if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
   <link rel="stylesheet" href="/static/header.css">
    <link rel="stylesheet" href="/static/slider.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/product/"><h4>Management System</h4></a>
        </div>
                <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar">
            <li><a href="/product/appointment"><h4>Appointments</h4></a></li>
            <li><a href=""><h4>Health</h4></a></li>
            <li><a href="/product/user-profile"><h4>Profile</h4></a></li>
          </ul>


          <ul class="nav navbar-nav navbar-right">
            
            <li><a href="index.php?logout='1'"><h4>Logout</h4></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <br>
    <br><br>
	<div class="header">
		<h2>Home Page</h2>
	</div>
	<div class="content">
		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>
		<!-- logged in user information -->
		<div class="profile_info">
			<img src="images/user_profile.png"  >

			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
						<br>
						<a href="index.php?logout='1'" style="color: red;">logout</a>
					</small>

				<?php endif ?>
			</div>
		</div>
		<form method = "post" action = "index.php">
			<input type = "text" name = "email">
			<input type = "text" name = "password">
			<input type = "submit" name = "submit" value = "submit">

		</form>
		
	</div>
	
</body>
</html>
