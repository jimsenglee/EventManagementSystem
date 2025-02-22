<?php

    include 'configuration.php';

session_start();
$user_name = $_SESSION['user_name'];

if(!isset($_SESSION['user_name'])){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User page</title>

   <link href="userProfile.css" rel="stylesheet" type="text/css"/>

</head>
<body>
        <?php
        if(isset($_SESSION["user_name"])) {
            include '../header&footer/userHeader.php';
        } else {
            include '../header&footer/adminHeader.php';
        }
        ?>    
<div class="container">

 		
 		<div class="wrapper">
                    
 			<?php

                        $q = mysqli_query($con, "SELECT * FROM user_form WHERE user_name = '{$_SESSION['user_name']}'") or 
                        die ('query failed');
                        
                        if(mysqli_num_rows($q) > 0){
                        $row = mysqli_fetch_assoc($q);
                        }
                        
                        ?>
                    
                    <br/>
                    <h2 style="text-align: center;color: white">User Profile</h2>
                    
                    <div style="text-align: center;color: white"> 
                        <b>Welcome, <?php echo $_SESSION['user_name']?></b>
	 			<br/>
                                <br/>
 			</div>
                    
                    <div class="profile-wrapper">
                    <a href="edit_userprofile.php" class="edit-button">EDIT</a>

       
 			<?php
                        
                         	echo "<b>";
 				echo "<table class='table table-bordered'>";
      
                                if($row['image'] == ''){
                                    echo "<div>no image found!!!</div>";
                                    }else{                  
                                        echo "<div class='profile-pic' style='text-align:center'>
                                                <img src='uploaded_img/".$row['image']."'>
                                            </div>";    
                                    }
                        
                       $fields = array(
                            'User Name' => $row['user_name'],
                            'Email' => $row['email'],
                            'First Name' => $row['fname'],
                            'Last Name' => $row['lname'],
                            'Age' => $row['age'],
                            'Contact Number' => $row['contact_num'],
                            'Date Of Birth' => $row['birth_date']
                        );
                                
                                
                        foreach ($fields as $field => $value) {
                            printf('<tr><td><b>%s   :</b></td><td>%s</td></tr>', $field, $value);
                        }

 				echo "</table>";
 				echo "</b>";
 			?>
                        

 		</div>
 	</div>
    
        <?php include '../header&footer/footer.php' ?>

</body>
</html>