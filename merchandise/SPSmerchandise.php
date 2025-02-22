<?php
session_start();
require_once '../event_management/helper.php';

if(!isset($_SESSION['user_name'])){
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
    <link href="../css/SPSmerc.css" rel="stylesheet" type="text/css"/>
    <script src="activeNavbar.js"></script>    
    <script src="shoppingcart.js" type="text/javascript"></script>
    <title>SPS Merchandise</title>
  </head>
  
  <body>        <?php
        if(isset($_SESSION["user_name"])) {
            include '../header&footer/userHeader.php';
        } else {
            include '../header&footer/adminHeader.php';
        }
        ?>    
  
        <h2 style="text-align:center;color:white;margin-bottom:30px;">SPS Merchandise shop</h2>
        <div class="search-container">
            <form action="/search">
            <input type="text" placeholder="Search...">
            <button type="submit" class="submitbtn" style="flex:none;margin-bottom:20px;">Search</button>
            </form>    
        </div>
        <?php
        require_once '../config/helper.php';
        
       $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve merchandise information from the database
$sql = "SELECT * FROM merch";
$result = $conn->query($sql);

// Display merchandise information
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='card'>";
        echo "<img src='upload/" . $row["image"] . "' alt='" . $row["name"] . "'>";
        echo "<p class='price'>RM" . $row["price"] . "</p>";
        echo "<p>" . $row["name"] . "</p>";
        echo "<p>" . $row["description"] . "</p>";
        if ($row["qty"] > 0) {
            echo "<p>Quantity: " . $row["qty"] . "</p>";
            echo "<p><button onclick='addToCart({name: \"" . $row["name"] . "\", price: " . $row["price"] . ", qty: " . $row["qty"] . "})'>Add to Cart</button></p><br/><br/>";
        } else {
            echo "<p>Out of Stock</p><br/><br/>";
        }
        echo "</div>";
    }
}
    ?>
    
        <h2 style="margin-top:20%;text-align:center;">Shopping Cart</h2>
        <table>
          <thead>
            <tr>
              <th>Item</th>
              <th>Price</th>
            </tr>
          </thead>
          <tbody id="cart-items">
          </tbody>
        </table>
        
        <form action="checkout.php" method="POST">
            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
            <button type="submit" class="submitbtn">Checkout</button>
        </form>
        
             <?php include '../header&footer/footer.php' ?>
        
  </body>
  
  
</html>