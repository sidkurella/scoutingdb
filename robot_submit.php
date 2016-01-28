<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 9/5/15
 * Time: 2:40 AM
 */
session_start();
include('dbconnect.php');
if(!isset($_SESSION['id']) || $_SESSION['loggedin'] === false){
    header("Location: index.php?".http_build_query(array(
            'notloggedin' => "true"
        )));
    die();
}
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $game = $_POST['game'];
    //$memberlimit = $_POST['memberlimit'];
    $memberlimit = 0;
    $locx = $_POST['locx'];
    $locy = $_POST['locy'];
    $name = $_POST['name'];
    $skill = $_POST['skill'];
    $skill--;
    //$privacy = $_POST['privacy'];
    $privacy = "open";
    $posters = $_POST['posters'];
    $timetoexpire = $_POST['timetoexpire'];
    $timetoexpire = $timetoexpire * 3600;
    $ownerid = $_SESSION['id'];
    $set_id = $conn->prepare("SET @g=LEFT(UUID(), 10)");
    $set_id->execute();
    $insert_group = $conn->prepare("INSERT INTO groups VALUES (@g, :game, :memberlimit, POINT(:locx, :locy), :groupname, :skill, :privacy, :posters, FROM_UNIXTIME(UNIX_TIMESTAMP(CURRENT_TIMESTAMP()) + :timetoexpire), CURRENT_TIMESTAMP(), :ownerid)");
    $insert_group->bindParam(":game", $game);
    $insert_group->bindParam(":memberlimit", $memberlimit);
    $insert_group->bindParam(":locx", $locx);
    $insert_group->bindParam(":locy", $locy);
    $insert_group->bindParam(":groupname", $name);
    $insert_group->bindParam(":skill", $skill);
    $insert_group->bindParam(":privacy", $privacy);
    $insert_group->bindParam(":posters", $posters);
    $insert_group->bindParam(":timetoexpire", $timetoexpire);
    $insert_group->bindParam(":ownerid", $ownerid);
    $insert_group->execute();
    $add_self_to_group = $conn->prepare("INSERT INTO groupmembers VALUES(:ownerid, @g)");
    $add_self_to_group->bindParam(":ownerid", $ownerid);
    $add_self_to_group->execute();
} catch(PDOException $e) {
    if($_POST['robottype'] === 'preload') {
        header("Location: preload.php?" . http_build_query(array(
                "dberror" => "true"
            )));
    } else if($_POST['robottype'] === 'field'){
        header("Location: field.php?" . http_build_query(array(
                "dberror" => "true"
            )));
    } else {
        header("Location: index.php?" . http_build_query(array(
                "dberror" => "true"
            )));

    }
}
?>