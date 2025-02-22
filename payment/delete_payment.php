

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

<?php

// Retrieve parameters from helper.php and define database connection variables
require_once '../config/helper.php';

// Check if the payaid parameter is set
if (isset($_GET['payaid'])) {
  $payaid = $_GET['payaid'];
  
  // Create a new database connection
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  
  // Check if the connection was successful
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  // Prepare the SQL statement to delete the specified row
  $sql = "DELETE FROM payreca WHERE payaid = $payaid";
  
  // Execute the SQL statement
  if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
  } else {
    echo "Error deleting record: " . $conn->error;
  }
  
  // Close the database connection
  $conn->close();
} else {
  echo "No payaid parameter specified";
}
