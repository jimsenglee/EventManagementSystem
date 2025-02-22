<?php
session_start();
require_once 'helper.php';

if(!isset($_SESSION['admin_name'])){
   header('location:../login/login.php');
}
?>

<?php
            if(isset($_POST['addevent']))
            {
                    $name = mysqli_real_escape_string($conn, $_POST["event_name"]);
                    $year = mysqli_real_escape_string($conn, $_POST["event_year"]);
                    $month = mysqli_real_escape_string($conn, $_POST["event_month"]);
                    $day = mysqli_real_escape_string($conn, $_POST["event_day"]);
                    $time = mysqli_real_escape_string($conn, $_POST["event_start_time"]);
                    $category = mysqli_real_escape_string($conn, $_POST["event_category"]);
                    $description = mysqli_real_escape_string($conn, $_POST["event_desc"]);
                    $venue = mysqli_real_escape_string($conn, $_POST["event_venue"]);
                    $price = mysqli_real_escape_string($conn, $_POST["ticket_price"]);
                    $amount = mysqli_real_escape_string($conn, $_POST["ticket_amount"]);

                    $insert = "INSERT INTO events(event_name,event_year,event_month,event_day,event_start_time,event_category,event_desc,event_venue,ticket_price,ticket_amount) 
                             VALUES('$name','$year','$month','$day','$time','$category','$description','$venue','$price','$amount')";

                if(isset($_SESSION['admin_name']))
                {
                        if(mysqli_query($conn,$insert)){
                        $_SESSION["addevent"] = "Event Added Successfully!";
                        header("Location:events.php");

                    }else{
                        die("Unable to finish the request.");
                    }
              }

            else if(!isset($_SESSION["admin_name"])) {
                echo '<script>alert("You need to login first!")</script>';
                echo '<script>window.location.href="../homePage/home.php";</script>';
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
         <script defer src="scroll_texteffect.js" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">    
    <link href="event.css" rel="stylesheet" type="text/css"/>
    <title>Add Events</title>
  </head>
      
<body>
    
        <?php
        if(isset($_SESSION["admin_name"])) {
            include '../header&footer/adminHeader.php';
        } else {
            include '../header&footer/userHeader.php';
        }
        ?>   
    
    
         <div>
		<form action="" method="POST">
                <table>
                    <tr>
                        <th colspan="2">Add New Event 
                            <div class="back-btn">
                                <a href="events.php">Back</a>                        
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <td class="left-column">Name:</td>
                        <td><input type="text" name="event_name" required placeholder="Enter Your Event Name"></td>
                    </tr>
                    <tr>
                        <td class="left-column">Date Organized:</td>
                        <td>
                            <input type="number" name="event_year" placeholder="YYYY"  min="2023" max="2026" required> -
                            <input type="number" name="event_month" placeholder="MM" min="1" max="12" required> -
                            <input type="number" name="event_day" placeholder="DD" min="1" max="31" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="left-column">Event Time:</td>
                        <td><input type="time" name="event_start_time" required></td>
                    </tr>
                    <tr>
                        <td class="left-column">Sports Category:</td>
                        <td>
                                <select name="event_category" required>
                                <option value="" selected>Choose Sports</option>
                                <option value="Golf">Golf</option>
                                <option value="Basketball">Basketball</option>
                                <option value="Swimming">Swimming</option>
                                <option value="Running">Running</option>
                                <option value="Volleyball">Volleyball</option>
                                <option value="Badminton">Badminton</option>
                                <option value="Soccer">Soccer</option>
                                <option value="Chess">Chess</option>
                            </select>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td class="left-column">Event Description:</td>
                        <td><textarea name="event_desc" cols="80" required placeholder="Description..."></textarea></td>
                    </tr>
                    <tr>
                        <td class="left-column">Venue:</td>
                        <td>
                            <select name="event_venue" required>
                                <option value="">Select venue</option>
                                <option value="CA">CA</option>
                                <option value="Main Foyer">Main Foyer</option>
                                <option value="Swimming Pool">Swimming Pool</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="left-column">Price Of Ticket(RM):</td>
                        <td><input type="number" name="ticket_price" placeholder="0" required></td>
                    </tr>
                    <tr>
                        <td class="left-column">Number of Tickets <br/> (20-50):</td>
                        <td><input type="number" name="ticket_amount" min="20" max="50" placeholder="1" required></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" name="addevent" value="Submit">
                            <input type="reset" name="cancel" value="Cancel">
                        </td>
                    </tr>
                </table> 
		</form>
	</div>
    
        
                      

                    
        
    
    
    
   
  
  
  
        <?php include '../header&footer/footer.php' ?>
  </body>
  
  
</html>