<?php
session_start();
require_once '../event_management/helper.php';

if(!isset($_SESSION['admin_name'])){
   header('location:../login/login.php');
}
?>



<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add Venue</title>
        
        
        <style>
            body{
                height:auto;
            }
            form{
    background-color:white;
    margin-top:100px;
    width:40%;
    margin-left:450px;
    border: 5px solid green;
    height:300px;
}
 
h1{
    font-size: large;
}
a{
    font-size:large;
    margin-left:50px;
}
table{
    border:2px solid black;
    width:100%;
    height:100%;
}

tr,td{
    border:1px solid black;
}
        </style>
    </head>
    <body>
         
        
        
        <?php
        if(isset($_SESSION["admin_name"])) {
            include '../header&footer/adminHeader.php';
        } else {
            include '../header&footer/userHeader.php';
        }
        ?>   
        
  <?php
require_once '../config/helper.php';

if (!is_dir('uploads')) {
    mkdir('uploads');
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_POST['addevent'])) {
    $name = $_POST['venue_name'];
    $day = $_POST['venue_day'];
    $time = $_POST['start_time'];
    $location = $_POST['venue_location'];
    $image = '';

    // Check if an image file was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Move the uploaded file to a permanent location
        $image_file = $_FILES['image']['name'];
        $target_dir = "../lsimage/";
        $target_file = $target_dir . basename($image_file);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $image_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $sql = "SELECT COUNT(*) as count FROM venue";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $count = $row['count'];

    // Generate the new venue ID
    $venue_id = "V" . str_pad($count+1, 3, "0", STR_PAD_LEFT);

    // Prepare and execute the SQL query to insert the new venue record
    $sql = "INSERT INTO venue (venueid, name, day, time, location, image) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $venue_id, $name, $day, $time, $location, $image);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "New venue added successfully";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<div>
  <form action="" method="POST" enctype="multipart/form-data">
    <table>
      <tr>
        <th colspan="2">Add New Venue
          
            <a href="bookvenueA.php">Back</a>
          
        </th>
      </tr>
      <tr>
        <td>Name:</td>
        <td><input type="text" name="venue_name" required placeholder="Enter Your Venue Name"></td>
      </tr>
      <tr>
        <td>Available Day:</td>
        <td><input type="text" name="venue_day" required placeholder="Enter The available Day"></td>
      </tr>
      <tr>
        <td class="left-column">Available time</td>
        <td><input type="text" name="start_time" required></td>
      </tr>
      <tr>
        <td class="left-column">Location:</td>
        <td><input type="text" name="venue_location" required placeholder="Enter The location"></td>
      </tr>
      <tr>
        <td class="left-column">Image:</td>
        <td><input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png"></td>
</tr>
<tr>
<td colspan="2" align="center">
<input type="submit" name="addevent" value="Submit">
<input type="reset" name="cancel" value="Cancel">
</td>
</tr>
</table>

  </form>
</div>

                      

                    
        
    
    
    
   
  
  
  
        <?php include '../header&footer/footer.php' ?>
  </body>
    </body>
</html>
