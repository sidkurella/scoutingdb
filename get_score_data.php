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
    $select_group = $conn->prepare("SELECT scores.teamnum, scores.robottype, scores.totalscore, robots.teamname,
            robots.schoolname, robots.notes FROM scores INNER JOIN robots ON scores.teamnum = robots.teamnum;");
    $select_group->execute();
    $select_group->setFetchMode(PDO::FETCH_ASSOC);
    $results = $select_group->fetchAll();
    for($i=0; $i<count($results); $i++){
        $results[$i]['robottype'] = mb_convert_case($results[$i]['robottype'], MB_CASE_TITLE);
    }
    echo json_encode($results);
} catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}
?>