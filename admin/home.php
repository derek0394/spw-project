<?php 
include '../database_connection.php';
include '../functions.php';

if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}


if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: ../login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<style>
		h2{
			text-align: center;
		}
	.header {
		background: #d08722;
	}
	button[name=register_btn] {
		background: #003366;
	}
	</style>
</head>
<body>
	<div class="header">
		<h2>Admin Dashboard</h2>
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
			
		<div class="container">
			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<h4><strong><?php echo strtoupper($_SESSION['user']['username']); ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
						<br>
						<a href="home.php?logout='1'" style="color: red;">logout</a>
                       &nbsp; <a href="create_user.php"> + ADD NEW USER/ADMIN</a>
                       &nbsp; <a href="delete-user.php"> x DELETE USER</a>
					</small></h4>

				<?php endif ?>
			</div>
		</div>
			<div class="container">
				<h4>Users tried to access admin page (Recent)</h4>
				<table class="table">
				    <thead>
				       <tr>
				        <th>USERNAME</th>
				        <th>DATE & TIME</th>
				        <th>IP ADDRESS</th>
				       </tr>
				    	<?php
				    	
				    	$query_details = "SELECT * FROM tried_to_access_admin_page ORDER BY id DESC";
						$result = mysqli_query($conn, $query_details);
						if ($result->num_rows > 0) 
						{
							while($row = $result->fetch_assoc()) 
							{
								$date_time_from_DB[] = $row['date_time'];
								$username_from_DB[] = $row['username'];
								$ip_address_from_DB[] = $row['ip_address'];			
							}
						}

				    	 for($i=0; $i<sizeof($username_from_DB); $i++)
				    	{ ?>
 					   <tr>
				        <td><?php echo $username_from_DB[$i]; ?></td>
				        <td><?php echo $date_time_from_DB[$i]; ?></td>
				        <td><?php echo $ip_address_from_DB[$i]; ?></td>
				      </tr>
				        <?php
				     
				    	} ?>
				     
				    </thead>
				    <tbody>
				     
				    </tbody>
				 </table>
			</div>

			<div class="container">
				<h4>Wrong User Logins (Recent)</h4>
				<table class="table">
				    <thead>
				       <tr>
				        <th>USERNAME</th>
				        <th>DATE & TIME</th>
				        <th>IP ADDRESS</th>
				       </tr>
				    	<?php
				    	$query_details = "SELECT * FROM wrong_user_logs ORDER BY id DESC";
						$result = mysqli_query($conn, $query_details);
						if ($result->num_rows > 0) 
						{
							while($row = $result->fetch_assoc()) 
							{
								$date_time_from_DB1[] = $row['date_time'];
								$username_from_DB1[] = $row['username'];
								$ip_address_from_DB1[] = $row['ip_address'];			
							}
						}

				    	 for($i=0; $i<sizeof($username_from_DB); $i++)
				    	{ ?>
 					   <tr>
				        <td><?php echo $username_from_DB1[$i]; ?></td>
				        <td><?php echo $date_time_from_DB1[$i]; ?></td>
				        <td><?php echo $ip_address_from_DB1[$i]; ?></td>
				      </tr>
				        <?php
				     
				    	} ?>
				     
				    </thead>
				    <tbody>
				     
				    </tbody>
				 </table>
			</div>
		</div>
	</div>
</body>
</html>