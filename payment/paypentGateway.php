<html>


<head>


    <link href="paymentGateway.css" rel="stylesheet" type="text/css"/>

<title>Payment</title>
</head>
<body>
     <?php
     $eventCategory = $_GET['eventCategory'];
     $totalPrice = $_GET['totalPrice'];
     $selectedSeats = $_GET['selectedSeats'];
     $seat1=$_GET['seat1'];
     
     
     
     
     
    
if(!empty($_POST)){
require_once'paymentValidation.php';
$name =trim($_POST["name"]);
$nameErr["name"]=checkName($name);
// Validate email field

$email=trim($_POST["email"]);
$emailErr["email"]=checkEmail($email);
        
$pnumber=trim($_POST["pnumber"]);      
$pErr["pnumber"]=checkPhone($pnumber);

$nameoc=trim($_POST["nameoc"]);
$nameocErr["nameoc"]= checkCard($nameoc);

$cnum=trim($_POST["cnum"]);
$cnumErr["cnum"]= checkNum($cnum);

$expm=trim($_POST["expm"]);
$expmErr["expm"]= checkExpm($expm);

 $expy=trim($_POST["expy"]);
        $expyErr["expy"]= checkExpy($expy);
        
        $cvv=trim($_POST["cvv"]);
        $cvvErr ["cvv"]= checkCvv($cvv) ;
}


?>
    
    <div class="container">
<form method="POST" action="<?php if(!empty($_POST)&&  empty($nameErr)&&empty($emailErr)&&empty($pErr)&&empty($nameocErr)&&empty($cnumErr)&&empty($expmErr)&&empty($expyErr)&&empty($cvvErr)) {echo "ticDetail.php";}?>" >

<div class="row">

    <div class="col">

        <h3 class="title">Personal Detail</h3>

       <div class="inputbox">
                    <span>Name</span>
                    <input type="text" name="name" placeholder="Lim ah lin">
                     <?php
                     if(!empty($_POST)){
                     $nameErr =array_filter($nameErr);
                     
            //check if  $error contains any msg
            if(empty($nameErr)){
                //no error
                //continue to insert record
                
            }else{
                foreach($nameErr as $value){
                    echo  "<span class='error'> $value</span>";
                   
                }
            }
                     }
?>

                     </div>

        <div class="inputbox">
            <span>Email</span>
            <input type="email" name="email" value=" " placeholder="example@example.com">
            <?php
            
                     if(!empty($_POST)){
                     $emailErr =array_filter($emailErr);
            //check if  $error contains any msg
            if(empty($emailErr)){
                //no error
                //continue to insert record
                
            }else{
                foreach($emailErr as $value){
                    echo  "<span class='error'> $value</span>";
                }
            }
                     }
?>
        </div>

        <div class="inputbox">
            <span>Mobile Number</span>
            <input type="text" name="pnumber" placeholder="0123456789">
            <?php
                     if(!empty($_POST)){
                     $pErr =array_filter($pErr);
            //check if  $error contains any msg
            if(empty($pErr)){
                //no error
                //continue to insert record
                
            }else{
                foreach($pErr as $value){
                    echo  "<span class='error'> $value</span>";
                }
            }
                     }
?>
        </div>

        

        <div class="flex">
        
    </div>

</div>

<div class="col">

    <h3 class="title">payment</h3>

    <div class="inputbox">
        <span>card accepted</span>
        <img src="../lsimage/visa.jpg" alt=""/>
   </div>
    

    <div class="inputbox">
        <span>Name on card</span>
        <input type="text" name="nameoc" placeholder="LIM AH LIN">
        <?php
                     if(!empty($_POST)){
                     $nameocErr =array_filter($nameocErr);
            //check if  $error contains any msg
            if(empty($nameocErr)){
                //no error
                //continue to insert record
                
            }else{
                foreach($nameocErr as $value){
                     echo  "<span class='error'> $value</span>";
                }
            }
                     }
?>
    </div>

    <div class="inputBox">
        <span> card number :</span>
        <input type="text"name="cnum" placeholder="1234-5678-1234-5678">    
        <?php
                     if(!empty($_POST)){
                     $cnumErr =array_filter($cnumErr);
            //check if  $error contains any msg
            if(empty($cnumErr)){
                
                
            }else{
                foreach($cnumErr as $value){
                 echo  "<span class='error'> $value</span>";
                }
            }
                     }
?>
    </div>
    <div class="inputBox">
        <span>exp month :</span>
        <input type="text"name="expm" placeholder="January">
        <?php
                     if(!empty($_POST)){
                     $expmErr =array_filter($expmErr);
            //check if  $error contains any msg
            if(empty($expmErr)){
                //no error
                //continue to insert record
                
            }else{
                foreach($expmErr as $value){
                     echo  "<span class='error'> $value</span>";
                }
            }
                     }
?>
    </div>

    <div class="flex">
        <div class="inputBox">
            <span>exp year :</span>
            <input type="text"name="expy" placeholder="2022">
            <?php
                     if(!empty($_POST)){
                     $expyErr =array_filter($expyErr);
            //check if  $error contains any msg
            if(empty($expyErr)){
                //no error
                //continue to insert record
                
            }else{
                foreach($expyErr as $value){
                     echo  "<span class='error'> $value</span>";
                }
            }
                     }
?>
        </div>
        <div class="inputBox">
            <span>CVV :</span>
            <input type="text" name="cvv"placeholder="123">
            <?php
                     if(!empty($_POST)){
                     $cvvErr =array_filter($cvvErr);
            //check if  $error contains any msg
            if(empty($cvvErr)){
                //no error
                //continue to insert record
                
            }else{
                foreach($cvvErr as $value){
                    echo  "<span class='error'> $value</span>";
                }
            }
                     }
                     
?>
     <?php
if (!empty($_POST) && empty(array_filter($nameErr)) && empty(array_filter($emailErr)) && empty(array_filter($pErr)) && empty(array_filter($nameocErr)) && empty(array_filter($cnumErr)) && empty(array_filter($expmErr)) && empty(array_filter($expyErr)) && empty(array_filter($cvvErr))) {
  header("Location: paycomfirm.php?eventCategory=".urlencode($eventCategory)."&selectedSeats=".urlencode($selectedSeats)."&totalPrice=".urlencode($totalPrice)."&nameoc=".urlencode($nameoc)."&seat1=".urlencode($seat1));
    exit();
}
?>
        </div>
    </div>

</div>

</div>


<div>
    <input type="hidden" name="eventCategory" value="ticket(\'<?php echo $eventCategory; ?> tournament\)">
<input type="submit" value="place order" class="button" id="submit-btn">
<input type="button" value="HomePage" name="btnCancel" onclick="location='../homePage/home.php'" />
</div>
   

</form>

</div>    

</body>
</html>