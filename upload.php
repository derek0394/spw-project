
<div class="form-group col-sm-12">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<div style="float: left; font-size:222px;"><h5 style="font-size:20px;">Upload Profile Picture</h5></div> <br> <br>
				<label>Select Image</label>
				<input type="file" name="file" id="file" />
   <br />
   <span id="uploaded_image"></span>
   <span id="error"></span>
   
   
  </div>
</div>
<script>
$(document).ready(function(){
 $(document).on('change', '#file', function(){
  var name = document.getElementById("file").files[0].name;
  var form_data = new FormData();
  var ext = name.split('.').pop().toLowerCase();
  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
  {
   alert("Invalid Image File");
  }
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("file").files[0]);
  var f = document.getElementById("file").files[0];
  var fsize = f.size||f.fileSize;
  if(fsize > 2000000)
  {
   alert("Image File Size is very big");
  }
  else
  {
   form_data.append("file", document.getElementById('file').files[0]);
   $.ajax({
    url:"upload.php",
    method:"POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
     $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
    },   
    success:function(data)
    {
     $('#uploaded_image').html("<label class='text-success'>Image has been successfully uploaded</label>");
    
    },
    error:function(data)
    {
    	  $('#error').html("<label class='text-success'>Only jpeg,png images are allowed</label>");
    }
  
   });
  }
 });
});
</script>
<?php

//upload.php
$username = $_SESSION['user']['username']; 
$target_dir = "images/";
$target_file = $target_dir . basename($username."profile_picture.PNG");
$original_name = basename($_FILES['name']["tmp_name"]);
$profile_url = basename($username."profile_picture.PNG");
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($original_name,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["add"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        //array_push($errors, "File is not an image.");
        $uploadOk = 0;
    }
}

if(basename($_FILES["image"]["name"]) != '')
{
	if ($_FILES["image"]["size"] > 500000) {
    array_push($errors, "Sorry, your file is too large.");
    $uploadOk = 0;
}

$valid_extensions = array("jpg","jpeg","png");
/* Check file extension */
if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
	array_push($errors, "Only jpg, png, jpeg images are allowed");
   $uploadOk = 0;
}



if ($uploadOk == 0) {
    array_push($errors, "Sorry, your file is not uploaded.");
// if everything is ok, try to upload file
} else {

	 if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        array_push($success, "Your profile picture was successfully updated.");
         $query_profile_url = "UPDATE registered_users SET profile_url = '$profile_url' WHERE username = '$username'";
      	 mysqli_query($conn, $query_profile_url);
       }
       else {
        array_push($errors, "Sorry, there was an error uploading your file.");
    }
}
}

if($_FILES["file"]["name"] != '')
{
 $test = explode('.', $_FILES["file"]["name"]);
 $ext = end($test);
 $name = rand(100, 999) . '.' . $ext;
 $location = './images/' . $name;  
 move_uploaded_file($_FILES["file"]["tmp_name"], $location);
 echo '<img src="'.$location.'" height="150" width="225" class="img-thumbnail" />';
} 

?>