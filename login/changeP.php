<?php 
session_start();

if (isset($_SESSION['id']) && (isset($_SESSION['admin_name'])||isset($_SESSION['user_name']))) {
    
    include "configuration.php";

if (isset($_POST['oldPass']) && isset($_POST['newPass']) && isset($_POST['conPass'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$oldpass = validate($_POST['oldPass']);
	$newpass = validate($_POST['newPass']);
	$conpass = validate($_POST['conPass']);
    
    if(empty($oldpass)){
      header("Location: changePassword.php?error=Old Password is required!");
	  exit();
    }
    
    if(empty($newpass)){
      header("Location: changePassword.php?error=New Password is required!");
	  exit();
    }else if(strlen($newpass) < 7){
      header("Location: changePassword.php?error=New Password must be at least 7 characters long!");
	  exit();
    }else if(!preg_match("/[0-9]+/", $newpass)){
      header("Location: changePassword.php?error=New Password must contain at least one number!");
	  exit();
    }else if(!preg_match("/[A-Z]+/", $newpass)){
      header("Location: changePassword.php?error=New Password must contain at least one capital letter!");
	  exit();
    }else if(!preg_match("/[a-z]+/", $newpass)){
      header("Location: changePassword.php?error=New Password must contain at least one lowercase letter!");
	  exit();
    }else if(!preg_match("/\w+/", $newpass)){
      header("Location: changePassword.php?error=New Password must contain at least one symbol!");
	  exit();
    }else if($newpass !== $conpass){
      header("Location: changePassword.php?error=The confirmation password does not match with your new password!");
	  exit();
    }else if($newpass == $oldpass){
      header("Location: changePassword.php?error=The New Password and the Old password is exactly same! Please Try Again.");
	  exit();
    }
    
    
    if(empty($conpass)){
      header("Location: changePassword.php?error=Confirm Password Is Required!");
	  exit();
    }
    
    else {
    	// hashing the password
        $id = $_SESSION['id'];

        $sql = "SELECT password FROM user_form WHERE id='$id'";

        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password'];
            
         if (password_verify($oldpass, $hashed_password)) {
                // Hash the new password and update the database
                $newpass = password_hash($newpass, PASSWORD_DEFAULT);
                $sql_2 = "UPDATE user_form SET password='$newpass' WHERE id='$id'";
                mysqli_query($con, $sql_2);
                header("Location: changePassword.php?success=Your password has been changed successfully");
                exit();
            }else {
        	header("Location: changePassword.php?error=Incorrect Old Password");
	        exit();
        }

    }

    
}else{
	header("Location: changePassword.php");
	exit();
}

}else{
     header("Location: login.php");
     exit();
}
