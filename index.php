<?php 

 
include 'database_connection.php';
	include 'functions.php';
	
	
if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
$user_type = $_SESSION['user']['user_type'];

$_COOKIE['username'] = $_SESSION['user']['username'];
$_COOKIE['user_type'] = $_SESSION['user']['user_type'];

 setcookie($_COOKIE['username'],$_COOKIE['user_type'], time()+ 60,'/'); // expires after 60 seconds
  /*  echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
     print_r($_COOKIE);
    echo serialize($_COOKIE);*/




?>

<!DOCTYPE>
<html>
<head>
	<title>Home</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src = "script.js"></script>
<style>
	.navbar-default .navbar-nav>.active>a, .navbar-default .navbar-nav>.active>a:focus, .navbar-default .navbar-nav>.active>a:hover {
    
    background-color: #d08722 !important;

}    
.navbar-default {
    background-color: #d49328;
   
}
.btn-info {
   
    background-color: #d08722 !important;
    border-color: #d08722 !important;
    }
h4{
	color:white;
}
.card {
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  width: 80%;
  background-color: black;
  border-radius: 4px;
  padding-top: 4px;
  padding-bottom: 4px;
  text-align: center;
  color: white;
}

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}


#container{
	width: 275px;
	height: 90px;
	overflow: hidden;
	background-color: black;
	border: 1px solid #000;
	border-radius: 5px;
	color: #fefdfb;
	margin-bottom: 2%;
}
#lastPrice{
	font-size: 24px;
	font-weight: bold;
}
#dateTime{
	font-size: 9px;
	color: #999;
}
img {
  width:50px;
  height:100px;
  object-fit:cover;
}
#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 12px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}
#profile-details{
		color:black;
	}

	table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
 
    border: 1px solid #d08722;
    background: white;
    color: 1px solid #ff8d00a1;
}
.panel-default>.panel-heading {
    color: white;
    background-color: #d08722;
    border-color: #ddd;
    
</style>
</head>

<body>
	
<div class="navbar navbar-default" role="navigation">
      <div class="container">
      
   <div class="topmenu">
          <ul class="nav navbar-nav navbar">
          	 <li><a  href="index.php"><h4>FZone</h4></a></li>
            
            
            <li><a  href="user-profile.php"><h4>Profile</h4></a></li>
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
   $username = $_SESSION['user']['username'];

$query_profile_url = "SELECT profile_url FROM registered_users WHERE username = '$username'";
			//echo $query_failed_attempts;
					$result1 = mysqli_query($conn, $query_profile_url);
					if ($result1->num_rows > 0) {
   						while($row = $result1->fetch_assoc()) {
   							$profile_url = $row['profile_url'];
   						
   							
   						}} 
   						
   					
   						
?>

<div class="container">
  
   	<h4 id = "profile-details"><b>
   <?php echo $_SESSION['user']['username']; ?>
</b></h4><br>
<div class="col-sm-12" >
<div class="form-group col-sm-4">
  <img src='images/<?php echo "$profile_url"; ?> '>
    </div>
    <div class="form-group col-sm-4">
   
    </div>
    <div class="form-group col-sm-4"  style="position: absolute; margin-left: 60%;">
    
    
 <!--   <div class="input-group">
     <span class="input-group-addon">Search</span>
     <input type="text" name="search_text" id="search_text" placeholder="Search Friends" class="form-control" />
    </div> -->
   
  
   <div id="result"></div>

  </div>
</div>
   
     <form method="POST" id="comment_form">
    <div class="form-group">
     <textarea name="comment_content" id="comment_content" class="form-control" value = '' placeholder="World chat (max 50 words)" rows="5"></textarea>
    </div>
   
    <div class="form-group">
     <input type="hidden" name="comment_id" id="comment_id" value="0" />
     <input type="submit" name="add_comment" id="submit" class="btn btn-info" value="Submit" />
    </div>
   </form>

      	 <?php echo display_error(); ?>
   	 <?php echo display_success(); ?>
   	   <div class="form-group">
     <p>Messages will be deleted in 10 minutes</p>
    </div>
   <span id="comment_message"></span>
   <br />
   <div id="display_comment"></div>
  </div>
	
</body>
</html>

<script>
$(document).ready(function(){
 
 $('#comment_form').on('add_comment', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url:"functions.php",
   method:"POST",
   data:form_data,
   dataType:"JSON",
   success:function(data)
   {
    if(data.error != '')
    {
     $('#comment_form')[0].reset();
     $('#comment_message').html(data.error);
     $('#comment_id').val('0');
     load_comment();
    }
   }
  })
 });

 load_comment();

 function load_comment()
 {
  $.ajax({
   url:"fetch_comment.php",
   method:"POST",
   success:function(data)
   {
    $('#display_comment').html(data);
   }
  })
 }

 $(document).on('click', '.reply', function(){
  var comment_id = $(this).attr("id");
  $('#comment_id').val(comment_id);
  $('#comment_name').focus();
 });
 
});

//search 
/*$(document).ready(function(){

 load_data();

 function load_data(query)
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{query:query},
   success:function(data)
   {
    $('#result').html(data);
   }
  });
 }
 $('#search_text').keyup(function(){
  var search = $(this).val();
  if(search != '')
  {
   load_data(search);
  }
  else
  {
   load_data();
  }
 });
}); */
</script> 
