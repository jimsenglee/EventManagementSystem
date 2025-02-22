<?php
session_start();
require_once '../event_management/helper.php';

if(!isset($_SESSION['admin_name'])){
   header('location:../login/login.php');
}
?>

<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate name field
    if (empty($_POST["name"])) {
        $error[] = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        // Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $error[] = "Only letters and white space allowed";
        }
    }

    // Validate description field
    if (empty($_POST["description"])) {
        $error[] = "Description is required";
    } else {
        $description = test_input($_POST["description"]);
    }

    // Validate image field
    if(isset($_FILES['image'])){
      $image = $_FILES['image']['name'];
      $image_size = $_FILES['image']['size'];
      $image_tmp_name = $_FILES['image']['tmp_name'];
      $image_folder = 'uploaded_img/'.$image;

    if($image_size > 5000000){
         $error['img_large'] = 'image size is too large!';
      }
   }

    // Validate price field
    if (empty($_POST["price"])) {
        $error[] = "Price is required";
    } else {
        $price = test_input($_POST["price"]);
        // Check if price is a positive number
        if (!is_numeric($price) || $price <= 0) {
            $error = "Price must be a positive number";
        }
    }

    // Validate qty field
    if (empty($_POST["qty"])) {
        $error[] = "Quantity cannot be empty";
    } else {
        $qty = test_input($_POST["qty"]);
        // Check if qty is a positive integer
        if (!ctype_digit($qty) || $qty < 0) {
            $error[] = "Quantity must be a positive integer";
        }
    }

if(empty($error)){
$con = new mysqli("localhost", "username", "password", "database");

// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}

// Escape user inputs for security
$name = mysqli_real_escape_string($con, $_POST['name']);
$description = mysqli_real_escape_string($con, $_POST['description']);
$image = mysqli_real_escape_string($con, $_POST['image']);
$price = mysqli_real_escape_string($con, $_POST['price']);
$qty = mysqli_real_escape_string($con, $_POST['qty']);

// Attempt insert query execution
$sql = "INSERT INTO merchandise (name, description, image, price, qty) VALUES ('$name', '$description', '$image', '$price', '$qty')";
if($con->query($sql) === true){
    echo "Merchandise added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . $con->error;
}

// Close connection
$con->close();
   }
// Function to test and sanitize form input data
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


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
        <script src="show_password.js" type="text/javascript"></script>
        <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">    
        <link href="../css/SPSmerc.css" rel="stylesheet" type="text/css"/>
        <script src="activeNavbar.js"></script>
        <script src="showForm.js"></script>
        <title>Merchandise module for Admin</title>
    </head>

  
    <body>
        <?php
        if(isset($_SESSION["admin_name"])) {
            include '../header&footer/adminHeader.php';
        } else {
            include '../header&footer/userHeader.php';
        }
        ?>              <?php
    //retrieve parameter
    require_once '../config/helper.php';

    // Create connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the "Delete" button has been clicked
    if (isset($_POST['delete'])) {
        // Get the ID of the merchandise item to be deleted from the hidden input field
        $id = $_POST['id'];

        // Delete the merchandise item from the database
        $sql = "DELETE FROM merch WHERE ID = $id";
        if (mysqli_query($conn, $sql)) {
            echo "Merchandise item deleted successfully.";
        } else {
            echo "Error deleting merchandise item: " . mysqli_error($conn);
        }
    }

    $sql = "SELECT * FROM merch";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        echo "No merchandise items found.";
    }
    else {
        // Display merchandise items in a table
        echo "<table id='displayTable'>";
        echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Image</th><th>Price</th><th>Quantity</th><th></th><th></th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['ID'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td><img src='upload/" . $row['image'] . "' alt=''></td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . $row['qty'] . "</td>";
            echo "<td class='edit-btn'><a href='editMerchandise.php?id=" . $row['ID'] . "'>Edit</a></td>";
            echo "<td class='delete-btn'>
                    <form method='POST'>
                        <input type='hidden' name='id' value='" . $row['ID'] . "'>
                        <button type='submit' name='delete' onclick=\"return confirm('Are you sure you want to delete this merchandise item?');\">Delete</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    }
            
    mysqli_close($conn);
?>
        <form id="add-item-form" method="POST" action="">
            <?php
                if(isset($error)){
                    foreach($error as $value){
                        echo '<span class="error-msg">'.$value.'</span>';
                        };
                };
            ?>

            
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo (isset($name))?$name: "";?>" required>
  
            <label for="description">Description:</label>
            <input type="text" name="description" value="<?php echo (isset($description))?$description: "";?>"required>
  
            <label for="image">Image:</label>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" required>
  
            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" value="<?php echo (isset($price))?$price: "";?>" required>
  
            <label for="qty">Quantity:</label>
            <input type="number" name="qty" value="<?php echo (isset($qty))?$qty: "";?>">
  
            <input type="submit" value="Add Merch Item " href="merchandiseAdmin.php">
        </form>

        <?php include '../header&footer/footer.php' ?>
    </body>
</html>
