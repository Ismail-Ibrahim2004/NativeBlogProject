<?php
session_start();
// var_dump($_REQUEST);
if(!empty($_REQUEST["email"]) || !empty($_REQUEST["password"])){
    // filteration
    require_once('classes.php');
    $user = User::login($_REQUEST["email"],md5( $_REQUEST["password"]));

    if (!empty($user)) {
        $_SESSION["user"] = serialize($user);
        if ($user->role == "Admin") {
            header("Location:frontend/admin/home.php");
        }elseif ($user->role == "subscriber") {
            header("Location:frontend/subscriber/Home.php");
        }
        
    }else{
        header("Location: index.php?msg=no_user");
    }


}else{
    header("Location: index.php?msg=empty_field");
}