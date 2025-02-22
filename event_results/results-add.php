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
        <meta charset="UTF-8">
        <link href="results.css" rel="stylesheet" type="text/css"/>
        <title>Add Event Results</title>
    </head>
    <body>
<?php
        if(isset($_SESSION["admin_name"])) {
            include '../header&footer/adminHeader.php';
        } else {
            include '../header&footer/userHeader.php';
        }
                require_once '../config/helper.php'; ?>
        
        <h1 class="result-h1">Add Event Results</h1>
        
        <?php 
        if(!empty($_POST)){
            (isset($_POST['txtID'])) ? $result_id = $_POST['txtID'] : $result_id = "";
            (isset($_POST['txtUserID'])) ? $user_id = $_POST['txtUserID'] : $user_id = "";
            (isset($_POST['txtFName'])) ? $fname = $_POST['txtFName'] : $fname = "";
            (isset($_POST['txtLName'])) ? $lname = $_POST['txtLName'] : $lname = "";
            (isset($_POST['ddlCategory'])) ? $category = $_POST['ddlCategory'] : $category = "";
            (isset($_POST['txtScore'])) ? $score = $_POST['txtScore'] : $score = "";
            (isset($_POST['txtRanking'])) ? $ranking = $_POST['txtRanking'] : $ranking = "";
            
            try {
                //create DB connection
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                //SQL to delete record
                $sql = "INSERT INTO result(result_id, id, fname, lname, category, score, ranking) VALUES (?,?,?,?,?,?,?)";

                //used to prevent SQL injection attacks
                $stmt = $con->prepare($sql);
                $stmt->bind_param('ddsssdd', $result_id, $user_id, $fname, $lname, $category, $score, $ranking);

                //execute query
                $stmt->execute();
                
                if ($stmt->affected_rows > 0) {
                    echo "<div class='success'>Record added successfully. [ <a href='results-management.php'>Back</a> ]</div>";
                } 
                else {
                    echo "<div class='error'>Error adding record. [ <a href='results-management.php'>Back</a> ]</div>";
                }
            }
            catch (mysqli_sql_exception $ex) {
                echo "<div class='error'>Error: " . $ex->getMessage() . "</div>";
            }
        }
        ?>
        
        <div class="addForm">
            <form action="" method="POST">
                <table class="addResults">
                <tr>
                    <td>Result ID : </td>
                    <td><input type="text" name="txtID" value="" /></td>
                </tr>
                <tr>
                    <td>User ID : </td>
                    <td><input type="text" name="txtUserID" value="" /></td>
                </tr>
                <tr>
                    <td>First Name : </td>
                    <td><input type="text" name="txtFName" value="" /></td>
                </tr>
                <tr>
                    <td>Last Name : </td>
                    <td><input type="text" name="txtLName" value="" /></td>
                </tr>
                <tr>
                    <td>Category : </td>
                    <td><select name="ddlCategory">
                        <?php 
                        $allSports = getAllSports(); //array
                        foreach ($allSports as $key => $value){
                            printf("<option value='%s' %s>%s</option>"
                                        , $value, ($category == $value) ? "selected" : "", $value);
                        }
                        ?>
                        </select></td>
                </tr>
                <tr>
                    <td>Score : </td>
                    <td><input type="text" name="txtScore" value="" /></td>
                </tr>
                <tr>
                    <td>Ranking : </td>
                    <td><input type="text" name="txtRanking" value="" /></td>
                </tr>
                <tr>
                    <td colspan = '2'>
                        <input type="submit" value="Add" name="btnAdd" />
                        <input type="button" value="Back" name="btnBack" onclick="goBack()"/>
                    </td>
                </tr>
                </table>
            </form>
        </div>    
        
        <?php include '../header&footer/footer.php'; ?>
        
        <script>
        function goBack(){
            window.history.back();
        }
        </script>
        
    </body>
</html>
