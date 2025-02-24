<?php
session_start();
$errors = [];
if(empty($_REQUEST["name"])) $errors["name"] = "Name is required";
if(empty($_REQUEST["email"])) $errors["email"] = "Email is required";
if(empty($_REQUEST["Phone"])) $errors["Phone"] = "Phone is required";
if (empty($_REQUEST["pw"]) || empty($_REQUEST["pc"]))
{
    $errors["pw"] = "Password And Password confirmation is required";
} elseif($_REQUEST["pw"] != $_REQUEST["pc"]){
    $errors["pc"] = "Password confirmation must be equal to Password";
}


$name = htmlspecialchars(trim( $_REQUEST["name"]));
$email = filter_var($_REQUEST["email"], FILTER_SANITIZE_EMAIL);
$Phone = htmlspecialchars($_REQUEST["Phone"]);
$password = htmlspecialchars( $_REQUEST["pw"]);
$password_confirmation = htmlspecialchars($_REQUEST["pc"]);

if(!preg_match("/^[0-9]{10,15}$/", $Phone)) {
    $errors["Phone"] = "Phone number must be valid";
}


// if(filter_var($_REQUEST["name"], FILTER_VALIDATE_INT)){}  
if(  !empty($_REQUEST["email"])  && !filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) $errors["email"] = "Email must be valid";

if(empty($errors)){
    require_once('classes.php');
    try{
        $rslt = Subscriber::register($name, $email, $Phone, md5($password));
        header("Location: index.php?msg=sr");
    }catch(\Throwable $th){
        header("Location: register.php?msg=ar");
    }




}else{
    $_SESSION["errors"] = $errors;
    header("Location: register.php");
}