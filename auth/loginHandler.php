<?php
session_start();
include("../database/connection.php");

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
   
    $sql="SELECT * FROM admin WHERE AdminEmail='$email' and AdminPassword='$password'";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        session_start();
        $row=$result->fetch_assoc();
        $_SESSION['admin_id']=$row['AdminID'];
        header("Location: /LetsGO/admin/dashboard.php");
        exit();
    }
    $password=md5($password);


    // Validate User login
    $sql="SELECT * FROM user WHERE UserEmail='$email' and UserPassword='$password'";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        session_start();
        $row=$result->fetch_assoc();
        // $_SESSION['email']=$row['UserEmail'];
        $_SESSION['user_id']=$row['UserID'];
        header("Location: /LetsGO/index.php");
        exit();
    }
    // Validate Driver login
    $sql="SELECT * FROM Driver WHERE DriverEmail='$email' and DriverPassword='$password'";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        session_start();
        $row=$result->fetch_assoc();
        $_SESSION['driver_id']=$row['DriverID'];
        header("Location: /LetsGO/driver/dashboard.php");
        exit();
    }
    $message = 'Invalid email or password. Please try again.';
}
?>