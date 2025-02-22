<?php 

$conn= new mysqli('localhost','root','','user_db')or die("Could not connect to database".mysqli_error($con));





//function to return all PROGRAM
function getAllVenue(){
    return array(
        "CA" => "🏢 CA",
        "Swimming Pool" => "🏊‍♂️ Swimming Pool",
        "Main Foyer" => "🏬 Main Foyer",
    );
}
?>

