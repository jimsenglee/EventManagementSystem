<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

function checkName($name){
    if($name==null){
        return "please enter your <b>Name</b>";
    }else if(strlen($name)>30){
        return "your <b>Name</b> exceeed 30 charaters.";
    }else if(!preg_match('/^[A-Za-z @,\.\'\/]+$/',$name)){
        return "invalid name";
    }
    
}

function checkEmail($email){
    if($email==null){
        return "please enter your <b>Email</b>";
    }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       return "Invalid email format";
    }
}

function checkPhone($pnumber){
    if ($pnumber==null) {
    return "Please enter your <b>Phone Number</b> ";
  }if (!preg_match("/^[0-9]*$/",$pnumber)) {
      return "Only numbers allowed";
}
}

function checkCard($nameoc){
    if ($nameoc==null) {
    return "Please enter your <b>NAME ON CARD</b> ";
}else if(!preg_match('/^[A-Za-z @,\.\'\/]+$/',$nameoc)){
        return "invalid name";
    }
    
}

function checkNum($cnum){
    if ($cnum==null) {
    return "Please enter your <b>CARD NUMBER</b> ";
}else if (!preg_match("/^[0-9-]*$/",$cnum)) {
      return "Only numbers and dashes allowed";
    }
  }
  
  function checkExpm($expm){
       if ($expm==null) {
    return "Please enter your card <b>EXPIRED MONTH</b> ";
  }else
      
  
  if (!preg_match("/^[a-zA-Z ]*$/",$expm)) {
        return 'Invalid month format';
    }
  }

  function checkExpy($expy){
       if ($expy==null) {
    return "Please enter your card <b>EXPIRED YEAR</b> ";
  }else
      
  if (!preg_match("/^[0-9]*$/",$expy)) {
        return 'Invalid month format';
    }
  }
  
  function checkCvv($cvv){
       if ($cvv==null) {
    return "Please enter your card <b>CVV</b> ";
  }else if
       (!preg_match("/^[0-9]*$/",$cvv)) {
      $cvvErr = "Only digits allowed";
  }
  }