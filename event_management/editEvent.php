<?php
session_start();
require_once 'helper.php';
?>

<?php
            if(isset($_POST['edit']))
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
                    $id = mysqli_real_escape_string($conn, $_POST["id"]);

                    $update = "UPDATE events SET event_name = '$name', event_year = '$year', event_month = '$month', event_day = '$day',
                                event_start_time = '$time', event_category = '$category', event_desc = '$description', event_venue = '$venue',
                                ticket_price = '$price', ticket_amount = '$amount'
                               WHERE id='$id'";

                if(isset($_SESSION['admin_name']))
                {
                        if(mysqli_query($conn,$update)){
                        $_SESSION["edit"] = "Event Edited Successfully!";
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
         <script src="imageSlider.js" type="text/javascript"></script>
         <script defer src="scroll_texteffect.js" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">    
    <link href="event.css" rel="stylesheet" type="text/css"/>
    <title>Edit Events</title>
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
                
                 <?php 
            
                if (isset($_GET['id'])) {
                    include("connect.php");
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM events WHERE id=$id";
                    $result = mysqli_query($conn,$sql);
                    $row = mysqli_fetch_array($result);
                
                ?>    
                    
                <table>
                    <tr>
                        <th colspan="2">Edit Existing Event 
                            <div class="back-btn">
                                <a href="events.php">Back</a>                        
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <td class="left-column">Name:</td>
                        <td><input type="text" name="event_name" required placeholder="Enter Your Event Name" value="<?php echo $row["event_name"]; ?>"></td>
                    </tr>
                    <tr>
                        <td class="left-column">Date Organized:</td>
                        <td>
                            <input type="number" name="event_year" placeholder="YYYY"  min="2023" max="2026" value="<?php echo $row["event_year"]; ?>" required> -
                            <input type="number" name="event_month" placeholder="MM" min="1" max="12" value="<?php echo $row["event_month"]; ?>" required> -
                            <input type="number" name="event_day" placeholder="DD" min="1" max="31" value="<?php echo $row["event_day"]; ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="left-column">Event Time:</td>
                        <td><input type="time" name="event_start_time" value="<?php echo $row["event_start_time"]; ?>" required></td>
                    </tr>
                    <tr>
                        <td class="left-column">Sports Category:</td>
                        <td>
                                <select name="event_category" required>
                                <option value="">Choose Sports</option>
                                <option value="Golf" <?php if($row["event_category"]=="Golf"){echo "selected";} ?>>Golf</option>
                                <option value="Basketball" <?php if($row["event_category"]=="Golf"){echo "selected";} ?>>Basketball</option>
                                <option value="Swimming" <?php if($row["event_category"]=="Basketball"){echo "selected";} ?>>Swimming</option>
                                <option value="Running" <?php if($row["event_category"]=="Running"){echo "selected";} ?>>Running</option>
                                <option value="Volleyball" <?php if($row["event_category"]=="Volleyball"){echo "selected";} ?>>Volleyball</option>
                                <option value="Badminton" <?php if($row["event_category"]=="Badminton"){echo "selected";} ?>>Badminton</option>
                                <option value="Soccer" <?php if($row["event_category"]=="Soccer"){echo "selected";} ?>>Soccer</option>
                                <option value="Chess" <?php if($row["event_category"]=="Chess"){echo "selected";} ?>>Chess</option>
                            </select>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td class="left-column">Event Description:</td>
                        <td><textarea name="event_desc" cols="80" required placeholder="Description..."><?php echo $row["event_desc"]; ?></textarea></td>
                    </tr>
                    <tr>
                        <td class="left-column">Venue:</td>
                        <td>
                            <select name="event_venue" required>
                                <option value="">Select venue</option>
                                <option value="CA" <?php if($row["event_venue"]=="CA"){echo "selected";} ?>>CA</option>
                                <option value="Main Foyer" <?php if($row["event_venue"]=="Main Foyer"){echo "selected";} ?>>Main Foyer</option>
                                <option value="Swimming Pool" <?php if($row["event_venue"]=="Swimming Pool"){echo "selected";} ?>>Swimming Pool</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="left-column">Price Of Ticket(RM):</td>
                        <td><input type="number" name="ticket_price" placeholder="0" value="<?php echo $row["ticket_price"]; ?>" required></td>
                    </tr>
                    <tr>
                        <td class="left-column">Number of Tickets <br/> (20-50):</td>
                        <td><input type="number" name="ticket_amount" min="20" max="50" placeholder="1" value="<?php echo $row["ticket_amount"]; ?>" required></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="hidden" value="<?php echo $id; ?>" name="id">
                            <input type="submit" name="edit" value="Submit">
                            <input type="reset" name="cancel" value="Cancel">
                        </td>
                    </tr>
                </table> 
                <?php
                    }else{
                          echo '<div class="warning-back-btn">';
                        echo "<h3 class='warning'>Events Does Not Exist</h3>";
                        echo '<div class="back-btn-2">
                            <a href="events.php">Back</a>';                    
                         echo '</div></div>';

                    }   
                ?>
                    
		</form>
	</div>
    
        
                      

                    
        
    
    
    
   
  
  
  
        <?php include '../header&footer/footer.php' ?>
  </body>
  
  
</html>