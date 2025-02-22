<?php
session_start();
require_once '../event_management/helper.php';

if(!isset($_SESSION['user_name'])){
   header('location:../login/login.php');
}
?>



<?php 
$filename1 = "";
$filename2 = "";
$filename3 = "";
$fullname1 = "";
$fullname2 = "";
$fullname3 = "";

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

$sports = array(
    "SM" => "Swimming",
    "RN" => "Running",
    "BB" => "Basketball",
    "VB" => "Volleyball",
    "BM" => "Badminton",
    "SC" => "Soccer",
    "GF" => "Golf",
    "CH" => "Chess",
);

$header = array(
    "result_id" => "Result ID",
    "full_name" => "Full Name",
    "score" => "Score",
    "ranking" => "Ranking",
);
?>

<!DOCTYPE html>

<html>  
    <head>
        <meta charset="UTF-8" />
        <link href="results.css" rel="stylesheet" type="text/css"/>
        <title>View Results</title>
    </head>
    
    <body>
        <?php         if(isset($_SESSION["user_name"])) {
            include '../header&footer/userHeader.php';
        } else {
            include '../header&footer/adminHeader.php';
        }
              require_once '../config/helper.php'; ?>
        
        <!-- sort & order start -->
        <?php 
        //check $sort $order to prevent SQL error
        global $sort, $order;
        if(isset($_GET['sort']) && isset($_GET['order'])){
            //determine which column to sort
            $sort = ((array_key_exists($_GET['sort'], $header)) ? $_GET['sort'] : 'ranking');
            
            //order sequence to arrange: ASC / DESC
            $order = (($_GET['order'] == 'DESC') ? 'DESC' : 'ASC');
        }
        else {
            $sort = 'ranking';
            $order = 'ASC';
        }
        ?>
        <!-- sort & order end -->
        
        <!-- retrieve top 3 start -->
        <?php 
        //get sports array $key from URL
        if(isset($_GET['cat']) && array_key_exists($_GET['cat'], $sports)){
            //if $key exists, store $value in variable
            $category = $sports[$_GET['cat']];
            
            echo "<h1 class='result-h1'>$category Results</h1>";
            
            try {
                //create DB connection
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
                //SQL to retrieve name and image of three highest score users
                $sql = "SELECT CONCAT(r.fname, ' ', r.lname) AS full_name, u.image FROM result r JOIN user_form u ON r.id = u.id WHERE category LIKE ? ORDER BY ranking";
                
                //used to prevent SQL injection attacks
                $stmt = $con->prepare($sql);
                $stmt->bind_param('s', $category);
                
                //execute query and get result
                $stmt->execute();
                $result = $stmt->get_result();
                
                //check if query was successful
                if($result && mysqli_num_rows($result) > 0){
                    //if successful， loop through $result and get name and image of the top 3 users
                    for($i = 1; $i < 4; $i++){
                        $row = mysqli_fetch_assoc($result);
                        ${"fullname".$i} = $row['full_name'];
                        ${"filename".$i} = $row['image'];
                    }
                }
                else {
                    //if failed, show error msg
                    echo "<span class='error'>No records found.</span>";
                }
                
                //free result
                mysqli_free_result($result);
                //close DB connection
                mysqli_close($con);
            } 
            catch (mysqli_sql_exception $ex) {
                echo "Connection failed: " . $ex->getMessage();
                exit;
            }
        }
        else {
            $category = "";
        }
        ?>
        <!-- retrieve top 3 end -->
        
        <?php 
        //check whether $category is set with value and is not empty string
        if(isset($category) && $category != ""){
            //if yes, display podium and all records
        ?>
        
        <!-- podium start -->
        <div class='podium'>
            <div class='winner' id='second'>
                <?php 
                printf("<img src='../login/uploaded_img/%s' alt='2nd'>
                        <p>%s</p>", $filename2, $fullname2);
                ?>
            </div>
            <div class='winner' id='first'>
                <?php 
                printf("<img src='../login/uploaded_img/%s' alt='1st'>
                        <p>%s</p>", $filename1, $fullname1);
                ?>
            </div>
            <div class='winner' id='third'>
                <?php 
                printf("<img src='../login/uploaded_img/%s' alt='3rd'>
                        <p>%s</p>", $filename3, $fullname3);
                ?>
            </div>
        </div>
        <!-- podium end -->
        
        <br>
        
        <form class='displayRecords' action ="" method="POST">
        <div class="filter">
        
        <!-- filter start -->
        <?php 
        $allSports = getAllSports();
        $count = count($allSports);
        foreach($allSports as $key => $value){
            printf("<a href='?sort=%s&order=%s&cat=%s'>%s</a>"
                   , $sort, $order, $key, $value);
            if(--$count > 0){
                echo " | ";
            }
        }
        ?>
        <!-- filter end -->
            
        </div>
        
        <br>
        <br>
        
        <!-- display all records start -->
        <?php 
        echo "<table class='viewResults'>";
        echo "<tr>";
        
        //loop to display table header
        foreach($header as $key => $value){
            if($key == $sort){
                //user clicked to perform sorting
                printf("<th><a href='?sort=%s&order=%s&cat=%s'>%s</a> %s</th>"
                        , $key
                        , $order == 'ASC' ? 'DESC' : 'ASC'
                        , $_GET['cat']
                        , $value
                        , $order == 'ASC'?'️⬆':'️⬇');
            }
            else {
                //default
                printf("<th><a href='?sort=%s&order=ASC&cat=%s'>%s</a></th>"
                        , $key
                        , $_GET['cat']
                        , $value);
            }
        }
        
        echo "</tr>";
        
        //check whether $category contains any value
        if(isset($category)){
            try {
                //create DB connection
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
                //SQL to retrieve all records + combine fname & lname
                $sql = "SELECT *, CONCAT(r.fname, ' ', r.lname) AS full_name FROM result r JOIN user_form u ON r.id = u.id WHERE category = ? ORDER BY $sort $order";
                
                //used to prevent SQL injection attacks
                $stmt = $con->prepare($sql);
                $stmt->bind_param('s', $category);
                
                //execute query
                $stmt->execute();
                $result = $stmt->get_result();
                
                //check if DB connection was successful
                if(!$con){
                    //if failed, show error msg
                    echo "<tr><td colspan='4'><span class='error'>Error: Could not connect to database.</span></td></tr>";
                }
                //check if query was successful
                else if(!$stmt){
                    //if failed, show error msg 
                    echo "<tr><td colspan='4'><span class='error'>Error executing query: " . mysqli_error($con) . "</span></td></tr>";
                }
                //check if any records found
                else if($result && mysqli_num_rows($result) > 0){
                    //if yes, retrieve and display records until none left
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        
                        printf("<td>%d</td>
                                <td>%s</td>
                                <td>%d</td>
                                <td>%d</td>"
                                , $row['result_id']
                                , $row['full_name']
                                , $row['score']
                                , $row['ranking']);
                        
                        echo "</tr>";
                    }
                }
                else {
                    //if no records found, show msg
                    echo "<tr><td colspan='4'><span class='error'>No records found.</span></td></tr>";
                }
                
                //free result
                mysqli_free_result($result);
                //close DB connection
                mysqli_close($con);
            } 
            catch (mysqli_sql_exception $ex) {
                echo "<tr><td colspan='4'><span class='error'>Error: " . $ex->getMessage() . "</span></td></tr>";
            }
        }
        
        echo "</table>";
        ?>
        <!-- display all records end -->
        
        <?php
        }
        else {
            //if no, show error msg
            echo "<span class='error'>Category is not set. [ <a href='results.php'>Back</a> ]</span>";
        }
        ?>
        
        </form>
        
        <?php include '../header&footer/footer.php' ?>
    </body>
</html>