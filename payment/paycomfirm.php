<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
        
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body style="background-color: plum"> 
        
        <form action="../homePage/home.php" style="border:1px solid black; margin:300px; background-color: white;width:300px;margin-left:600px;border-radius: 10px;">
       <?php
  $eventCategory = urldecode($_GET['eventCategory']);
  $selectedSeats = urldecode($_GET['selectedSeats']);
  $totalPrice = urldecode($_GET['totalPrice']);
  $nameoc=urldecode($_GET['nameoc']);
  $seat1= urldecode($_GET["seat1"]);
  // Retrieve 4 parameters from helper.php
  $current_date = date('d-m-Y');
  require_once '../config/helper.php';

  // Step 2: Connect PHP app with database
  // Object-oriented method
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Get current number of rows in payrecu table
  $result = $conn->query("SELECT * FROM payrecu");
  $num_rows = $result->num_rows;

  // Generate new payid by incrementing number of rows and prefixing it with "P"
  $payid = "P" . sprintf('%03d', $num_rows + 1);

  // Prepare and execute SQL query to insert new payment record into payrecu
  $sql_payrecu = "INSERT INTO payrecu (payid, product, quantity, totalPrice, date, status) 
          VALUES ('$payid', '$eventCategory', '$selectedSeats', '$totalPrice', '$current_date', 'Successful')";

  // Prepare and execute SQL query to insert new payment record into payreca
  $sql_payreca = "INSERT INTO payreca (payid,memberName, product, quantity, totalPrice,date,status) 
          VALUES ('$payid', '$nameoc','$eventCategory', '$selectedSeats', '$totalPrice', '$current_date', 'Successful')";
  
  $sql_update="UPDATE badseat SET status='invalid' WHERE seatNum=$seat1";
$conn->query($sql_update);
  echo $seat1;

  if ($conn->query($sql_payrecu) === TRUE && $conn->query($sql_payreca) === TRUE) {
    echo "New payment record created successfully with payid: " . $payid;
  } else {
    echo "Error: " . $sql_payrecu . "<br>" . $conn->error;
    echo "Error: " . $sql_payreca . "<br>" . $conn->error;
  }

  // Close database connection
  $conn->close();
?>
            <input style="margin-left: 20px" type = "submit" value = "Home Page" name = "back" />
        </form>
    </body>
</html>
