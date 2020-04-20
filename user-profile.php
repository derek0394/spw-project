   
<?php 

    
include 'database_connection.php';
include 'functions.php';
if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
$username = $_SESSION['user']['username'];
$user_type = $_SESSION['user']['user_type'];

?>
<html>
<head>
<title>My BTC Widget</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src = "script.js"></script>


<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Isolated Version of Bootstrap, not needed if your site already uses Bootstrap -->
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

<!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<style>
	<style>

	/* Container */
.container{
   margin: 0 auto;
   border: 0px solid black;
   width: 50%;
   height: 250px;
   border-radius: 3px;
   background-color: ghostwhite;
   text-align: center;
}
.navbar-default {
    background-color: #d49328;
    border-color: #e7e7e7;
}
.navbar-default .navbar-nav>.active>a, .navbar-default .navbar-nav>.active>a:focus, .navbar-default .navbar-nav>.active>a:hover {
   
    background-color: #d08722 !important;
}
h4{
	color:white;
}
/* Preview */
.preview{
   width: 100px;
   height: 100px;
   border: 1px solid black;
   margin: 0 auto;
   background: white;
}

.preview img{
   display: none;
}
/* Button */
.button{
   border: 0px;
   background-color: deepskyblue;
   color: white;
   padding: 5px 15px;
   margin-left: 10px;
}

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
			height:50px;
			margin-top: 1%;
			border-radius: 7px;
  			background: white;
  			border-color: grey;

		}
	#submit{
		background-color:#d08722 !important;
		color:white;
	}
	#profile-details{
		color:black;
	}
	</style>
</style>
</head>

<body>
<div class="navbar navbar-default" role="navigation">
      <div class="container">
      
   <div class="topmenu">
          <ul class="nav navbar-nav navbar">
          	 <li><a class="navbar-brand" href="index.php"><h4>FZone</h4></a></li>
            
            
            <li><a class = "current" href="user-profile.php"><h4>Profile</h4></a></li>

              <?php if($user_type == 'admin')
          { ?>
             <li><a  href="admin/home.php" ><h4>Admin Dashboard</h4></a></li>
         <?php } ?>
          </ul>


          <ul class="nav navbar-nav navbar-right">
            
            <li><a href="index.php?logout='1'"><h4>Logout</h4></a></li>
          </ul>
       </div>
      </div>
    </div>
<?php

$query_failed_attempts = "SELECT dob,city,occupation FROM registered_users WHERE username = '$username'";
			//echo $query_failed_attempts;
					$result1 = mysqli_query($conn, $query_failed_attempts);
					if ($result1->num_rows > 0) {
   						while($row = $result1->fetch_assoc()) {
   							$dob = $row['dob'];
   							$city = $row['city'];
   							$occupation = $row['occupation'];
   							
   						}} 
   						
?>
<div class = "container col-sm-12">
  <div class = "col-sm-6">
  	<div class="form-group col-sm-12">
  		<div class = "col-sm-6">
        <h4><b>
   <a href="password_reset.php">Reset Password</a>
</b></h4>
    		 <h3>Your Personal Info</h3>
    	</div>
 	</div>
  
  <?php
  	if($dob != '')
 	{
 	echo "<div class='form-group col-sm-12'>
  		<div class = 'col-sm-6'>
    		 <h4 id = 'profile-details'>  Date Of Birth - $dob</h4>
    	</div>
 	</div>"; } 
 	 if($city != '')
 	{
 	echo "<div class='form-group col-sm-12'>
  		<div class = 'col-sm-6'>
    		 <h4 id = 'profile-details'>  City - $city</h4>
    	</div>
 	</div>"; } 
 	 if($occupation != '')
 	{
 	echo "<div class='form-group col-sm-12'>
  		<div class = 'col-sm-6'>
    		 <h4 id = 'profile-details'>  Occupation - $occupation</h4>
    	</div>
 	</div>"; } ?>
</div>


<div class = "col-sm-6">
   <form id="myform" method="post" action="user-profile.php" enctype="multipart/form-data" style = "text-align: center; margin-top: 2%;" >
   	<h4 id ="profile-details">Update Profile Details</h4>
   	 <?php echo display_error(); ?>
   	 <?php echo display_success(); ?>
		<div class="form-group col-sm-12">
			<div class="col-sm-3"></div>
			<input class="col-sm-6" type="text" id="date" name="dob" placeholder="DOB" value="">
       
      </div>
		


		<!--<div class="form-group col-sm-12">
			<div class="col-sm-3"></div>
			<input class="col-sm-6" type="text" name="address" placeholder="Address" value="<?php echo $address; ?>" >
		</div> -->
		
		<div class="form-group col-sm-12">
			<div class="col-sm-3"></div>
			<input class="col-sm-6" type="text" name="city" placeholder="City" value="">
		</div>

		<div class="form-group col-sm-12">
			<div class="col-sm-3"></div>
			
			<input class="col-sm-6" type="text" name="occupation" placeholder="Occupation" value="">
		</div>
	
   
  
<div class="form-group">
			<button type="submit" id = "submit" class="btn" name="add" style="margin-top: 2%"> Submit</button>
		</div>
	</form>

	<form method="post" action="user-profile.php" enctype="multipart/form-data" style = "text-align: center; margin-top: 2%;" >

		
		<div class="form-group col-sm-12">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<div style="float: left; font-size:222px;"><h5 style="font-size:20px;">Upload Profile Picture</h5>
				</div> 
				<input  type="file" name="image" id="image" >	
		</div>
	</div> 

	<div class="form-group">
			<button type="submit" id = "submit" class="btn" name="add_image"> Add Profile Picture</button>
		</div>
</form>
	 
 </body>
</html>



	
		
	 </div>
	</div>
</body>
</html>



<script>
    $(document).ready(function(){
      var date_input=$('input[name="dob"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
</script>

