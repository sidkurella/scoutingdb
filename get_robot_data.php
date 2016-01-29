<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 9/5/15
 * Time: 8:00 AM
 */
session_start();
include("dbconnect.php");
if(!isset($_SESSION['id']) || $_SESSION['loggedin'] === false){
    header("Location: index.php?".http_build_query(array(
            'notloggedin' => "true"
        )));
    die();
}

try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $teamnum = $_GET['teamnum'];
    $teamnum = htmlspecialchars(mb_strtoupper($teamnum));
    $select_group = $conn->prepare("SELECT teamnum AS teamnumber,
teamname,
schoolname AS teamschool,
robottype,
shootertype,
shooterdist,
shooterspd AS shooterspeed,
shooterpos AS shooterpositions,
shooterballsshot,
shooterballshit,
drivespeed,
drivepushingpwr AS drivepushingpower,
drivemaneuverability,
intakespeed,
intakeconsistency,
intakecapacity,
liftlow,
lifthigh,
liftmaxweight,
liftspeed,
liftreliability,
robotheight,
robotshooterheight,
robotweight,
robotbuildquality,
autonpointsscored,
autonpointsattempted,
autonreliability,
driverskill,
driverstrategy,
driverruleknowledge,
qualifiersmatchesplayed,
qualifierswp,
qualifierssp,
skillsrobot AS skillsdriver,
skillsprogramming AS skillsprog,
notes AS message
FROM robots WHERE teamnum=:teamnum;");
    $select_group->bindParam(":teamnum", $teamnum);
    $select_group->execute();
    $select_group->setFetchMode(PDO::FETCH_ASSOC);
    $results = $select_group->fetchAll();
    echo json_encode($results[0]);
} catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}
?>