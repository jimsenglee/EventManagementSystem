

<!DOCTYPE html>

<html>  
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

<link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="../homePage/home.css" />
    <script src="activeNavbar.js">
    </script>    
    <title>Header</title>
  </head>
      <header>
    <div class="nav-bar">
        <div class="logo">
            <a href="../homePage/home.php"><img src="../image/logo.JPG" alt="logo"></a>
        </div>
        
      <ul>
        <li><a href="../homePage/home.php" <?php if(basename($_SERVER['PHP_SELF']) == 'home.php') echo 'class="active"'; ?>>Home</a></li>
        
        <li><a href="../merchandise/SPSmerchandise.php" <?php if(basename($_SERVER['PHP_SELF']) == 'SPSmerchandise.php') echo 'class="active"'; ?> >Merch</a></li>
        
        <li><a href="../event_results/results.php" <?php if(basename($_SERVER['PHP_SELF']) == 'pages.php') echo 'class="active"';
        ?>>Events</a>
        
        <li><a href="../payment/payRecordUser.php">Payment detail</a>

        </li>
        
        
         <?php
            if(isset($_SESSION["user_name"]))
            {
        ?>
        <li><a href="../login/user_page.php"><?php echo $_SESSION["user_name"]; ?></a></li>
        <li><a href="../login/logout.php" class="header-login-a">LOGOUT</a></li>
        <?php
            }
            else
            {
        ?>
        <li>
            <a href="../login/login.php" <?php if(basename($_SERVER['PHP_SELF']) == 'login.php') 
                echo 'class="active"'; ?> >Login/Register</a>
        </li>
        <?php	
            }
            ?>
        
        
        
        </ul>
    </div>
     </header>
  
    <body>
      <div class="btn">
         <span class="fas fa-bars"></span>
      </div>
        
      <nav class="sidebar">
         <div class="text">
            Side Menu
         </div>
         <ul>
            <li><a href="../login/user_page.php">User Profile <i class="fa-solid fa-user"></i></a></li>
            <li>
               <a class="feat-btn">Request
               <span class="fas fa-chevron-down first"></span>
               </a>
               <ul class="feat-show">
                  <li><a href="../booking/bookvenue.php">Current Venue</a></li>                  
                  <li><a href="../booking/mybooking.php">My Booking</a></li>
               </ul>
            </li>
             <li>
               <a class="serv-btn">Ticket
                <span class="fas fa-chevron-down second"></span>
               </a>
               <ul class="serv-show">
                  <li><a href="../ticket/ticket.php">Ticket</a></li>                   

                  <li><a href="#">--</a></li>
               </ul>
            </li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Feedback <i class="fa-solid fa-comment"></i></a></li>
         </ul>
      </nav>
        
        <!-- sidebar function -->
        <script>
         $('.btn').click(function(){
           $(this).toggleClass("click");
           $('.sidebar').toggleClass("show");
         });
           $('.feat-btn').click(function(){
             $('nav ul .feat-show').toggleClass("show");
             $('nav ul .first').toggleClass("rotate");
           });
           $('.serv-btn').click(function(){
             $('nav ul .serv-show').toggleClass("show1");
             $('nav ul .second').toggleClass("rotate");
           });
           $('nav ul li').click(function(){
             $(this).addClass("active").siblings().removeClass("active");
           });
      </script>
      

      
      

</div>
     </body>
     </html>