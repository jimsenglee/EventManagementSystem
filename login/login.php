<?php
include 'configuration.php';

session_start();


if(isset($_POST['submit'])){

   $username = isset($_POST['user_name']) ? mysqli_real_escape_string($con, $_POST['user_name']) : '';
   $email = isset($_POST['email']) ? mysqli_real_escape_string($con, $_POST['email']) : '';
   $pass = $_POST['password'];
   $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);   

   
   $select = "SELECT * FROM user_form WHERE email = '$email' ";

   $result = mysqli_query($con, $select);
   $row = mysqli_fetch_assoc($result);
   $error = array();


  if ($row && password_verify($pass, $row['password'])) {       //checks whether the user entered the correct email and password 
      
    // Set session and redirect if password is correct
    if ($row['user_type'] == 'admin') {
        $_SESSION['admin_name'] = $row['user_name'];
        $_SESSION['id'] = $row['id'];
                header('location:../homepage/home.php');
    } else if ($row['user_type'] == 'user') {
        $_SESSION['user_name'] = $row['user_name'];
        $_SESSION['id'] = $row['id'];
        header('location:../homepage/home.php');
    }

}

  //limit login times
  $ip = getIpAddr();
  $login_time = time()-30;
  $login_attempts = mysqli_query($con,"select count(*) as total_count from ip_details where ip='$ip' and login_time>'$login_time'");
  $res = mysqli_fetch_assoc($login_attempts);
  
  $count = $res['total_count'];
  if($count==3)
  {
    $error["banned"] = "Your account has been blocked. Please try after 30 seconds.";
  }
  else
  {
  $select_query = mysqli_query($con,"select * from user_form where email='$email' and password='$pass'");
  $res = mysqli_num_rows($select_query);
  if($res>0)
  {
    $delete_query = mysqli_query($con,"delete from ip_details where ip='$ip'");
    $fetch_data = mysqli_fetch_array($select_query);
    $username = $fetch_data['user_name'];
    $_SESSION['user_name'] = $username;
  }
  else
  {
    $count++;
    $remaining_attempts = 3-$count;
    if($remaining_attempts==0)
    {
      $error["banned"]  = "Your account has been blocked. Please try after 30 seconds.";
    }
    else
    {
      $error["detail"] = "Incorrect email or password! <br/> Please enter valid details. $remaining_attempts attempts remaining.";
    }
    $ip = $_SERVER['REMOTE_ADDR'];
    $login_time = time();
    $insert_query = mysqli_query($con,"insert into ip_details set ip='$ip', login_time='$login_time'");
    
  }
}

}
        
    function getIpAddr(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
    $ipAddr=$_SERVER['HTTP_CLIENT_IP'];
    }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $ipAddr=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
        else{
    $ipAddr=$_SERVER['REMOTE_ADDR'];
    }
        return $ipAddr;
    }






?>

<!DOCTYPE html>

<html>  
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
      <script src="show_password.js" type="text/javascript"></script>
<link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="login.css" />
    <script src="activeNavbar.js">
    </script>    
    <title>HomePage</title>
  </head>

  
    <body>
            <?php include '../header&footer/userHeader.php' ?>

      
      <div class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <?php                                     //display the validation message and will disappear after 30 seconds
      if(isset($error)){
         foreach($error as $value){
            echo '<span class="error-msg">'.$value.'</span>';
         };
          echo '<script>
            setTimeout(function() {
            var errorDiv = document.querySelector(".error-msg");
            if (errorDiv) {
                errorDiv.parentNode.removeChild(errorDiv);
            }
            }, 30000);
            </script>';
      };
      ?>
      <input type="email" name="email" required placeholder="Enter your email" 
             value="  <?php
                    echo (isset($email))?$email: "";
                    ?> ">
                      
      
        <div class="password-container">
           <input type="password" name="password" id="passShow" 
                  required placeholder="Enter your password" value="<?php
                    echo (isset($cpass))?$cpass: "";
                    ?>">
           <div class="pass">
              <input type="checkbox" onclick="passwordToggle()">
              <span class="passTxt">Show Password</span>
           </div>
        </div>

      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>New User? <a href="register.php">Register Here</a></p> 
      <p>Forgot Your Password? <a href="forgotPassword.php">Reset Here</a></p>
   </form>
          
          
</div>
      
            <?php include '../header&footer/footer.php' ?>
        
            <link href="../css/login.css" rel="stylesheet" type="text/css"/>
  </body>
  
  
</html>