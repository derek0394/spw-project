
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

<style type="text/css">
 .g-recaptcha {
    background-color: #f6f6f6;
    border: none;
    color: #0d0d0d;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 5px;
    width: 85%;
    border: 2px solid #f6f6f6;
    -webkit-transition: all 0.5s ease-in-out;
    -moz-transition: all 0.5s ease-in-out;
    -ms-transition: all 0.5s ease-in-out;
    -o-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out;
    -webkit-border-radius: 5px 5px 5px 5px;
    border-radius: 5px 5px 5px 5px;
}
</style>
<!------ Include the above in your HEAD tag ---------->

<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
    <!--  <img src="http://danielzawadzki.com/codepen/01/icon.svg" id="icon" alt="User Icon" />-->
    </div> 

    <!-- Login Form -->
     <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <form method = "post" action="login.php" style = "margin-top: 5%;">
      <?php echo display_error(); ?>
      <input type="text" id="username" class="fadeIn second" name="username" placeholder="Username">
      <input type="text" id="password" class="fadeIn third" name="password" placeholder="Password">
    
      <input type="submit" class="fadeIn fourth" name="login_btn" value="submit">
       <div class="g-recaptcha" data-sitekey="6LeHrOsUAAAAAHySsqTa4vjW82EvwOTHVLF_x5BR"></div>
        <title>reCAPTCHA demo: Explicit render after an onload callback</title>
    <script type="text/javascript">
      var onloadCallback = function() {
        grecaptcha.render('html_element', {
          'sitekey' : '6LeHrOsUAAAAAHySsqTa4vjW82EvwOTHVLF_x5BR'
        });
      };
    </script>
 
   
    
    </form>

   
     <p>
      Not yet a member? 
    </p>
      <a class="underlineHover" href="register.php">Sign up</a>
  
    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="#">Forgot Password?</a>
    </div>

  </div>
</div>

     
  

