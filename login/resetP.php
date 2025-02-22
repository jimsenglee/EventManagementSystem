    <?php

    if(isset($_POST['resetPass'])) {
        $email = $_POST['email'];
        $newpass = $_POST['newPass'];
        $conpass = $_POST['conPass'];

        include 'configuration.php';

       
    
        
        if(empty($newpass)){
          header("Location: resetPassword.php?error=New Password is required!");
              exit();
        }
        else if(strlen($newpass) < 7){
          header("Location: resetPassword.php?error=New Password must be at least 7 characters long!");
              exit();
        }else if(!preg_match("/[0-9]+/", $newpass)){
          header("Location: resetPassword.php?error=New Password must contain at least one number!");
              exit();
        }else if(!preg_match("/[A-Z]+/", $newpass)){
          header("Location: resetPassword.php?error=New Password must contain at least one capital letter!");
              exit();
        }else if(!preg_match("/[a-z]+/", $newpass)){
          header("Location: resetPassword.php?error=New Password must contain at least one lowercase letter!");
              exit();
        }else if(!preg_match("/\w+/", $newpass)){
          header("Location: resetPassword.php?error=New Password must contain at least one symbol!");
              exit();
        }else if($newpass !== $conpass){
          header("Location: resetPassword.php?error=The confirmation password does not match with your new password!");
              exit();
        }

        if(empty($conpass)){
          header("Location: resetPassword.php?error=Confirm Password Is Required!");
              exit();
        }else{

        $verifyQuery = $con->query("SELECT * FROM user_form WHERE email = '$email'");
        if($verifyQuery->num_rows > 0) {
            $password_hash = password_hash($newpass, PASSWORD_DEFAULT);
            $changeQuery = $con->query("UPDATE user_form SET password = '$password_hash' WHERE email = '$email'");

            if($changeQuery) {
                    header("Location: resetPassword.php?success=Your password has been changed successfully");
                exit();
            }
        } else {
            echo "Invalid email address";
        }
        }

        $con->close();
    }
    ?>
