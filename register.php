<?php include 'database_connection.php'; ?>
<?php include 'functions.php';

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
    <form method = "post", action="register.php" style = "margin-top: 5%;">
      <?php echo display_error(); ?>
      <input type="text" id="login" class="fadeIn second" name="username" placeholder="Username" value="<?php echo $username; ?>">
      <input type="text" id="email" class="fadeIn third" name="email" placeholder="Email" value="<?php echo $email; ?>">

      <!--<input type="text" id="number" class="fadeIn third" name="number" placeholder="Number">-->
      <input type="password" id="password" class="fadeIn third" name="password_1" placeholder="Password">
      <input type="password" id="password" class="fadeIn third" name="password_2" placeholder="Re-type password">
      
    <input type="submit" class="fadeIn fourth" name="register_btn">
  
      
    </form>
     
     <p>
    Already a member? <a href="login.php">Sign in</a>
  </p>
  
    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="#">Forgot Password?</a>
    </div>

  </div>
</div>
<?php echo $date_time; ?>