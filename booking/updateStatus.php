<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require_once '../config/helper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Step 2: Connect PHP app with database
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // Step 3: Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Step 4: Prepare and execute SQL statement
  $bookid = $_POST['bookid'];
  $status = $_POST['status'];
  
  $stmt = $conn->prepare('UPDATE booking SET status=? WHERE bookid=?');
  $stmt->bind_param('ss', $status, $bookid);
  $stmt->execute();
  
  // Step 5: Close statement and database connection
  $stmt->close();
  $conn->close();

  // Step 6: Redirect to previous page
  header('Location: ' . $_SERVER['HTTP_REFERER']);
  exit();
}
?>