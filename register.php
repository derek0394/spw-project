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
<style type="text/css">

</style>
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
    <!--  <img src="http://danielzawadzki.com/codepen/01/icon.svg" id="icon" alt="User Icon" />-->
    </div> 

    <!-- Login Form -->
     <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <form method = "post", action="register.php"  autocomplete="off" style = "margin-top: 5%;">
      <?php echo display_error(); ?>

      <input type="text" id="login" class="fadeIn second" name="username" placeholder="Username" value="<?php echo $username; ?>">
      <input type="text" id="email" class="fadeIn third" name="email" placeholder="Email" value="<?php echo $email; ?>">

      <!--<input type="text" id="number" class="fadeIn third" name="number" placeholder="Number">-->
      <input type="password" id="password" class="fadeIn third" name="password_1" placeholder="Password">
      
      <progress value="0" max="100" id = "strength" style="width: 230px;"></progress>
      <input type="password" id="password" class="fadeIn third" name="password_2" placeholder="Re-type password">
      
    <input type="submit" class="fadeIn fourth" name="register_btn" value = "Sign Up">
   <div class="g-recaptcha" data-sitekey="6LeHrOsUAAAAAHySsqTa4vjW82EvwOTHVLF_x5BR"></div>
        
      
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
<script>

var pass = document.getElementById("password")
pass.addEventListener('keyup', function(){
  checkPassword(pass.value)
})

function checkPassword(password)
{
  var strengthBar = document.getElementById("strength")
  var strength =0;
  if (password.match(/ /))
  {
    strength += 0
  }
  if (password.match(/[a-zA-Z0-9][a-zA-Z0-9][a-zA-Z0-9][a-zA-Z0-9][a-zA-Z0-9]+/))
  {
    strength += 1
  }

  if (password.match(/[~<>?]+/))
  {
    strength += 1
  }

  if (password.match(/[!@$#&%*()]+/))
  {
    strength += 1
  }
    if (password.length > 9)
  {
    strength += 1
  }

  switch(strength)
  {
    case 0:
        strengthBar.value = 0;
        break
    case 1:
        strengthBar.value = 20;
        break
    case 2:
        strengthBar.value = 40;
        break
    case 3:
        strengthBar.value = 60;
        break
    case 4:
        strengthBar.value = 80;
        break
    case 5:
        strengthBar.value = 100;
        break

  }
}
</script>
