<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 9/5/15
 * Time: 6:44 AM
 */
session_start();
$_SESSION['loggedin'] = false;
$_SESSION['username'] = null;
$_SESSION['name'] = null;
$_SESSION['id'] = null;
$_SESSION['token'] = null;
session_unset();
session_destroy();
header("Location: index.php");
die();
?>