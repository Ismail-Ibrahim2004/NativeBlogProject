<?php
session_start();
require_once('../../classes.php');
$user = unserialize($_SESSION['user']);
$user->Delete_Account($_REQUEST['user_id']);
header("Location:home.php?msg=account_deleted");