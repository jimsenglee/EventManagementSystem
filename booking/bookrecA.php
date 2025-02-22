<?php
session_start();
require_once '../event_management/helper.php';

if(!isset($_SESSION['admin_name'])){
   header('location:../login/login.php');
}
?>

<!DOCTYPE html>

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
    <title>Payment Record</title>
  </head>
     
          <?php
        if(isset($_SESSION["admin_name"])) {
            include '../header&footer/adminHeader.php';
        } else {
            include '../header&footer/userHeader.php';
        }
        ?>  
  
      <div class="tcontainer">
          <div class="loader">
        <span style="--i:1;">B</span>
        <span style="--i:2;">O</span>
        <span style="--i:3;">O</span>
        <span style="--i:4;">K</span>
        <span style="--i:5;">I</span>
        <span style="--i:6;">N</span>
        <span style="--i:7;">G</span>
        <span style="--i:7;"></span>
        <span style="--i:8;">R</span>
        <span style="--i:9;">E</span>
        <span style="--i:10;">C</span>
        <span style="--i:11;">O</span>
        <span style="--i:12;">R</span>
        <span style="--i:13;">D</span>
        </div>
          
       <!-- search bar form -->
<form style="float:left;" action="" method="GET">
  <input type="text" name="query" placeholder="Search...">
  <button type="submit">Search</button>
</form>      

<!-- payment record table -->
<table style="color: black;">
  <tr>
      <th>No.</th><th>Name</th>><th>Venue</th><th>Date</th><th>Time</th><th>Status</th><th>Action</th>
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
        echo "<td>".$row["bookid"]."</td>";
        echo "<td>".$row["name"]."</td>";
        echo "<td>".$row["venue"]."</td>";
        echo "<td>". $row["date"] . "</td>";
        echo "<td>". $row["startTime"] .'-'. $row["endTime"] . "</td>";
        
        
        // Display status in different colors
        if ($row["status"] == "successful") {
          echo '<td style="color: green;">'. $row["status"] . "</td>";
        } elseif ($row["status"] == "Cancel") {
          echo '<td style="color: red;">'. $row["status"] . "</td>";
        }elseif ($row["status"] == "Reject") {
          echo '<td style="color: red;">'. $row["status"] . "</td>";
        } else {
          echo "<td>". $row["status"] . "</td>";
        }
        
   echo '<td>
  <form action="updateStatus.php" method="post">
    <input type="hidden" name="bookid" value="' . $row['bookid'] . '">
    <input type="hidden" name="status" value="successful">
    <input type="submit" value="Allow" name="request">
  </form>
  <form action="updateStatus.php" method="post">
    <input type="hidden" name="bookid" value="' . $row['bookid'] . '">
    <input type="hidden" name="status" value="Reject">
    <input type="submit" value="Reject" name="request">
  </form>
</td>';
        
        
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
          alert("Your Request send successful");
      }
      </script>

      
              <?php include '../header&footer/footer.php' ?>

  </body>
  
  
</html>