<?php
include 'configuration.php';

session_start();


?>

<!DOCTYPE html>

<html>  
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="login.css" />
    <script src="activeNavbar.js">
    </script>    
    <title>Forgor Password</title>
  </head>

  
    <body>
            <?php include '../header&footer/userHeader.php' ?>

      
      <div class="form-container">

   <form action="" method="post">
       <h4>Password is successfully changed. <a href="login.php"><span class="text-login">Login Here</span></a></h4>
      
   </form>
          
          
</div>
      
            <?php include '../header&footer/footer.php' ?>
        
            <link href="../css/login.css" rel="stylesheet" type="text/css"/>
  </body>
  
  
</html>