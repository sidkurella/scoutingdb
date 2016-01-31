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

function constrain($amt, $low, $high){
    if($amt < $low || $amt === null){
        $amt = $low;
    } else if($amt > $high){
        $amt = $high;
    }
    return $amt;
}

function nonneg($amt){
    if($amt < 0 || $amt === null){
        $amt = 0;
    }
    return $amt;
}

function validate_form_data(array $data):array {
    //Team Information validation
    $data['teamnum'] = mb_strtoupper($data['teamnum'], "UTF-8");
    $data['teamnum'] = htmlspecialchars($data['teamnum']);
    $data['teamname'] = htmlspecialchars($data['teamname']);
    $data['teamschool'] = htmlspecialchars($data['teamschool']);
    if($data['robottype'] !== "preload" && $data['robottype'] !== "field"){
        throw new PDOException();
    }

    //Shooter data validation
    $data['shootertype'] = substr($data['shootertype'], 0, 4);
    $data['shooterdist'] = constrain($data['shooterdist'], 0, 15);
    $data['shooterspeed'] = nonneg($data['shooterspeed']);
    $data['shooterpositions'] = constrain($data['shooterpositions'], 0, 5);
    $data['shooterballsshot'] = nonneg($data['shooterballsshot']);
    $data['shooterballshit'] = nonneg($data['shooterballshit']);

    //Drive data validation
    $data['drivespeed'] = nonneg($data['drivespeed']);
    $data['drivepushingpower'] = nonneg($data['drivepushingpower']);
    $data['drivemaneuverability'] = nonneg($data['drivemaneuverability']);

    //Intake data validation
    $data['intakespeed'] = nonneg($data['intakespeed']);
    $data['intakeconsistency'] = constrain($data['intakeconsistency'], 0, 10);
    $data['intakecapacity'] = constrain($data['intakecapacity'], 0, 4);

    //Lift data validation
    if(isset($data['liftlow']) && $data['liftlow'] === "yes"){
        $data['liftlow'] = true;
    } else {
        $data['liftlow'] = false;
    }
    if(isset($data['lifthigh']) && $data['lifthigh'] === "yes"){
        $data['lifthigh'] = true;
    } else {
        $data['lifthigh'] = false;
    }
    $data['liftmaxweight'] = nonneg($data['liftmaxweight']);
    $data['liftspeed'] = constrain($data['liftspeed'], 0, 10);
    $data['liftreliability'] = constrain($data['liftreliability'], 0, 10);

    //Robot Build data validation
    $data['robotheight'] = constrain($data['robotheight'], 0, 18);
    $data['robotshooterheight'] = constrain($data['robotshooterheight'], 0, 18);
    $data['robotweight'] = nonneg($data['robotweight']);
    $data['robotbuildquality'] = constrain($data['robotbuildquality'], 0, 10);

    //Auton data validation
    $data['autonpointsscored'] = nonneg($data['autonpointsscored']);
    $data['autonpointsattempted'] = nonneg($data['autonpointsattempted']);
    $data['autonreliability'] = constrain($data['autonreliability'], 0, 10);

    //Driver Ability data validation
    $data['driverskill'] = constrain($data['driverskill'], 0, 10);
    $data['driverstrategy'] = constrain($data['driverstrategy'], 0, 10);
    $data['driverruleknowledge'] = constrain($data['driverruleknowledge'], 0, 10);

    //Qualifiers data validation
    $data['qualifiersmatchesplayed'] = nonneg($data['qualifiersmatchesplayed']);
    $data['qualifierswp'] = nonneg($data['qualifierswp']);
    $data['qualifierssp'] = nonneg($data['qualifierssp']);

    //Skills data validation
    $data['skillsdriver'] = nonneg($data['skillsdriver']);
    $data['skillsprog'] = nonneg($data['skillsprog']);

    //Notes data validation
    $data['message'] = htmlspecialchars($data['message']);

    //Return validated form data
    return $data;
}

