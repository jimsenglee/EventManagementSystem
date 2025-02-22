<?php

include 'configuration.php';

if(isset($_POST['submit'])){

   $username = mysqli_real_escape_string($con, $_POST['user_name']);
   $fname = mysqli_real_escape_string($con, $_POST['fname']);
   $lname = mysqli_real_escape_string($con, $_POST['lname']);
   $email = mysqli_real_escape_string($con, $_POST['email']);
   $phone = mysqli_real_escape_string($con, $_POST['phone']);

   $pass = $_POST['password'];
   $cpass = $_POST['cpassword'];
   $user_type = $_POST['user_type'];
   
   
   $error = array();
   
   $birth_date = $_POST['birth_date']; 

    // calculate the age using the birth date
    $birth_year = date('Y', strtotime($birth_date));
    $current_year = date('Y');
    $age = $current_year - $birth_year; 

    // check User Name requirements   
    if (!preg_match("/^[a-zA-Z]+$/", $username)) {
        $error['uname_char'] = 'User Name can only contain letters';
    }
    
    //check contact number requirement
    if(!preg_match('/^01[0-9]-\d{7,8}$/',$phone)){
        $error['phone']="YOUR <b>PHONE NUMBER</b> is invalid";
    }    
    
    // check First Name requirements   
   if (!preg_match("/^[a-zA-Z ]*$/", $fname)) {
    $error['f_name'] = 'First Name can only contain letters and spaces';
    }
    
    // check First Name requirements   
   if (!preg_match("/^[a-zA-Z ]*$/", $lname)) {
    $error['l_name'] = 'Last Name can only contain letters and spaces';
    }
    
    // check Image requirements   
   if(isset($_FILES['image'])){
      $image = $_FILES['image']['name'];
      $image_size = $_FILES['image']['size'];
      $image_tmp_name = $_FILES['image']['tmp_name'];
      $image_folder = 'uploaded_img/'.$image;

      
         if(empty($image)){
      $error['img_empty'] = 'Please choose an image';
   } elseif($image_size > 1048576 ){
      $error['img_large'] = 'Image size is too large!';
   }
   }
   
    // check birth date requirements
   
   if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $_POST['birth_date'])) {
    $error['invalid_birthdate'] = 'Please enter a valid birth date in the format YYYY-MM-DD';
    }
   
   
    // check password requirements
    if (strlen($pass) < 7) {
        $error['pass_length'] = 'Password must be at least <b>7</b> characters long';
    } 
    else if (!preg_match("/[0-9]+/", $pass)) {
        $error['pass_num'] = 'Password must contain at least one <b>number</b>';
    } 
    else if (!preg_match("/[A-Z]+/", $pass)) {
        $error['pass_upper'] = 'Password must contain at least one <b>capital letter</b>';
    } 
    else if (!preg_match("/[a-z]+/", $pass)) {
        $error['pass_lower'] = 'Password must contain at least one <b>lowercase letter</b>';
    }     
    else if (!preg_match("/\w+/", $pass)) {
        $error['pass_symbol'] = 'Password must contain at least one <b>symbol</b>';
    } 
    else if ($pass !== $cpass) {
        $error['pass_match'] = 'Password and Confirm Password do not match';
    }   
    
    
    

   if(empty($error)){

      $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

      $select = " SELECT * FROM user_form WHERE (email = '$email' OR user_name = '$username') ";

      $result = mysqli_query($con, $select);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                if($row['email'] == $email){
                    $error['email_exist'] = 'Email already exists!';
                }
                if($row['user_name'] == $username){
                    $error['usr_exist'] = 'Username already exists!';
                }
            }
        }
        
      else{
         $insert = "INSERT INTO user_form(user_name, email, password, user_type, image
                 ,age,birth_date,fname,lname,contact_num) VALUES('$username','$email','$pass_hash',
                 '$user_type','$image','$age','$birth_date','$fname','$lname','$phone')";
         
         if(mysqli_query($con, $insert)){
            move_uploaded_file($image_tmp_name, $image_folder);
            $_SESSION['image'] = $image_folder;  
            $error["image_success"] = 'registered successfully!';
            header('location:login.php');
        } else {
            $error['insert_error'] = 'Error while inserting data into database';
        }
    }
   }
   
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>
      <script src="show_password.js" type="text/javascript"></script>

   <link href="login.css" rel="stylesheet" type="text/css"/>

</head>
<body>
    
                <?php include '../header&footer/userHeader.php' ?>

   
<div class="form-container">

    <form action="" method="post" enctype="multipart/form-data">
      <h3>register now</h3>
      <?php
      if(isset($error)){
         foreach($error as $msg){
            echo '<span class="error-msg">'.$msg.'</span>';
         };
      };
      ?>

      <input type="text" name="user_name" required placeholder="Enter your username"
            value="<?php
                    echo (isset($username))?$username: "";
                    ?>">      
      
      <input type="text" name="fname" required placeholder="Enter your first name"
             value="<?php
                    echo (isset($fname))?$fname: "";
                    ?>">
      
      <input type="text" name="lname" required placeholder="Enter your last name"
             value="<?php
                    echo (isset($lname))?$lname: "";
                    ?>">
      <br/>
      <span class="txt2">Please Enter Your Birth Date</span>
          <input type="date" id="birth_date" name="birth_date" min="1900-01-01" 
             max="<?php echo date('Y-m-d'); ?>" placeholder="Enter your birth date" 
             value="<?php
                    echo (isset($birth_date))?$birth_date: "";
                    ?>">
      
      <input type="text" name="phone" required placeholder="Enter your Contact Number (01x-xxxxxxx)"
             value="<?php
                    echo (isset($phone))?$phone: "";
                    ?>">
      
      <input type="email" name="email" required placeholder="Enter your email" onkeydown="return avoidSpace(event)"
             value="<?php
                    echo (isset($email))?$email: "";
                    ?>">
      
         <div class="password-container">
             <input type="password" name="password" id="passShow" 
                    required placeholder="Enter your password" 
                    onkeydown="return avoidSpace(event)" value="<?php
                      echo (isset($pass))?$pass: "";
                      ?>">

          </div>

         <div class="password-container">
             <input type="password" name="cpassword" id="cPassShow" 
                    required placeholder="Enter your password again" 
                    onkeydown="return avoidSpace(event)" value="<?php
                      echo (isset($cpass))?$cpass: "";
                      ?>">  
             <div class   ="pass">
                <input type="checkbox" onclick="passwordToggle()">
                <span class="passTxt">Show Password</span>
             </div>
          </div>
      
      
      <br/>
      <span class="txt">Please Choose Your Profile Picture</span>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png"
             value="<?php
                    echo (isset($image))?$image: "";
                    ?>">      
      
      <select name="user_type">
         <option value="admin">admin</option>
         <option value="user">user</option>
      </select>
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>Already have an account?<a href="login.php"> Log in instead!</a></p>
      
      
   </form>
    

</div>
<script>
function avoidSpace(event) {
  if (event.keyCode === 32) {
    event.preventDefault();
    return false;
  }
}
</script>

            <?php include '../header&footer/footer.php' ?>

</body>
</html>


