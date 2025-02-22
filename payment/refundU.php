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
        
        <form action="payRecordUser.php" style="border:1px solid black; margin:300px; background-color: white;width:300px;margin-left:600px;border-radius: 10px;">
     <?php
     $current_date = date('d-m-Y');
require_once '../config/helper.php';

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Prepare SQL statement to insert refund request
$stmt = $conn->prepare("INSERT INTO refund (refundid, payid, product, quantity, totalPrice, orderDate,requestDate, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");

// Generate a unique refund ID in the format "R001"
$last_id = $conn->query("SELECT MAX(refundid) AS max_id FROM refund")->fetch_assoc()['max_id'];
$new_id = sprintf('R%03d', intval(substr($last_id, 1)) + 1);

// Bind parameters to statement
$stmt->bind_param("sssidss", $new_id, $_POST['payid'], $_POST['product'], $_POST['quantity'], $_POST['totalPrice'], $_POST['date'],$current_date);

// Execute statement
try {
  $stmt->execute();
  echo "Refund requested successfully!";
} catch (mysqli_sql_exception $e) {
  if ($e->getCode() == 1062) {
    echo "You have already requested a refund for this payment.";
  } else {
    echo "Error requesting refund: " . $e->getMessage();
  }
}
echo"<br><br><br>";
// Close the database connection
$conn->close();
?>
            
            <input style="margin-left: 20px" type = "submit" value = "Back" name = "back" />
    </form>
                 
    </body>
</html>