function calculate_scores(array $data):array {
    $scores = [
        'shooterscore' => 0,
        'drivescore' => 0,
        'intakescore' => 0,
        'liftscore' => 0,
        'robotscore' => 0,
        'autonscore' => 0,
        'driverscore' => 0,
        'qualifiersscore' => 0,
        'skillsscore' => 0,
        'totalscore' => 0
    ];

    if($data['robottype'] === "preload") {
        if ($data['shooterballsshot'] === 0) {
            $scores['shooterscore'] = 0;
        } else {
            $scores['shooterscore'] = $data['shooterdist'];
            $scores['shooterscore'] += $data['shooterspeed'] * 20;
            $precision = $data['shooterballshit']/$data['shooterballsshot'];
            $scores['shooterscore'] +=  $precision * 75;
            $scores['shooterscore'] += $data['shooterpositions'];
            $scores['shooterscore'] *= 100 / 135;
        }

        $scores['drivescore'] =
            ($data['drivespeed'] * 2 + $data['drivepushingpower'] * 1.5 + $data['drivemaneuverability']) * 100 / 41;

        $scores['intakescore'] =
            ($data['intakespeed'] * 10 + $data['intakeconsistency'] + $data['intakecapacity'] * 5) * 100 / 50;

        $scores['liftscore'] =
            ((($data['lifthigh']) ? 20 : 0) + (($data['liftlow']) ? 10 : 0) + $data['liftmaxweight'] / 2 + $data['liftspeed']
                + $data['liftreliability']) * 100 / 70;

        $scores['robotscore'] =
            ($data['robotheight'] + ((18 - $data['robotshooterheight']) * (-2.5)) + ($data['robotweight'] * (-0.25)) +
                $data['robotbuildquality']) * 100 / 28;

        $scores['autonscore'] =
            ($data['autonpointsscored'] * 2 + $data['autonpointsattempted'] + $data['autonreliability'] * 2) * 100 / 80;

        $scores['driverscore'] =
            ($data['driverskill'] * 2 + $data['driverstrategy'] + $data['driverruleknowledge']) * 100 / 40;

        if ($data['qualifiersmatchesplayed'] === 0) {
            $scores['qualifiersscore'] = 0;
        } else {
            $scores['qualifiersscore'] =
                ($data['qualifierswp'] * 10 + $data['qualifierssp'] / 10) * 100 / ($data['qualifiersmatchesplayed'] * 30);
        }

        $scores['skillsscore'] =
            ($data['skillsdriver'] + $data['skillsprog']) * 100/640;

        $scores['totalscore'] =
            ($scores['shooterscore'] * 2.5 + $scores['drivescore'] * 1.5 + $scores['intakescore'] * 1.25 +
            $scores['liftscore'] * 0.25 + $scores['robotscore'] * 1 + $scores['autonscore'] * 1.25 +
            $scores['driverscore'] * 1 + $scores['qualifiersscore'] * 1 + $scores['skillsscore'] * 1) * 100/1075;

    } else if($data['robottype'] === "field") {
        if ($data['shooterballsshot'] === 0) {
            $scores['shooterscore'] = 0;
        } else {
            $scores['shooterscore'] = $data['shooterdist'] * 0.5;
            $scores['shooterscore'] += $data['shooterspeed'] * 10;
            $precision = $data['shooterballshit']/$data['shooterballsshot'];
            $scores['shooterscore'] +=  $precision * 20;
            $scores['shooterscore'] += $data['shooterpositions'] * 2;
            $scores['shooterscore'] *= 100 / 57.5;
        }

        $scores['drivescore'] =
            ($data['drivespeed'] * 3 + $data['drivepushingpower'] * 0.5 + $data['drivemaneuverability'] * 2) * 100 / 49;

        $scores['intakescore'] =
            ($data['intakespeed'] * 10 + $data['intakeconsistency'] * 2 + $data['intakecapacity'] * 5) * 100 / 60;

        $scores['liftscore'] =
            ((($data['lifthigh']) ? 20 : 0) + (($data['liftlow']) ? 10 : 0) + $data['liftmaxweight'] / 2 + $data['liftspeed']
                + $data['liftreliability']) * 100 / 70;

        $scores['robotscore'] =
            ($data['robotheight'] + ((18 - $data['robotshooterheight']) * (-0.25)) + ($data['robotweight'] * (-0.25)) +
                $data['robotbuildquality']) * 100 / 28;

        $scores['autonscore'] =
            ($data['autonpointsscored'] * 2 + $data['autonpointsattempted'] + $data['autonreliability'] * 2) * 100 / 80;

        $scores['driverscore'] =
            ($data['driverskill'] * 2 + $data['driverstrategy'] + $data['driverruleknowledge']) * 100 / 40;

        if ($data['qualifiersmatchesplayed'] === 0) {
            $scores['qualifiersscore'] = 0;
        } else {
            $scores['qualifiersscore'] =
                ($data['qualifierswp'] * 10 + $data['qualifierssp'] / 10) * 100 / ($data['qualifiersmatchesplayed'] * 30);
        }
        $scores['skillsscore'] =
            ($data['skillsdriver'] + $data['skillsprog']) * 100/640;

        $scores['totalscore'] =
            ($scores['shooterscore'] * 2 + $scores['drivescore'] * 2 + $scores['intakescore'] * 1.5 +
                $scores['liftscore'] * 0.25 + $scores['robotscore'] * 1 + $scores['autonscore'] * 0.75 +
                $scores['driverscore'] * 1.25 + $scores['qualifiersscore'] * 1 + $scores['skillsscore'] * 1) * 125/1075;
    }
    return $scores;
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $submitter = $_SESSION['id'];
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        header("Location: index.php?" . http_build_query(array(
                "security" => "true"
            )));
        die();
    }
    $data = $_POST;
    $data = validate_form_data($data);
    $check_if_robot_exists = $conn->prepare("SELECT * FROM robots WHERE teamnum=:teamnumber");
    $check_if_robot_exists->bindParam(":teamnumber", $data['teamnum']);
    $check_if_robot_exists->execute();
    $robot_check = $check_if_robot_exists->setFetchMode(PDO::FETCH_ASSOC);
    $robot_check = $check_if_robot_exists->fetchAll();
    $check_if_score_exists = $conn->prepare("SELECT * FROM scores WHERE teamnum=:teamnumber");
    $check_if_score_exists->bindParam(":teamnumber", $data['teamnum']);
    $check_if_score_exists->execute();
    $score_check = $check_if_score_exists->setFetchMode(PDO::FETCH_ASSOC);
    $score_check = $check_if_score_exists->fetchAll();
    $add_robot = null;
    $add_scores = null;
    if(count($robot_check) === 1) {
        $add_robot = $conn->prepare("UPDATE robots SET teamname=:teamname, schoolname=:teamschool, robottype=:robottype," .
            " shootertype=:shootertype, shooterdist=:shooterdist, shooterspd=:shooterspeed, shooterpos=:shooterpos, " .
            "shooterballsshot=:ballsshot, shooterballshit=:ballshit, drivespeed=:drivespeed," .
            " drivepushingpwr=:drivepush, drivemaneuverability=:drivemaneuver, intakespeed=:intakespd," .
            " intakeconsistency=:intakeconsist, intakecapacity=:intakecapacity, liftlow=:liftlow, lifthigh=:lifthigh," .
            " liftmaxweight=:liftmaxweight, liftspeed=:liftspd, liftreliability=:liftrely, robotheight=:robotheight," .
            " robotshooterheight=:shooterheight, robotweight=:robotweight, robotbuildquality=:robotbuild, " .
            "autonpointsscored=:autonscore, autonpointsattempted=:autonattempt, autonreliability=:autonrely," .
            " driverskill=:driverskill, driverstrategy=:driverstrat, driverruleknowledge=:driverrule, " .
            "qualifiersmatchesplayed=:qualmatches, qualifierswp=:qualwp, qualifierssp=:qualsp, skillsrobot=:skillrobot, " .
            "skillsprogramming=:skillprog, notes=:notes, submitter=:submitter WHERE teamnum=:teamnum;");
    } else {
        $add_robot = $conn->prepare("INSERT INTO robots VALUES (:teamnum, :teamname, :teamschool, :robottype, :shootertype, " .
            ":shooterdist, :shooterspeed, :shooterpos, :ballsshot, :ballshit, :drivespeed, :drivepush, :drivemaneuver, " .
            ":intakespd, :intakeconsist, :intakecapacity, :liftlow, :lifthigh, :liftmaxweight, :liftspd, :liftrely, " .
            ":robotheight, :shooterheight, :robotweight, :robotbuild, :autonscore, :autonattempt, :autonrely," .
            " :driverskill, :driverstrat, :driverrule, :qualmatches, :qualwp, :qualsp, :skillrobot, :skillprog, " .
            ":notes, :submitter);");
    }
    if(count($score_check) === 1){
        $add_scores = $conn->prepare("UPDATE scores SET robottype=:robottype, shooterscore=:shooterscore, drivescore=:drivescore," .
            " intakescore=:intakescore, liftscore=:liftscore, robotscore=:robotscore, autonscore=:autonscore, " .
            "driverscore=:driverscore, qualifiersscore=:qualifiersscore, skillsscore=:skillsscore," .
            " totalscore=:totalscore WHERE teamnum=:teamnum");
    } else {
        $add_scores = $conn->prepare("INSERT INTO scores VALUES (:teamnum, :robottype, :shooterscore, :drivescore," .
            " :intakescore, :liftscore, :robotscore, :autonscore, :driverscore, :qualifiersscore, :skillsscore, :totalscore)");
    }
    //Bind parameters into SQL Prepared Statement
    $add_robot->bindParam(":teamnum", $data['teamnum']);
    $add_robot->bindParam(":teamname", $data['teamname']);
    $add_robot->bindParam(":teamschool", $data['teamschool']);
    $add_robot->bindParam(":robottype", $data['robottype']);
    $add_robot->bindParam(":shootertype", $data['shootertype']);
    $add_robot->bindParam(":shooterdist", $data['shooterdist']);
    $add_robot->bindParam(":shooterspeed", $data['shooterspeed']);
    $add_robot->bindParam(":shooterpos", $data['shooterpositions']);
    $add_robot->bindParam(":ballsshot", $data['shooterballsshot']);
    $add_robot->bindParam(":ballshit", $data['shooterballshit']);
    $add_robot->bindParam(":drivespeed", $data['drivespeed']);
    $add_robot->bindParam(":drivepush", $data['drivepushingpower']);
    $add_robot->bindParam(":drivemaneuver", $data['drivemaneuverability']);
    $add_robot->bindParam(":intakespd", $data['intakespeed']);
    $add_robot->bindParam(":intakeconsist", $data['intakeconsistency']);
    $add_robot->bindParam(":intakecapacity", $data['intakecapacity']);
    $add_robot->bindParam(":liftlow", $data['liftlow']);
    $add_robot->bindParam(":lifthigh", $data['lifthigh']);
    $add_robot->bindParam(":liftmaxweight", $data['liftmaxweight']);
    $add_robot->bindParam(":liftspd", $data['liftspeed']);
    $add_robot->bindParam(":liftrely", $data['liftreliability']);
    $add_robot->bindParam(":robotheight", $data['robotheight']);
    $add_robot->bindParam(":shooterheight", $data['robotshooterheight']);
    $add_robot->bindParam(":robotweight", $data['robotweight']);
    $add_robot->bindParam(":robotbuild", $data['robotbuildquality']);
    $add_robot->bindParam(":autonscore", $data['autonpointsscored']);
    $add_robot->bindParam(":autonattempt", $data['autonpointsattempted']);
    $add_robot->bindParam(":autonrely", $data['autonreliability']);
    $add_robot->bindParam(":driverskill", $data['driverskill']);
    $add_robot->bindParam(":driverstrat", $data['driverstrategy']);
    $add_robot->bindParam(":driverrule", $data['driverruleknowledge']);
    $add_robot->bindParam(":qualmatches", $data['qualifiersmatchesplayed']);
    $add_robot->bindParam(":qualwp", $data['qualifierswp']);
    $add_robot->bindParam(":qualsp", $data['qualifierssp']);
    $add_robot->bindParam(":skillrobot", $data['skillsdriver']);
    $add_robot->bindParam(":skillprog", $data['skillsprog']);
    $add_robot->bindParam(":notes", $data['message']);
    $add_robot->bindParam(":submitter", $_SESSION['id']);

    //Execute SQL Prepared Statement
    $add_robot->execute();

    $scores = calculate_scores($data);

    $add_scores->bindParam(":teamnum", $data['teamnum']);
    $add_scores->bindParam(":robottype", $data['robottype']);
    $add_scores->bindParam(":shooterscore", $scores['shooterscore']);
    $add_scores->bindParam(":drivescore", $scores['drivescore']);
    $add_scores->bindParam(":intakescore", $scores['intakescore']);
    $add_scores->bindParam(":liftscore", $scores['liftscore']);
    $add_scores->bindParam(":robotscore", $scores['robotscore']);
    $add_scores->bindParam(":autonscore", $scores['autonscore']);
    $add_scores->bindParam(":driverscore", $scores['driverscore']);
    $add_scores->bindParam(":qualifiersscore", $scores['qualifiersscore']);
    $add_scores->bindParam(":skillsscore", $scores['skillsscore']);
    $add_scores->bindParam(":totalscore", $scores['totalscore']);

    $add_scores->execute();

    //Reload page on success
    if($_POST['robottype'] === 'preload') {
        header("Location: preload.php?" . http_build_query(array(
                "submit_success" => "true"
            )));
    } else if($_POST['robottype'] === 'field'){
        header("Location: field.php?" . http_build_query(array(
                "submit_success" => "true"
            )));
    } else {
        header("Location: index.php?" . http_build_query(array(
                "submit_success" => "true"
            )));
    }
} catch(PDOException $e) {
    if($_POST['robottype'] === 'preload') {
        header("Location: preload.php?" . http_build_query(array(
                "dberror" => "true",
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