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
  
    <link href="ticDetail.css" rel="stylesheet" type="text/css"/>
    <script src="activeNavbar.js">
    </script>    
    <title>Ticket Detail</title>
    
    
    
    <style>
  .stage {
    width: 600px;
    
    height: 200px;
    margin: 0 auto;
    
    border: 10px solid #333;
    border-radius: 20px;
    background-color: #000;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .stage h1 {
    color: #fff;
    
    text-transform: uppercase;
    letter-spacing: 5px;
  }
  .seat-map{
      margin-left:40px;
  }
  
  .seatcontainer{
    
    margin-top:150px;
    margin-left:300px;
    margin-right:300px;
    width:500px;
  
   
}
</style>

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
          <h1 style="font-size:50px; text-align: center;">ticket detail</h1>
          <div class="imgcontainer" >  
          <?php
    // Retrieve eventCategory and ticPrice values from GET request
    $eventCategory = $_GET['eventCategory'];
    $ticPrice = $_GET['ticPrice'];
    $eventVenue=$_GET['eventVenue'];
    $eventYear=$_GET['eventYear'];
    $eventMonth=$_GET['eventMonth'];
    $eventDay=$_GET['eventDay'];
    $eventTime=$_GET['eventTime'];
    $seat=$_GET['seat'];
    // Determine which image to display based on the event category
    $image = '';
    
    if ($eventCategory == 'Basketball') {
        $image = 'basketball.jpg';
    } elseif ($eventCategory == 'Badminton') {
        $image = 'babminton.jpg';
    } elseif($eventCategory =='Golf'){
        $image='goft.jpg';
    }elseif($eventCategory =='Swimming'){
        $image='swim.jpg';
    }elseif($eventCategory =='Running'){
        $image='running.jpg';
    }elseif($eventCategory =='Volleyball'){
        $image='volleyball.jpg';
    }elseif($eventCategory =='Soccer'){
        $image='football.jpg';
    }elseif($eventCategory =='Chess'){
        $image='chess.jpg';
    }
    
    echo '<img class="sport" src="../lsimage/' . $image . '" alt="' . $eventCategory . '"/>';
    ?>
          
      </div>
          <table class="detailcontainer">
              <tr>
          <td >Ticket:<?php echo "$eventCategory"?> Tournament Ticket</td></tr> 
          <tr><td >Locate:<?php echo "$eventVenue"?></td> </tr>
          <tr><td >Price per Ticket:<?php echo "$ticPrice"?></td> </tr>
          <tr><td >Date:<?php echo "$eventDay"."-"."$eventMonth"."-"."$eventYear"?></td> </tr>
          <tr><td >Time:<?php echo "$eventTime"?></td> </tr>
          </table>
          
          <div class="seatcontainer">
 <?php
 
 echo '<form method="get" id="buy-form" action="../payment/paypentGateway.php";>';
// Retrieve 4 parameters from helper.php
require_once '../config/helper.php';

// Step 2: Connect PHP app with database
// Object-oriented method
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


// Get the seat data from the badseat table
$sql = "SELECT * FROM badseat";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  
  echo '<div class="seat-map">';
  $seat_counter = 0;
  while($row = $result->fetch_assoc()) {
    if ($seat_counter % 10 == 0) {
      echo '<div class="srow">';
    }
    if ($seat_counter < $seat) {
      if ($row["status"] == "valid") {
        echo '<div class="seat" onclick="selectSeat('.$row["seatNum"].')">';
        echo '<input type="checkbox" style="display:none;" id="seat_'.$row["seatNum"].'" name="seat1" value="'.$row["seatNum"].'">';
        echo '<label for="seat_'.$row["seatNum"].'"></label>';
        echo '</div>';
      } else {
        echo '<div class="seat sold"></div>';
      }
    } 
    $seat_counter++;
    if ($seat_counter % 10 == 0) {
      echo '</div>';
    }
  }
  if ($seat_counter % 10 != 0) {
    echo '</div>';
  }
  echo '</div>';
  
} else {
  echo "No seats available.";
}

// Close the database connection
$conn->close();


echo'</div>';
echo'<div class="stage">
  <h1>Competition Stage</h1>
</div>
</br>
<p class="cost">
  You have selected <span id="count">0</span> seat for a price of RM.<span id="total">0</span>
</p>';
   
      echo '<input type="hidden" name="eventCategory" value="ticket(' . $eventCategory . ' tournament)">';
  echo' <input type="hidden" id="selectedSeatsInput" name="selectedSeats" value="0">';
  echo'<input type="hidden" id="totalPriceInput" name="totalPrice" value="0">';

      
echo' <input type="submit" value="Buy" name="buy" style="width: 100px; font-size: 30px; margin-left:30px; " />';
  echo '</form>';
echo"  </div>";
?>
    

             
   <script>
   // Get all the seats
  const seats = document.querySelectorAll('.seat');

  // Get the elements that display the count, price and total price
  const count = document.getElementById('count');
  const price = document.getElementById('price');
  const total = document.getElementById('total');

  // Set the initial values for the selected seats and the price
  let selectedSeats = 0;
  let seatPrice = <?php echo $ticPrice; ?>;

  // Add a click event listener to each seat
  seats.forEach((seat) => {
    seat.addEventListener('click', () => {
      // Check if the seat is not already sold and not already selected
      if (!seat.classList.contains('sold') && !seat.classList.contains('selected')) {
        // Add the 'selected' class to the seat
        seat.classList.add('selected');
        // Increase the selectedSeats counter and update the count display
        selectedSeats++;
        count.textContent = selectedSeats;
        // Update the total price display
        total.textContent = seatPrice * selectedSeats;
      } else if (seat.classList.contains('selected')) {
        // If the seat is already selected, remove the 'selected' class from the seat
        seat.classList.remove('selected');
        // Decrease the selectedSeats counter and update the count display
        selectedSeats--;
        count.textContent = selectedSeats;
        // Update the total price display
        total.textContent = seatPrice * selectedSeats;
      }
      // Update the hidden input fields with the latest selected seats and total price
      document.getElementById('selectedSeatsInput').value = selectedSeats;
      document.getElementById('totalPriceInput').value = seatPrice * selectedSeats;
    });
  });
  function selectSeat(seatNum) {
  var checkbox = document.getElementById("seat_" + seatNum);
  checkbox.checked = !checkbox.checked;
}
  
</script>




      </div>
        
      
                   <?php include '../header&footer/footer.php' ?>

  </body>
  
  
</html>
