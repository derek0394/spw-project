
<?php
error_reporting(0);
ini_set('display_errors', 0);

$connect = mysqli_connect("localhost", "root", "", "application");
$output = '';
if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($connect, $_POST["query"]);
 $query = "
  SELECT * FROM registered_users 
  WHERE username LIKE '".$search."%'
 ";
}

$result = mysqli_query($connect, $query);
if(mysqli_num_rows($result) > 0)
{
 $output .= '
  <div class="table-responsive">
   <table class="table table bordered">
    <tr>
    
    </tr>
 ';
 while($row = mysqli_fetch_array($result))
 {
  $output .= '
   <tr>
    <td>'.$row["username"].'</td>
  <tr>
  ';
 }
 echo $output;
}
else
{

}
?>