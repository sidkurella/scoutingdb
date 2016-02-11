<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 9/5/15
 * Time: 2:26 AM
 */
session_start();
require_once 'vendor/mobiledetect/mobiledetectlib/Mobile_Detect.php';
$detect = new Mobile_Detect;
$failfile = "";
include("dbconnect.php");
if($detect->isMobile() && !$detect->isTablet()) {
    $failfile = "signup_page.php";
} else {
    $failfile = "index.php";
}
header("Location: $failfile?".http_build_query(array(
        "disabled" => "true"
    )));
die();
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $login_username = $_POST['username'];
    $login_password = $_POST['password'];
    $login_name = $_POST['name'];
    $login_email = $_POST['email'];
    $login_phone = $_POST['phone'];
    $register_user = $conn->prepare("SELECT * FROM users WHERE username=:username OR email=:email");
    $register_user->bindParam(":username", $login_username);
    $register_user->bindParam(":email", $login_email);
    $register_user->execute();
    $results = $register_user->setFetchMode(PDO::FETCH_ASSOC);
    $results = $register_user->fetchAll();
    if(count($results) === 0) {
        $add_user = $conn->prepare("INSERT INTO users VALUES (LEFT(UUID(), 10), :username, :passwd, CURRENT_TIMESTAMP(), :realname, :email, :phone)");
        $add_user->bindParam(":username", $login_username);
        $add_user->bindParam(":passwd", password_hash($login_password, PASSWORD_DEFAULT));
        $add_user->bindParam(":realname", $login_name);
        $add_user->bindParam(":email", $login_email);
        $add_user->bindParam(":phone", $login_phone);
        $add_user->execute();
        echo "inserted";
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $login_username;
        $_SESSION['name'] = $login_name;
        $get_id = $conn->prepare("SELECT userid FROM users WHERE username=:username");
        $get_id->bindParam(":username", $login_username);
        $get_id->execute();
        $get_id->setFetchMode(PDO::FETCH_ASSOC);
        $id = $get_id->fetchAll();
        if(count($id) == 1){
            $_SESSION['id'] = $id[0]['userid'];
        }
        if (!isset($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        } else {
            $token = $_SESSION['token'];
        }
        header("Location: $failfile?".http_build_query(array(
                "registered" => "true"
            )));
        die();
    } else {
        header("Location: $failfile?".http_build_query(array(
                "alreadyexists" => "true"
            )));
        die();
    }
} catch(PDOException $e) {
    header("Location: $failfile?".http_build_query(array(
            "dberror" => "true"
        )));
    die();
}
?>