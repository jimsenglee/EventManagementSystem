<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

<link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">    
        <link href="../css/nanda.css" rel="stylesheet" type="text/css"/>
    <script src="activeNavbar.js">
    </script>    
    <title>News and announcements</title>
  </head>
  
  <body>
  
              <?php
        if(isset($_SESSION["admin_name"])) {
            include '../header&footer/adminHeader.php';
        } else {
            include '../header&footer/userHeader.php';
        }
        ?>   
      
      <script>
            jQuery.noConflict();
            jQuery(document).ready(function($) {
                $(".add-comment-btn").click(function() {
                    $(".comment-form").show();
                });
            });

    </script>
      
    <!-- content -->
    <div class="news-module">
  <h2>Latest News and Announcements</h2>
  <ul>
    <li>
        <h3>New Basketball League Starting Soon</h3>
        <img src="../image/nanda2.jpg" alt="" class="nanda"/>
         <p>We're excited to announce that we'll be starting a new basketball league next month. Sign up now to join!</p>
        <span class="date">April 5, 2023</span>
        <button class="add-comment-btn">Add Comment</button>
        <div class="comment-form" style="display: none;">
            <form>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name"><br>
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment"></textarea><br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </li>
    <li>
      <h3>Dodgeball Team Wins Regional Championship</h3>
      <img src="../image/win1.jpg" alt="" class="nanda"/>
      <p>Congratulations to our dodgeball team for winning the regional championship. Next stop, nationals!</p>
      <button class="add-comment-btn">Add Comment</button>
        <div class="comment-form" style="display: none;">
            <form>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name"><br>
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment"></textarea><br>
                <input type="submit" value="Submit">
            </form>
        </div>
      <span class="date">March 28, 2023</span>
    </li>
    <li>
      <h3>Session cancelled</h3>
      <img class="nanda" src="">
      <p>We would like to inform you of some changes to our schedule for the upcoming weeks. Due to unforeseen circumstances, the session on Friday, April 15th, has been cancelled.

We apologize for any inconvenience this may cause and we hope to make it up to you in the near future.</p>
      <button class="add-comment-btn">Add Comment</button>
        <div class="comment-form" style="display: none;">
            <form>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name"><br>
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment"></textarea><br>
                <input type="submit" value="Submit">
            </form>
        </div>
      <span class="date">April 9, 2023</span>
    </li>
  </ul>
  <a href="#" class="more-news">View More News and Announcements</a>
</div>

    
        <?php include '../header&footer/footer.php' ?>

  </body>
  
  
</html>
