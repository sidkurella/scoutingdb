<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 9/5/15
 * Time: 2:02 AM
 */
session_start();
include("dbconnect.php");
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $login_username = $_POST['username'];
    $login_password = $_POST['password'];
    $get_hash = $conn->prepare("SELECT * FROM users WHERE username=:username");
    $get_hash->bindParam(":username", $login_username);
    $get_hash->execute();
    $results = $get_hash->setFetchMode(PDO::FETCH_ASSOC);
    $results = $get_hash->fetchAll();
    if(count($results) == 1) {
        if(password_verify($login_password, $results[0]['passwd'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $login_username;
            $_SESSION['name'] = $results[0]['name'];
            $_SESSION['id'] = $results[0]['userid'];
            header("Location: index.php");
            die();
        } else {
            header("Location: index.php?".http_build_query(array(
                    "incorrectlogin" => true
                )));
            die();
        }
    } else {
        header("Location: index.php?".http_build_query(array(
                "incorrectlogin" => true
            )));
        die();
    }
} catch(PDOException $e) {
    header("Location: index.php?".http_build_query(array(
            "dberror" => true
        )));
    die();
}
?>