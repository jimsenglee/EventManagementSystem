<?php
session_start();
require_once '../event_management/helper.php';

if(!isset($_SESSION['admin_name'])){
   header('location:../login/login.php');
}
?>









<?php 
function getAllSports(){
    return array(
        "SM" => "Swimming",
        "RN" => "Running",
        "BB" => "Basketball",
        "VB" => "Volleyball",
        "BM" => "Badminton",
        "SC" => "Soccer",
        "GF" => "Golf",
        "CH" => "Chess",
    );
}
?>

<!DOCTYPE html>

<html>  
    <head>
        <meta charset="UTF-8" />
        <link href="results.css" rel="stylesheet" type="text/css"/>
        <title>Event Results Management</title>
    </head>
  
    <body>
<?php
        if(isset($_SESSION["admin_name"])) {
            include '../header&footer/adminHeader.php';
        } else {
            include '../header&footer/userHeader.php';
        }
                require_once '../config/helper.php'; ?>        
        <h1 class='result-h1'>Event Results Management</h1>
        
        <div class='main-content'>
        
        <?php 
        
        $allSports = getAllSports();
        foreach($allSports as $key => $value){
            $image_path = '';
            $extension = array('png', 'jpg', 'jpeg', 'gif');
            foreach($extension as $extension){
                if(file_exists('./images/'.strtolower($value).'.'.$extension)){
                    $image_path = './images/'.strtolower($value).'.'.$extension;
                    break;
                }
            }
            if(!empty($image_path)){
                printf("<div class='icon' id='%s'>
                            <p>%s</p>
                            <a href='results-manage.php?cat=%s'>
                                <img src='%s' alt='%s Sport Image' type='image/%s'>
                            </a>
                        </div>"
                        , strtolower($value)
                        , $value
                        , $key
                        , $image_path, $value, pathinfo($image_path, PATHINFO_EXTENSION));
            }
        }
        ?>
        
        </div>
        
        <?php include '../header&footer/footer.php' ?>
    </body>
</html>
 