<?php
session_start();
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
    <link href="home.css" rel="stylesheet" type="text/css"/>
 
    <title>HomePage</title>
  </head>
      
<body>
    
        <?php
        if(isset($_SESSION["admin_name"])) {
            include '../header&footer/adminHeader.php';
        } else {
            include '../header&footer/userHeader.php';
        }
        ?>    
    
    <!-- Upcoming Events Slider -->
<div class="container">
  <div class="row">   
    <div class="col-md-12 text-center">
        <h1 class="animate-charcter">Upcoming Events</h1>
        <div class="star-decoration">
                <img src="../image/decoration-star.png" height="100px" width="500px">
        </div>
    </div>
        </div>
    </div>
    
    <section class="slider-background">
   <div class="carousel">
      <div class="carousel_inner">
         <div class="carousel_item carousel_item__active">
            <img src="../image/poster1.jpg" alt="" class="carousel_img">
         </div>
         <div class="carousel_item">
            <img src="../image/poster2.png" alt="" class="carousel_img"/>
         </div>
         <div class="carousel_item">
            <img src="../image/poster3.jpg" alt="" class="carousel_img">
         </div>
         <div class="carousel_item">
            <img src="../image/poster4.jpg" alt="" class="carousel_img">
         </div>          
      </div>

      <div class="carousel_indicator">
         <button class="carousel_dot carousel_dot__active"></button>
         <button class="carousel_dot"></button>
         <button class="carousel_dot"></button>
         <button class="carousel_dot"></button>
         
      </div>

      <div class="carousel_control">
         <button class="carousel_button carousel_button__prev">
            <i class="fas fa-chevron-left"></i>
         </button>
         <button class="carousel_button carousel_button__next">
            <i class="fas fa-chevron-right"></i>
         </button>
      </div>
   </div>
</section>
    
    <div class="line">
    </div>
    
    
    <!-- Sports Section -->
        
    <div class="container">
  <div class="row">   
    <div class="col-md-12 text-center">
        <h1 class="animate-charcter">Events History</h1>
        <div class="star-decoration">
                <img src="../image/decoration-star.png" height="100px" width="500px">
        </div>
    </div>
        </div>
    </div>
    
    
    
    <section class="hidden">
        <div class="content-container">
            <div class="content-column ">
              <h2>The customary group photo of TARCians before the start of the 8th Sports Challenge in main campus.</h2>
                <div>
                <img src="../image/eventHisrory1.jpg" height="300px" width="500px">
                </div>
            </div>
            <div class="content-column">
              <h2>TAR UC campus ground came alive with display of sportsmanship and teamwork from the participants in the various games.</h2>
                <div>
                <img src="../image/eventHisrory2.jpg" height="300px" width="500px">
                </div>            
            </div>
           </div>
    </section>
    
        <div class="line">
    </div>
    
       <!-- Sports Section -->
        
    <div class="container">
  <div class="row">   
    <div class="col-md-12 text-center">
        <h1 class="animate-charcter">Club House & Sports Facilities</h1>
        <div class="star-decoration">
                <img src="../image/decoration-star.png" height="100px" width="500px">
        </div>
    </div>
        </div>
    </div>
    
    
    
    <section class="hidden">
        <div class="content-container">
            <div class="content-column ">
        <ul class="facility-list">
            <li class="facility-item-bold">OUTDOOR FACILITIES</li>
            <li class="facility-item">Multipurpose Court (Basketball & Volleyball)</li>
            <li class="facility-item">Multipurpose Court (Netball, Volleyball, Handball and Basketball)</li>
            <br/>
            <li class="facility-item-bold">Opening Hours:</li>
                <ul class="hours-list">
                  <li class="hours-item">9am to 10pm (Mon-Fri)</li>
                  <li class="hours-item">9am to 7pm (Sat-Sun)</li>
                  <li class="hours-item">9am-5pm (Mon-Sun during Semester Break)</li>
                  <li class="hours-item">Closed on Public Holidays</li>
                  <li class="hours-item note">* online booking is required via intranet</li>
                </ul>
          </ul>

            </div>
            <div class="content-column">
            <ul class="facility-list">
              <li class="facility-item-bold">INDOOR FACILITIES</li>
              <li class="facility-item">Club House with Olympic-sized swimming pool, Two squash courts, Gymnasium, Games room and Table tennis</li>
              
            <br/>              
              <li class="facility-item-bold">Opening Hours:</li>
              <ul class="hours-list">
                <li class="hours-item">For swimming pool</li>
                <li class="hours-item">9am to 11am, 4pm to 7pm (Mon-Fri)</li>
                <li class="hours-item">Closed on Public Holidays & Semester Holidays</li>
                <li class="hours-item">For squash courts, gymnasium and table tennis</li>
                <li class="hours-item">9am to 7pm (Mon-Fri)</li>
                <li class="hours-item">9am to 5pm (Mon-Fri during Semester Holidays)</li>
                <li class="hours-item">Closed on Public Holidays</li>
                <li class="hours-item note">* online booking is required via intranet</li>
              </ul>
            </ul>
            </div>

            </div>
    </section>
       
       
    
          <!-- Sports Section -->
        
    
 
    
    
    
   
  
  
  
        <?php include '../header&footer/footer.php' ?>
  </body>
  
  
</html>