<?php
session_start();
require_once('../../classes.php');
$user = unserialize($_SESSION["user"]);
if (!empty($_REQUEST["comment"])) {
    $user->store_comment($_REQUEST["comment"],$_REQUEST["post_id"],$user->id);
    header("Location: profile.php?msg=cas");    
}else {
    header("Location: profile.php?msg=required_comment");
}