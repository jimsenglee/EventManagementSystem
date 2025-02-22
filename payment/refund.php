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
    <title>Refund Record</title>
  </head>
      <header>
     <?php
        if(isset($_SESSION["user_name"])) {
            include '../header&footer/userHeader.php';
        } else {
            include '../header&footer/adminHeader.php';
        }
        ?>   
      <div class="tcontainer">
          <div class="loader">
        <span style="--i:1;">R</span>
        <span style="--i:2;">E</span>
        <span style="--i:3;">F</span>
        <span style="--i:4;">U</span>
        <span style="--i:5;">N</span>
        <span style="--i:6;">D</span>
        <span style="--i:7;"></span>
        <span style="--i:7;">R</span>
        <span style="--i:8;">E</span>
        <span style="--i:9;">Q</span>
        <span style="--i:10;">U</span>
        <span style="--i:11;">E</span>
        <span style="--i:12;">S</span>
        <span style="--i:13;">T</span>
        </div>
      
     <form style="float:left;" action="" method="GET">
  <input type="text" name="query" placeholder="Search...">
  <button type="submit">Search</button>
</form>  
          
          
 <table style="color: black;">
     <tr>
         <th>Request ID</th>
         <th>Pay ID</th>
         <th>Product</th>
         <th>Quantity</th>
         <th>Total Price(RM)</th>
         <th>Order Date</th>
         <th>Request Date</th>
         <th>Status</th>
         <th>decision</th>
         
         
     </tr>
<?php

// Retrieve 4 parameters from helper.php
require_once '../config/helper.php';

// Step 2: Connect PHP app with database
// Object-oriented method
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check if a button has been clicked
if (isset($_POST['refund'])) {
    // Get the refund ID and button value
    $refund_id = $_POST['refund_id'];
    $button_value = $_POST['refund'];

    // Update refund status based on button value
    if ($button_value == 'Allow') {
        $status = 'Refund';
        $payrecu_status = 'Refund';
    } elseif ($button_value == 'Disallow') {
        $status = 'Rejected';
         $payrecu_status = 'Successful';
    }
    $stmt = $conn->prepare("UPDATE refund SET status = ? WHERE refundid = ?");
    $stmt->bind_param("ss", $status, $refund_id);
    $stmt->execute();

        // Get the payid from the refund table
    $stmt2 = $conn->prepare("SELECT payid FROM refund WHERE refundid = ?");
    $stmt2->bind_param("s", $refund_id);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $row = $result->fetch_assoc();
    $payid = $row['payid'];

    // Update the payreci table
    $stmt3 = $conn->prepare("UPDATE payrecu SET status = ? WHERE payid = ?");
    $stmt3->bind_param("ss", $payrecu_status, $payid);
    $stmt3->execute();

}

// Step 3: SQL statement
$sql = "SELECT * FROM refund";

// Step 4: Run SQL query
if ($result = $conn->query($sql)) {
    // Step 5: Display data on website
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["refundid"] . "</td>";
        echo "<td>" . $row["payid"] . "</td>";
        echo "<td>" . $row["product"] . "</td>";
        echo "<td>" . $row["quantity"] . "</td>";
        echo "<td>" . $row["totalPrice"] . "</td>";
        echo "<td>" . $row["orderDate"] . "</td>";
        echo "<td>" . $row["requestDate"] . "</td>";
        // Display status in different colors
        if ($row["status"] == "Refund") {
            echo '<td style="color: green;">' . $row["status"] . "</td>";
        } elseif ($row["status"] == "Rejected") {
            echo '<td style="color: red;">' . $row["status"] . "</td>";
        } else {
            echo "<td>" . $row["status"] . "</td>";
        }
        echo '<td>
                    <form method="post">
                        <input type="hidden" name="refund_id" value="' . $row["refundid"] . '">
                        <input type="submit" value="Allow" name="refund">
                        <input type="submit" value="Disallow" name="refund">
                    </form>
                  </td>';
        echo "</tr>";
    }
}

?>
</table>
        </div>
          
          
      <script>  
      function afunction(){
          alert("The request is allowed");
      }
      function dfunction(){
          alert("The request is reject");
      }
      </script>
<footer class="footer">
    <div class="footer-desc">
        <h1>More Info</h1>
    </div>
  	 <div class="container">
  	 	<div class="row">
  	 		<div class="footer-col1">
  	 			<h4>Society </h4>
  	 			<ul>
  	 				<li><a href="#">about us</a></li>
  	 				<li><a href="#">our services</a></li>
  	 				<li><a href="#">privacy policy</a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col2">
  	 			<h4>get help</h4>
  	 			<ul>
  	 				<li><a href="#">Contact Us</a></li>
  	 				<li><a href="#">FAQ</a></li>
  	 				<li><a href="#">Feedback</a></li>
  	 				<li><a href="#">payment options</a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col3">
  	 			<h4>Our Community</h4>
  	 			<ul>
  	 				<li><a href="#">Blogs</a></li>
  	 				<li><a href="#">Forums</a></li>
  	 				<li><a href="#">Latest News</a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col4">
  	 			<h4>follow us</h4>
  	 			<div class="socialmedia">
  	 				<a href="#"><i class="fab fa-facebook-f"></i></a>
  	 				<a href="#"><i class="fab fa-twitter"></i></a>
  	 				<a href="#"><i class="fab fa-instagram"></i></a>
  	 			</div>
  	 		</div>
  	 	</div>
  	 </div>
  </footer>
  </body>
  
  
</html>
