<?php
session_start();
require_once '../event_management/helper.php';

if(!isset($_SESSION['admin_name'])){
   header('location:../login/login.php');
}
?>




<?php 
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


?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="results.css" rel="stylesheet" type="text/css"/>
        <title>Delete Results</title>
    </head>
    <body>
    <?php
        if(isset($_SESSION["admin_name"])) {
            include '../header&footer/adminHeader.php';
        } else {
            include '../header&footer/userHeader.php';
        }
                require_once '../config/helper.php'; ?>
        
        <h1 class='result-h1'>Delete Results</h1>
        
        <?php
        if(isset($_GET['id'])){
            //if $key exists, store $value in variable
            $id = $_GET['id'];
        }
        else {
            $id = "";
        }
        
        global $hideForm;
        //check whether $id contains any value
        if(isset($id)){
            try {
                //create DB connection
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
                //SQL to retrieve all records
                $sql = "SELECT * FROM result r JOIN user_form u ON r.id = u.id WHERE result_id = ?";
                
                //used to prevent SQL injection attacks
                $stmt = $con->prepare($sql);
                $stmt->bind_param('d', $id);
                
                //execute query
                $stmt->execute();
                $result = $stmt->get_result();
                
                //check if DB connection was successful
                if(!$con){
                    //if failed, show error msg
                    echo "<div class='error'>Error: Could not connect to database. [ <a href='results-management.php'>Back</a> ]</div>";
                }
                //check if query was successful
                else if(!$stmt){
                    //if failed, show error msg 
                    echo "<div class='error'>Error executing query: " . mysqli_error($con) . " [ <a href='results-management.php'>Back</a> ]</div>";
                }
                //check if any records found
                else if($result && mysqli_num_rows($result) > 0){
                    if($row = mysqli_fetch_assoc($result)){
                        //record found
                        $result_id = $row['result_id'];
                        $user_id = $row['id'];
                        $fname = $row['fname'];
                        $lname = $row['lname'];
                        $category = $row['category'];
                        $score = $row['score'];
                        $ranking = $row['ranking'];
                    }
                    else {
                        //record not found
                        echo "<div class='error>Record not found. [ <a href='result-management.php'>Back</a> ]</div>";
                        
                        $hideForm = true;
                    }
                }
                
                //free result
                mysqli_free_result($result);
                //close DB connection
                mysqli_close($con);
            } 
            catch (mysqli_sql_exception $ex) {
                echo "<div class='error'>Error: " . $ex->getMessage() . " [ <a href='results-management.php'>Back</a> ]</div>";
            }
        }
        else {
            //if no, show error msg
            echo "<div class='error'>Result ID is not set. [ <a href='results-management.php'>Back</a> ]</div>";
        }
        ?>
        
        <?php if($hideForm == false) : ?>
        <div class="deleteForm">
        <form action="" method="POST">
            <p>Are you sure to delete this record?</p>
            <table class="deleteResults">
                <tr>
                    <td>Result ID :</td>
                    <td><?php echo $result_id; ?>
                        <input type="hidden" name="hdID" value="<?php echo $result_id; ?>"</td>
                </tr>
                
                <tr>
                    <td>User ID :</td>
                    <td><?php echo $user_id; ?></td>
                </tr>
                
                <tr>
                    <td>First Name :</td>
                    <td><?php echo $fname; ?></td>
                </tr>
                
                <tr>
                    <td>Last Name :</td>
                    <td><?php echo $lname; ?></td>
                </tr>
                
                <tr>
                    <td>Category :</td>
                    <td><?php echo $category; ?></td>
                </tr>
                
                <tr>
                    <td>Score :</td>
                    <td><?php echo $score; ?></td>
                </tr>
                
                <tr>
                    <td>Ranking :</td>
                    <td><?php echo $ranking; ?></td>
                </tr>
                <tr>
                    <td colspan = '2'>
                        <input type="submit" value="Confirm" name="btnConfirm" />
                        <input type="button" value="Back" name="btnBack" onclick="goBack()"/>
                    </td>
                </tr>
            </table>
        </form>
            
        <?php
        //check whether confirm button is clicked
        if (isset($_POST['btnConfirm'])) {
            
            $id = $_POST['hdID'];

            try {
                //create DB connection
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                //SQL to delete record
                $sql = "DELETE FROM result WHERE result_id = ?";

                //used to prevent SQL injection attacks
                $stmt = $con->prepare($sql);
                $stmt->bind_param('d', $id);

                //execute query
                $stmt->execute();
                
                if ($stmt->affected_rows > 0) {
                    echo "<div class='success'>Record deleted successfully. [ <a href='results-management.php'>Back</a> ]</div>";
                } 
                else {
                    echo "<div class='error'>Error deleting record. [ <a href='results-management.php'>Back</a> ]</div>";
                }

                //close DB connection
                mysqli_close($con);
            } 
            catch (mysqli_sql_exception $ex) {
                echo "<div class='error'>Error: " . $ex->getMessage() . "</div>";
            }
        }
        ?>

            
        </div>
        <?php endif; ?>
        
        <?php include '../header&footer/footer.php'; ?>
        
        <script>
        function goBack(){
            window.history.back();
        }
        </script>
        
    </body>
</html>
