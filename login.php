
<?php 
include 'database_connection.php';
include 'functions.php'; 
if (isLoggedIn()) {
  $_SESSION['msg'] = "already logged in";
  header('location: index.php');
}
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="login.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
    <!--  <img src="http://danielzawadzki.com/codepen/01/icon.svg" id="icon" alt="User Icon" />-->
    </div> 

    <!-- Login Form -->
    <form method = "post" action="login.php" style = "margin-top: 5%;">
      <?php echo display_error(); ?>
      <input type="text" id="username" class="fadeIn second" name="username" placeholder="Username">
      <input type="text" id="password" class="fadeIn third" name="password" placeholder="Password">
     
      <input type="submit" class="fadeIn fourth" name="login_btn">
   
    <p>
      Not yet a member? <a href="register.php">Sign up</a>
    </p>
    </form>
     
      <a class="underlineHover" href="register.php">Register</a>
  
    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="#">Forgot Password?</a>
    </div>

  </div>
</div>
