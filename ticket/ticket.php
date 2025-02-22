<?php
    session_start();
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
    <link rel="stylesheet" href="ticket.css" />
    <script src="activeNavbar.js">
    </script>    
    <title>Ticket</title>
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
         
  <table>
    <tr>
        <th>No.</th>
        <th>Tournament</th>
        <th>Status</th>
        <th>Seat Available</th>
        <th>Price per ticket</th>
        <th>Check</th>
    </tr>
    <?php
    require_once '../config/helper.php';
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Execute the second query
$sql2 = "SELECT COUNT(*) as invalid_seats FROM badseat WHERE status = 'invalid'";
$result2 = $conn->query($sql2);
if ($result2 === false) {
  die("Error: " . $conn->error);
}
$row2 = $result2->fetch_assoc();
$invalid_seats = $row2['invalid_seats'];

    $sql = "SELECT * FROM events";
    if ($result = $conn->query($sql)) {
        $counter = 1; // initialize counter variable
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $counter . "</td>"; // use counter variable to generate No.
            echo "<td>" . $row["event_category"] . "</td>";
             $available_seats = $row["ticket_amount"] - $invalid_seats;
            if ($available_seats > 0) {
            echo "<td style='color:green'>Available</td>";
        } else {
            echo "<td style='color:red'>Sold Out</td>";
        }
        
            
        echo "<td>" . $available_seats . "</td>";
            echo "<td>" . $row["ticket_price"] . "</td>";
            echo '<td>
                <form action="ticDetail.php" method="get">
                    <input type="hidden" name="eventCategory" value="' . $row["event_category"] . '">
                    <input type="hidden" name="ticPrice" value="' . $row["ticket_price"] . '">
                    <input type="hidden" name="eventVenue" value="' . $row["event_venue"] . '">
                    <input type="hidden" name="eventYear" value="' . $row["event_year"] . '">
                    <input type="hidden" name="eventMonth" value="' . $row["event_month"] . '">
                    <input type="hidden" name="eventDay" value="' . $row["event_day"] . '">
                    <input type="hidden" name="eventTime" value="' . $row["event_start_time"] . '">
                    <input type="hidden" name="seat" value="' . $row["ticket_amount"] . '">
                    <input type="submit" value="Check" name="check">
                </form>
            </td>';
            echo "</tr>";
           
            $counter++; // increment counter variable
        }
    }
    ?>
</table>
          
          
          
      </div> 
      <script>
      
      
      function sold(){
          alert("The ticket is SOLD OUT");
      }
      
       function un(){
          alert("this competition is not being held now");
      }
      
      
      </script>
        
                   <?php include '../header&footer/footer.php' ?>

  </body>
  
  
</html>
