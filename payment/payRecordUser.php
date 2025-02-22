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
    <link rel="stylesheet" href="recordU.css" />
    <script src="activeNavbar.js">
    </script>    
    <title>Payment Record</title>
  </head>
    
  <body>
   <?php
        if(isset($_SESSION["user_name"])) {
            include '../header&footer/userHeader.php';
        } else {
            include '../header&footer/adminHeader.php';
        }
        ?>      
      <?php
    
  ?>
      <div class="tcontainer">
          <div class="loader">
        <span style="--i:1;">P</span>
        <span style="--i:2;">a</span>
        <span style="--i:3;">y</span>
        <span style="--i:4;">m</span>
        <span style="--i:5;">e</span>
        <span style="--i:6;">n</span>
        <span style="--i:7;">t</span>
        <span style="--i:7;"></span>
        <span style="--i:8;">R</span>
        <span style="--i:9;">e</span>
        <span style="--i:10;">c</span>
        <span style="--i:11;">o</span>
        <span style="--i:12;">r</span>
        <span style="--i:13;">d</span>
        </div>
          
   <!-- search bar form -->
<form style="float:left;" action="" method="GET">
  <input type="text" name="query" placeholder="Search...">
  <button type="submit">Search</button>
</form>      

<!-- payment record table -->
<table style="color: black;">
  <tr>
    <th>No.</th><th>Product</th><th>Quantity</th><th>Total Price(RM)</th><th>Payment Date</th><th>Status</th><th>Refund</th><th>Invoice</th>
  </tr>
  <?php
    // Retrieve 4 parameters from helper.php
    require_once '../config/helper.php';
    
    // Step 2: Connect PHP app with database
    // Object-oriented method
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Step 3: SQL statement
    $sql = "SELECT * FROM payrecu";
    
    // Step 4: Handle search query
    if (isset($_GET['query'])) {
      $query = $_GET['query'];
      $sql .= " WHERE product LIKE '%$query%' OR date LIKE '%$query%' OR status LIKE '%$query%'OR quantity LIKE '%$query%'OR totalPrice LIKE '%$query%'";
    }
    
    // Step 5: Run SQL query
    if ($result = $conn->query($sql)) {
      // Step 6: Display data on website
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["payid"]."</td>";
        echo "<td>". $row["product"] . "</td>";
        echo "<td>". $row["quantity"] . "</td>";
        echo "<td>". $row["totalPrice"] . "</td>";
        echo "<td>". $row["date"] . "</td>";
        
        // Display status in different colors
        if ($row["status"] == "Successful") {
          echo '<td style="color: green;">'. $row["status"] . "</td>";
        } elseif ($row["status"] == "Refund") {
          echo '<td style="color: red;">'. $row["status"] . "</td>";
        } else {
          echo "<td>". $row["status"] . "</td>";
        }
        
        echo '<td>
          <form action="refundU.php" method="post">
            <input type="hidden" name="payid" value="'. $row["payid"] .'">
            <input type="hidden" name="product" value="'. $row["product"] .'">
            <input type="hidden" name="quantity" value="'. $row["quantity"] .'">
            <input type="hidden" name="totalPrice" value="'. $row["totalPrice"] .'">
            <input type="hidden" name="date" value="'. $row["date"] .'">
            <input type="hidden" name="status" value="'. $row["status"] .'">
            <input type="submit" value="Request" name="request">
          </form>
        </td>';
        
        echo "<td><a href='generate_invoice.php?payid=" . $row["payid"] . "' target='_blank'>Generate Invoice</a></td>";
        echo "</tr>";
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
          alert("Your Request send successful");
      }
      </script>

              <?php include '../header&footer/footer.php' ?>
      
      
  </body>
  
  
</html>




