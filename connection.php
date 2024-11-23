<?php
$conn = new mysqli("localhost","root","12345","helpdeskdatabase");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

function ConvertDate($dateString){
    $timestamp = strtotime($dateString); 
    $formattedDate = date("F d, Y h:i A", $timestamp);
    return $formattedDate;
}
?>



