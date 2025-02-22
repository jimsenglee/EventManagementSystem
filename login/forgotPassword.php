<?php
include_once 'configuration.php';

if(isset($_POST['reset']))
{
  $email = $_POST['email'];
  $check_email = mysqli_query($con,"select email from user_form where email='$email'");
  $res = mysqli_num_rows($check_email);
  if($res>0)
  {
    $message = '<div>
     <p><b>Hello!</b></p>
     <p>You are recieving this email because we recieved a password reset request for your account.</p>
     <br>
     <p><button class="btn btn-primary"><a href="http://localhost/PhpProject3/login/resetPassword.php?secret=<?php echo base64_encode($email); ?>&email=<?php echo $email; ?>">Reset Password</a></button></p>
     <br>
     <p>If you did not request a password reset,please ignore this message.</p>
    </div>';

include_once("../includes/class.phpmailer.php");
include_once("../includes/class.smtp.php");
$email = $email; 
$mail = new PHPMailer;
$mail->IsSMTP();
$mail->SMTPAuth = true;                 
$mail->SMTPSecure = "tls";      
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587; 
$mail->Username = "souwfhj@gmail.com";
$mail->Password = "hblmtugbzpihdkot";
$mail->FromName = "SPS Sports Society";
$mail->addAddress($email);
$mail->Subject = "Reset Your Password";
$mail->isHTML( TRUE );
$mail->Body =$message;
if($mail->send())
{   
  header("Location: forgotPassword.php?success=We have sent you an <br/> email reset link in your gmail!");

}
}
else
{
  header("Location: forgotPassword.php?error=We Unable to find that user <br/> with the given email address.");

}
}

?>

<!DOCTYPE html>

<html>  
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="login.css" />
    <script src="activeNavbar.js">
    </script>    
    <title>Forgot Password</title>
  </head>

  
    <body>
            <?php include '../header&footer/userHeader.php' ?>

      
      <div class="form-container">

   <form method="post">
        <?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>

     	<?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
            
      <h3>Password Reset</h3>
      
      <input type="email" name="email" required placeholder="Enter your email" >
                      
      
        

      <input type="submit" name="reset" value="Sent" class="form-btn">

   </form>
          
          
</div>
      
            <?php include '../header&footer/footer.php' ?>
        
            <link href="../css/login.css" rel="stylesheet" type="text/css"/>
  </body>
  
  
</html>