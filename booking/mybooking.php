<?php
session_start();
require_once '../event_management/helper.php';

if(!isset($_SESSION['user_name'])){
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
    <link href="../payment/recordU.css" rel="stylesheet" type="text/css"/>
    <script src="activeNavbar.js">
    </script>    
    <title>My Booking</title>
  </head>
     <body>

        <?php
        if(isset($_SESSION["user_name"])) {
            include '../header&footer/userHeader.php';
        } else {
            include '../header&footer/adminHeader.php';
        }
        ?>      
  
     
      <div class="tcontainer">
          <div class="loader">
        <span style="--i:1;">M</span>
        <span style="--i:2;">Y</span>
        <span style="--i:2;"></span>
        <span style="--i:3;">B</span>
        <span style="--i:4;">O</span>
        <span style="--i:5;">O</span>
        <span style="--i:6;">K</span>
        <span style="--i:7;">I</span>
        <span style="--i:8;">N</span>
        <span style="--i:9;">G</span>

        </div>
          
      
      <!-- search bar form -->
<form style="float:left;" action="" method="GET">
  <input type="text" name="query" placeholder="Search...">
  <button type="submit">Search</button>
</form>      

<!-- payment record table -->
<table style="color: black;">
  <tr>
    <th>No.</th><th>Venue</th><th>Date</th><th>Time</th><th>Status</th><th>Action</th>
  </tr>
 <?php
    // Retrieve 4 parameters from helper.php
    require_once '../config/helper.php';
    
    // Step 2: Connect PHP app with database
    // Object-oriented method
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Step 3: SQL statement
    $sql = "SELECT * FROM booking";
    
    // Step 4: Handle search query
    if (isset($_GET['query'])) {
      $query = $_GET['query'];
      $sql .= " WHERE venue LIKE '%$query%' OR date LIKE '%$query%' OR status LIKE '%$query%'";
    }
    $count=1;
    // Step 5: Run SQL query
    if ($result = $conn->query($sql)) {
      // Step 6: Display data on website
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>$count</td>";
        echo "<td>".$row["venue"]."</td>";
        echo "<td>". $row["date"] . "</td>";
        echo "<td>". $row["startTime"] .'-'. $row["endTime"] . "</td>";
        
        
        // Display status in different colors
        if ($row["status"] == "successful") {
          echo '<td style="color: green;">'. $row["status"] . "</td>";
          if ($row["status"] == "successful" || $row["status"] == "pending") {
            echo '<td>
              <form action="updateStatus.php" method="post">
    <input type="hidden" name="bookid" value="' . $row['bookid'] . '">
    <input type="hidden" name="status" value="Cancel">
    <input type="submit" value="Reject" name="request">
  </form>
            </td>';
          } else {
            echo "<td></td>";
          }
        } elseif ($row["status"] == "Cancel") {
          echo '<td style="color: red;">'. $row["status"] . "</td>";
          echo "<td></td>";
        } elseif ($row["status"] == "Reject") {
          echo '<td style="color: red;">'. $row["status"] . "</td>";
          echo "<td></td>";
        } else {
          echo "<td>". $row["status"] . "</td>";
          echo "<td></td>";
        }
        
        echo "</tr>";
        $count++;
      }
      
      // Step 7: Free result set
      $result->free();
    } else {
      echo "Error: " . $conn->error;
    }
    
    // Step 8: Close database connection
    $conn->close();
  ?>
</table>

          
          
        </div>
 <script>  
      function rfunction(){
          alert("You have cancel your booking");
      }
      </script>

                   <?php include '../header&footer/footer.php' ?>

      
  </body>
  
  
</html>
