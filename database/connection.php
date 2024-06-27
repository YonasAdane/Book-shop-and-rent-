<?php 
$host="localhost";
$user="root";
$password="yonas@calculus";
$db="letsgov1";
$conn=new mysqli($host,$user,$password,$db);
if($conn->connect_error){
    echo "Failed to connect DB". $conn->connect_error;
}
?>