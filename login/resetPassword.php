<?php include 'resetP.php' ?>


<!DOCTYPE html>
<html>
<head>
	<title>CHANGE PASSWORD</title>
        <link href="changepass.css" rel="stylesheet" type="text/css"/>
</head>
<body>
                <?php include '../header&footer/userHeader.php' ?>


    
    
    
    <form method="post">
     	<h2>CHANGE YOUR PASSWORD HERE</h2>
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>

     	<?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
            
                   
            
        <label>Email</label>       
    
        <div class="passContainer">          
            
        <input type="email" 
     	       name="email" id="email"
     	       placeholder="Email">  

        
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

               <div class="form-group">
       <input type="submit" id="login" name="resetPass" value="Reset" class="reset-btn" />
       </div>
               
          <a href="../homePage/home.php" class="change">HOME</a>

     </form>
    
    
    <script>
    
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
    
    
    
</body>
</html>




