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
    <link rel="stylesheet" href="recordU.css" />
    <script src="activeNavbar.js">
    </script>    
    <title>Payment Record</title>
  </head>
  <body>
  
              <?php
        if(isset($_SESSION["admin_name"])) {
            include '../header&footer/adminHeader.php';
        } else {
            include '../header&footer/userHeader.php';
        }
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
    <th>No.</th><th>Member Name</th><th>Product</th><th>Quantity</th><th>Total Price(RM)</th><th>Payment Date</th><th>Status</th><th>Invoice</th><th>Action</th>
  </tr>
 <?php
// Retrieve 4 parameters from helper.php
require_once '../config/helper.php';

// Step 2: Connect PHP app with database
// Object-oriented method
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_POST['delete'])) {
  $payid = $_POST['payid'];
  $sql = "DELETE FROM payreca WHERE payid = '$payid'";
  if ($conn->query($sql) === TRUE) {
    echo "<span style='color:white;'>Record deleted successfully</span>";
  } else {
    echo "Error deleting record: " . $conn->error;
  }
}// Step 3: SQL statement


$sql = "SELECT * FROM payreca";

// Step 4: Handle search query
if (isset($_GET['query'])) {
  $query = $_GET['query'];
$sql .= " WHERE product LIKE '%$query%' OR date LIKE '%$query%' OR status LIKE '%$query%' OR quantity LIKE '%$query%' OR totalPrice LIKE '%$query%' OR memberName LIKE '%$query%'";
}

// Step 5: Run SQL query
if ($result = $conn->query($sql)) {
  // Step 6: Display data on website
  $count = 1; // initialize count to 1
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$count."</td>"; // display count
    echo "<td>".$row["memberName"]."</td>";
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

    echo "<td><a href='generate_invoice.php?payid=" . $row["payid"] . "' target='_blank'>Generate Invoice</a></td>";
echo "<td>";
    echo "<form method='POST' action=''>";
    echo "<input type='hidden' name='payid' value='" . $row["payid"] . "'>";
    echo "<input type='submit' name='delete' value='Delete'>";
    echo "</form>";
    echo "</td>";
     echo "</tr>";
    $count++; // increment count by 1
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
     
    
      </script>
      
              <?php include '../header&footer/footer.php' ?>

  </body>
  
  
</html>
