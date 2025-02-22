<?php 
session_start();

if (isset($_SESSION['id']) && (isset($_SESSION['admin_name'])||isset($_SESSION['user_name']))) {

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>CHANGE PASSWORD</title>
        <link href="changepass.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php
        if(isset($_SESSION["admin_name"])) {
            include '../header&footer/adminHeader.php';
        } else {
            include '../header&footer/userHeader.php';
        }
        ?> 

    
    
    
    <form action="changeP.php" method="post">
     	<h2>CHANGE YOUR PASSWORD HERE</h2>
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>

     	<?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>

     	<label>Your Old Password</label>
        <div class="passContainer">
     	<input type="password" 
     	       name="oldPass" id="oldPass"
     	       placeholder="Old Password">
               
        <span class="span" onclick="togglePW()"> 
            <i class="fa fa-eye" id="hide1"
                aria-hidden="true"></i>
            <i class="fa fa-eye-slash" id="hide2"
                aria-hidden="true"></i>

        </span>
        </div>       
        <br>

     	<label>New Password</label>
        <div class="passContainer">     	
        <input type="password" 
     	       name="newPass" id="newPass"
     	       placeholder="New Password">
        
        <span class="span" onclick="togglePW2()"> 
            <i class="fa fa-eye" id="newhide1"
                aria-hidden="true"></i>
            <i class="fa fa-eye-slash" id="newhide2"
                aria-hidden="true"></i>

        </span>        
        </div>       
        
     	       <br>

     	<label>Confirm New Password</label>
        <div class="passContainer">     	        
     	<input type="password" 
     	       name="conPass" id="conPass"
     	       placeholder="Confirm New Password">
        
        <span class="span" onclick="togglePW3()"> 
            <i class="fa fa-eye" id="conhide1"
                aria-hidden="true"></i>
            <i class="fa fa-eye-slash" id="conhide2"
                aria-hidden="true"></i>

        </span>        
        </div>             
        
     	       <br>

     	<button type="submit">CHANGE</button>
          <a href="../homePage/home.php" class="change">HOME</a>
     </form>
    
            <?php include '../header&footer/footer.php' ?>

</body>
</html>



<script>
    function togglePW(){
    
    var x = document.getElementById("oldPass");
    var y = document.getElementById("hide1");
    var z = document.getElementById("hide2");
    
    if(x.type==='password'){
        x.type = "text";
        y.style.display = "block"; 
        z.style.display = "none"; 
    }else{
        x.type = "password";
        y.style.display = "none"; 
        z.style.display = "block";
    }   
    }
    
    
        function togglePW2(){
    
    var x = document.getElementById("newPass");
    var y = document.getElementById("newhide1");
    var z = document.getElementById("newhide2");
    
    if(x.type==='password'){
        x.type = "text";
        y.style.display = "block"; 
        z.style.display = "none"; 
    }else{
        x.type = "password";
        y.style.display = "none"; 
        z.style.display = "block";
    }   
    }
    
    
    
    
        function togglePW3(){
    
    var x = document.getElementById("conPass");
    var y = document.getElementById("conhide1");
    var z = document.getElementById("conhide2");
    
    if(x.type==='password'){
        x.type = "text";
        y.style.display = "block"; 
        z.style.display = "none"; 
    }else{
        x.type = "password";
        y.style.display = "none"; 
        z.style.display = "block";
    }   
    }

    
    
    
    
    
    
</script>

<?php 
}else{
     header("Location: login.php");
     exit();
}
 ?>