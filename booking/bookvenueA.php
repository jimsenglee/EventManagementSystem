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
Click nbfs://nbhost/SystemFileSystem/Templates/Other/html.html to edit this template
-->
<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

<link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">    
    <link href="bookvenueA.css" rel="stylesheet" type="text/css"/>
    <script src="activeNavbar.js">
    </script>    
    <title>Book  for admin</title>
  </head>

        <?php
        if(isset($_SESSION["admin_name"])) {
            include '../header&footer/adminHeader.php';
        } else {
            include '../header&footer/userHeader.php';
        }
        ?>    
  
      <a href="add.php"><div class="add">ADD VENUE</div></a>
      

       <div class="vcontainer">
  <?php
  // Retrieve 4 parameters from helper.php
  require_once '../config/helper.php';

  // Step 2: Connect PHP app with database
  // Object-oriented method
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // Step 3: Define the SQL query
  $sql = "SELECT * FROM venue";

  // Step 4: Execute the query and get the results
  if ($result = $conn->query($sql)) {

    // Step 6: Loop through the results and display the data
    while ($row = $result->fetch_assoc()) {
  // Use the image and name columns from the database to create the HTML for each venue
  echo '<div class="venuelogo">';
  echo '<p><a href="venueDetail.php?image=' . urlencode($row['image']) . '&name=' . urlencode($row['name']) . '"><img class="venuepng" src="../lsimage/' . $row['image'] . '" alt=""></a></p>';
  echo '<a href="venueDetail.php?image=' . urlencode($row['image']) . '&name=' . urlencode($row['name']) . '"><div class="venuename">' . $row['name'] . '</div></a>';
  echo '</div>';
}

    // Step 7: Close the database connection
    $result->free();
  }
  $conn->close();
  ?>
</div>
        
      <?php include '../header&footer/footer.php' ?>

      
  </body>
  
  
</html>
