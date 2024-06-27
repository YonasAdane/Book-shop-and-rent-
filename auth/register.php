<?php 
include '../database/connection.php';
session_start();
if(isset($_POST['signUp'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $password=$_POST['password'];
    $password=md5($password);
    $checkEmail="SELECT * FROM user WHERE UserEmail='$email'";
    $result=$conn->query($checkEmail);
    if($result->num_rows>0){
        echo "Email Address Already Exists!";
    }
    else{
        // INSERT INTO `admin`(`AdminEmail`,`AdminName`,`AdminPassword`) VALUES('admin@gmail.com','root','123456');
        $insertQuery="INSERT INTO user(UserName,UserEmail,UserPhone,UserPassword) 
        VALUES ('$name','$email','$phone','$password') ";
        if($conn->query($insertQuery)==TRUE){
            // $_SESSION["email"]=$email;
            header("location: login.php");
        }else{
            echo "Error:". $conn->error;
        }
    }
}

if(isset($_GET["logout"])){
    session_destroy();
    header("location: login.php");
}
?>