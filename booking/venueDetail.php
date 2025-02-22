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
    <link rel="stylesheet" href="venueDetail.css" />
    <script src="activeNavbar.js">
        
        
        
        
        
        
        
    </script>    
    <title>Venue Detail</title>
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
if (isset($_GET['image']) && isset($_GET['name'])) {
  $image = $_GET['image'];
  $name = $_GET['name'];

  // Step 2: Connect PHP app with database
  require_once '../config/helper.php';
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // Step 3: Create SQL query
  $sql = "SELECT * FROM venue WHERE name='$name'";

  // Step 4: Execute the query
  if ($result = $conn->query($sql)) {
    // Step 5: Handle the result
    if ($row = $result->fetch_assoc()) {
?>
      <div class="tcontainer">
        <h1 style="font-size:50px; text-align: center;">Venue Booking</h1>
        <div class="imgcontainer" >
          <img class="venueimg" src="../lsimage/<?php echo $row["image"]; ?>" alt=""/>
        </div>
        <table class="detailcontainer">
          <tr>
            <td >Venue: <?php echo $row["name"]; ?></td>
          </tr>
          <tr>
            <td >Available Time:<?php echo $row["time"]; ?></td>
          </tr>
          <tr>
            <td >Available Day :<?php echo $row["day"]; ?></td>
          </tr>
          <tr>
            <td >Location: <?php echo $row["location"]; ?></td>
          </tr>
        </table>
      </div>

 <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all fields are filled out
    if (!empty($_POST['name']) && !empty($_POST['id']) && !empty($_POST['date']) && !empty($_POST['start_time']) && !empty($_POST['end_time'])) {
        // Validate student ID
        $id = $_POST['id'];
        if (!preg_match('/^\d{2}[A-Z]{3}\d{5}$|^\d{2}[a-z]{3}\d{5}$/i', $id)) {
            echo 'Invalid student ID format';
            exit;
        }
        
        // Get booking data from POST variables
        $name1 = $_POST['name'];
        $date = $_POST['date'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        
        // Connect to database
        require_once '../config/helper.php';
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Generate booking ID
        $stmt = $conn->prepare('SELECT COUNT(*) FROM booking');
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->free_result(); 
        $book_id = 'B' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        // Insert booking into database
       $stmt = $conn->prepare('INSERT INTO booking (bookid, venue, name, studentid, date, startTime, endTime, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
$stmt->bind_param('ssssssss', $book_id, $name, $name1, $id, $date, $start_time, $end_time, $status);
$status = 'Pending'; // set the status value to 'Pending'
        echo "<script>";
if ($stmt->execute()) {
    echo "alert('Booking successful! Your booking ID is $book_id');";
} else {
    echo "alert('Error inserting booking');";
}
echo "</script>";
    } else {
        echo 'Please fill out all fields';
    }
}


?>

<form class="book" method="POST">
    <legend>Confirm Booking</legend>
    <div class="name">
        <span>Your Name:</span>
        <input type="text" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" />
    </div>
    <div class="Id">
        <span>Your Student ID:</span>
        <input type="text" name="id" value="<?php echo isset($_POST['id']) ? htmlspecialchars($_POST['id']) : ''; ?>" />
    </div>
    <div class="date">
        <span>Please Choose The Date:</span>
        <input type="date" name="date" value="<?php echo isset($_POST['date']) ? htmlspecialchars($_POST['date']) : ''; ?>" />
    </div>
    <div class="time">
        <span>Please Choose The Time:</span>
        <input type="time" name="start_time" value="<?php echo isset($_POST['start_time']) ? htmlspecialchars($_POST['start_time']) : ''; ?>" />
        <span>-</span>
        <input type="time" name="end_time" value="<?php echo isset($_POST['end_time']) ? htmlspecialchars($_POST['end_time']) : ''; ?>" />
    </div>
    <input class="booking" type="submit" value="Book" />
</form>
    
    
    <script>
function validateForm() {
  // Get values from the form
  var name = document.getElementById("name").value;
  var studentId = document.getElementById("student_id").value;

  // Validate name
  if (name == "") {
    alert("Name must be filled out");
    return false;
  }

  // Validate student ID
  var studentIdRegex = /^00\d{3}0\d{5}$/;
  if (!studentIdRegex.test(studentId)) {
    alert("Student ID must be in the format 00XXX00000");
    return false;
  }

  return true;
}
</script>
<?php
    }
  }
  $conn->close();
}else{
                          echo '<div style="background-color:red;border:5px solid black;height: 60px;
    font-size: 40px;">';
                        echo "<h3 class='warning'>Events Does Not Exist</h3>";
                        echo '<div class="back-btn-2">
                            <a href="events.php">Back</a>';                    
                         echo '</div></div>';

                    }   
?>
<footer class="footer">
    <div class="footer-desc">
        <h1>More Info</h1>
    </div>
    
  	 <div class="dcontainer">
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
