<?php
if (isset($_GET['id'])) {
require_once("helper.php");
$id = $_GET['id'];
$sql = "DELETE FROM events WHERE id='$id'";
if(mysqli_query($conn,$sql)){
    session_start();
    $_SESSION["delete"] = "Events Deleted Successfully!";
    header("Location:events.php");
}else{
    die("Something wrong!");
}
}else{
    echo "Events does not exist";
}
?>