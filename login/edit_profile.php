<?php

    include 'configuration.php';

    session_start();
    
    if (!isset($_SESSION['admin_name'])) {
        header('Location: login.php');
        exit();
    }

    $error = array();
?>



    <?php 
                    $q = mysqli_query($con, "SELECT * FROM user_form WHERE user_name = '{$_SESSION['admin_name']}'") or 
                                      die ('query failed');
                    
                        if(mysqli_num_rows($q) > 0){
                        $row = mysqli_fetch_assoc($q);
                        
			$first=$row['fname'];
			$last=$row['lname'];
			$password=$row['password'];
			$email=$row['email'];
			$contact=$row['contact_num'];

                        }else {
                            $row = null;
                        }
   
                
		if(isset($_POST['submit']))
		{
                   // check First Name requirements   
                   if (!preg_match("/^[a-zA-Z ]*$/", $_POST['first'])) {
                   $error['f_name'] = 'First Name can only contain letters and spaces';
                   }   
                   
                   // check Last Name requirements   
                   if (!preg_match("/^[a-zA-Z ]*$/", $_POST['last'])) {
                   $error['f_name'] = 'Last Name can only contain letters and spaces';
                   }   
                    
                    //check contact number requirement
                   if(!preg_match('/^01[0-9]-\d{7,8}$/',$_POST['contact'])){
                        $error['phone']="YOUR <b>PHONE NUMBER</b> is invalid";
                   }
                   
                   
                    // check Image requirements   
                       if(isset($_FILES['image'])){
                          $image = $_FILES['image']['name'];
                          $image_size = $_FILES['image']['size'];
                          $image_tmp_name = $_FILES['image']['tmp_name'];
                          $image_folder = 'uploaded_img/'.$image;

                             if($image_size > 1048576 ){
                          $error['img_large'] = 'Image size is too large!';
                       }
                       }                   
                    
                    
                    
                    
                         if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

                             $pic = $_FILES['image']['name'];
                        move_uploaded_file($_FILES['image']['tmp_name'], "uploaded_img/" . $_FILES['image']['name']);
                        
                    } else {

                        $pic = $row['image'];
                    }
                        
                            if (count($error) == 0) { // Check if there are no errors

                        $sql1= "UPDATE user_form SET image='$pic', fname='{$_POST['first']}', lname='{$_POST['last']}', email='{$_POST['email']}', contact_num='{$_POST['contact']}' WHERE user_name = '{$_SESSION['admin_name']}';";

			if(mysqli_query($con,$sql1))
			{
				?>
					<script type="text/javascript">
						alert("Saved Successfully.");
						window.location="edit_profile.php";
					</script>
				<?php
			}
		}
                }
 	?>





<!DOCTYPE html>
<html>
<head>
    <link href="profile.css" rel="stylesheet" type="text/css"/>
	<title>edit profile</title>
</head>
<body>
        <?php
        if(isset($_SESSION["admin_name"])) {
            include '../header&footer/adminHeader.php';
        } else {
            include '../header&footer/userHeader.php';
        }
        ?>    
    
	
        
        <div class="edit-wrapper">
            	<h2>Edit Information</h2>

                                                        <?php
if (count($error) > 0) { // Check if there are any errors
    foreach ($error as $msg) {
        echo '<span class="error-msg">' . $msg . '</span>';
    }
}
?>
                
	<div class="profile_info"">
            <?php
             if(isset($row)) {
                echo "<div class='profile-pic' style='text-align:center'>
                          <img src='uploaded_img/".$row['image']."'>
                      </div>"; 
             }
            ?>
            
                        <b>Welcome, <?php echo $_SESSION['admin_name']?></b>
				<br/>
                                <br/>
 			</div>
	
	<div class="form1">
            <form action="" method="post" enctype="multipart/form-data">
    <label><h4><b>Update your picture: </b></h4></label>
    <input class="form-control" type="file" name="image" >

    <label><h4><b>First Name: </b></h4></label>
    <input class="form-control" type="text" name="first" value="<?php echo $first; ?>" placeholder="enter previous First Name">

    <label><h4><b>Last Name:</b></h4></label>
    <input class="form-control" type="text" name="last" value="<?php echo $last; ?>" placeholder="enter previous Last Name">

    
    <label><h4><b>Email:</b></h4></label>
    <input class="form-control" type="text" name="email" value="<?php echo $email; ?>" readonly>

    <label><h4><b>Contact No:</b></h4></label>
    <input class="form-control" type="text" name="contact" value="<?php echo $contact; ?>" placeholder="enter previous Contact Number">

    <label><h4><b>Change Password:</b></h4></label>
                    <a href="changePassword.php" class="edit-button">Change Password</a>

    
    <br>
    <div style="text-align: center;">
      <button class="save-btn" type="submit" name="submit">Save</button>
    </div>
  </form>
</div>
        </div>
	
                                        

</body>
</html>