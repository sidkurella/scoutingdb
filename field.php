<?php
    require_once 'vendor/mobiledetect/mobiledetectlib/Mobile_Detect.php';
    $detect = new Mobile_Detect;
    session_start();
    if(!isset($_SESSION['id']) || $_SESSION['loggedin'] === false){
        header("Location: index.php?".http_build_query(array(
                'notloggedin' => "true"
            )));
        die();
    }
?>
<!DOCTYPE HTML>
<!--
	Landed by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Field Robot Form - 4Chainz</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-modal-override.css">
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
        <link rel="apple-touch-icon" sizes="57x57" href="/assets/icons/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/assets/icons/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/assets/icons/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/icons/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/assets/icons/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/assets/icons/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/assets/icons/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/assets/icons/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/apple-touch-icon-180x180.png">
        <link rel="icon" type="image/png" href="/assets/icons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/assets/icons/android-chrome-192x192.png" sizes="192x192">
        <link rel="icon" type="image/png" href="/assets/icons/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="/assets/icons/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="/assets/icons/manifest.json">
        <link rel="mask-icon" href="/assets/icons/safari-pinned-tab.svg" color="#5bbad5">
        <link rel="shortcut icon" href="/assets/icons/favicon.ico">
        <meta name="apple-mobile-web-app-title" content="4Chainz Scouting">
        <meta name="application-name" content="4Chainz Scouting">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-TileImage" content="/assets/icons/mstile-144x144.png">
        <meta name="msapplication-config" content="/assets/icons/browserconfig.xml">
        <meta name="theme-color" content="#ffffff">
	</head>
	<body onload="checkerrors()">
		<div id="page-wrapper">

			<!-- Header -->
			<header id="header">
				<h1 id="logo"><a href="index.php">4Chainz</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="index.php">Home</a></li>
						<?php
						if($_SESSION['loggedin']){
							echo '<li>
                                    <a href="#">Scouting Forms</a>
                                    <ul>
                                        <li><a href="preload.php">Preload Robot</a></li>
                                        <li><a href="field.php">Field Robot</a></li>
                                        <li><a href="teams.php">Robot Scores</a></li>
                                        <!--
                                        <li>
                                            <a href="#">Submenu</a>
                                            <ul>
                                                <li><a href="#">Option 1</a></li>
                                                <li><a href="#">Option 2</a></li>
                                                <li><a href="#">Option 3</a></li>
                                                <li><a href="#">Option 4</a></li>
                                            </ul>
                                        </li>
                                        -->
                                    </ul>
                                </li>';
						}
						?>
						<?php
						if($_SESSION['loggedin']){
							echo '<li><a href="logout.php" onclick="" class="button special">Log Out '.$_SESSION['name'].'</a></li>';
						} else {
                            if($detect->isMobile() && !$detect->isTablet()) {
                                echo '<li><a href="login_page.php" class="button special">Log In</a></li>';
                                echo '<li><a href="signup_page.php" class="button special">Sign Up</a></li>';
                            } else {
                                echo '<li><a href="#" onclick="showlogin()" class="button special">Log In</a></li>';
                                echo '<li><a href="#" onclick="showsignup()" class="button special">Sign Up</a></li>';
                            }
						}
						?>
					</ul>
				</nav>
			</header>

			<!-- Main -->
				<div id="main" class="wrapper style1">
					<div class="container">
						<header class="major">
							<h2>Field Robot Scouting Form</h2>
							<p>Input scouting data for robots that primarily shoot field balls.</p>
						</header>

						<!-- Content -->
							<section id="content">
                                <form method="post" action="robot_submit.php">
                                    <div class="row uniform 50%">
                                        <div class="12u$"><h3>Team Information</h3></div>
                                        <div class="2u 12u$(xsmall)">
                                            <input type="text" name="teamnum" id="teamnumber" value="" oninput="asyncGetRobotData()" placeholder="Team Number" required/>
                                        </div>
                                        <div class="5u 12u$(xsmall)">
                                            <input type="text" name="teamname" id="teamname" value="" placeholder="Team Name" required/>
                                        </div>
                                        <div class="5u$ 12u$(xsmall)">
                                            <input type="text" name="teamschool" id="teamschool" value="" placeholder="School/Organization Name" required/>
                                        </div>
                                        <div class="12u$"><h3>Shooter</h3></div>
                                        <div class="12u$ 12u$(medium)">
                                            <input type="checkbox" id="shooterexists" name="shooterexists" onclick="updateshooterform()" onload="updateshooterform()" checked>
                                            <label for="shooterexists">Robot has a shooter</label>
                                        </div>
                                        <div class="12u$">
                                            <div id="shooterselectwrapper" class="select-wrapper">
                                                <select name="shootertype" id="shootertype">
                                                    <option value="None">- Shooter Type -</option>
                                                    <option value="SFly">Single Flywheel</option>
                                                    <option value="DFly">Double Flywheel</option>
                                                    <option value="Naut">Nautilus Gear</option>
                                                    <option value="Rack">Rack Gear</option>
                                                    <option value="Cata">Catapult</option>
                                                    <option value="SBar">Spinning Bar</option>
                                                    <option value="Dual">Dual Shooter</option>
                                                    <option value="Othr">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="4u 12u$(medium)">
                                            <input type="number" min="0" max="15" step="any" id="shooterdist" name="shooterdist" placeholder="Shot Distance (in ft)"/>
                                        </div>
                                        <div class="4u 12u$(medium)">
                                            <input type="number" min="0" step="any" id="shooterspeed" name="shooterspeed" placeholder="Shot Speed (in balls/s)"/>
                                        </div>
                                        <div class="4u$ 12u$(medium)">
                                            <input type="number" min="0" max="5" step="1" id="shooterpositions" name="shooterpositions" placeholder="Shooter Field Positions"/>
                                        </div>
                                        <div class="6u 12u$(medium)">
                                            <input type="number" min="0" step="1" id="shooterballsshot" name="shooterballsshot" placeholder="Balls Shot"/>
                                        </div>
                                        <div class="6u$ 12u$(medium)">
                                            <input type="number" min="0" step="1" id="shooterballshit" name="shooterballshit" placeholder="Balls Scored"/>
                                        </div>
                                        <div class="12u$"><h3>Drive</h3></div>
                                        <div class="12u$ 12u$(medium)">
                                            <input type="checkbox" id="driveexists" name="driveexists" onclick="updatedriveform()" onload="updatedriveform()" checked>
                                            <label for="driveexists">Robot has a drive</label>
                                        </div>
                                        <div class="4u 12u$(medium)">
                                            <input type="number" min="0" step="any" id="drivespeed" name="drivespeed" placeholder="Drive Speed (in ft/s)"/>
                                        </div>
                                        <div class="4u 12u$(medium)">
                                            <input type="number" min="0" max="10" step="1" id="drivepushingpower" name="drivepushingpower" placeholder="Pushing Power (from 1-10)"/>
                                        </div>
                                        <div class="4u$ 12u$(medium)">
                                            <input type="number" min="0" max="10" step="1" id="drivemaneuverability" name="drivemaneuverability" placeholder="Maneuverability (from 1-10)"/>
                                        </div>
                                        <div class="12u$"><h3>Intake</h3></div>
                                        <div class="12u$ 12u$(medium)">
                                            <input type="checkbox" id="intakeexists" name="intakeexists" onclick="updateintakeform()" onload="updateintakeform()" checked>
                                            <label for="intakeexists">Robot has an intake</label>
                                        </div>
                                        <div class="4u 12u$(medium)">
                                            <input type="number" min="0" step="any" id="intakespeed" name="intakespeed" placeholder="Intake Speed (in balls/s)"/>
                                        </div>
                                        <div class="4u 12u$(medium)">
                                            <input type="number" min="0" max="10" step="1" id="intakeconsistency" name="intakeconsistency" placeholder="Consistency (from 1-10)"/>
                                        </div>
                                        <div class="4u$ 12u$(medium)">
                                            <input type="number" min="0" max="4" step="1" id="intakecapacity" name="intakecapacity" placeholder="Capacity (from 1-4)"/>
                                        </div>
                                        <div class="12u$"><h3>Lift</h3></div>
                                        <div class="12u$ 12u$(medium)">
                                            <input type="checkbox" id="liftexists" name="liftexists" onclick="updateliftform()" onload="updateliftform()" checked>
                                            <label for="liftexists">Robot has a lift</label>
                                        </div>
                                        <div class="6u 12u$(medium)">
                                            <input type="checkbox" id="liftlow" name="liftlow" value="yes"/>
                                            <label id="labelliftlow" for="liftlow">Robot can low lift</label>
                                        </div>
                                        <div class="6u$ 12u$(medium)">
                                            <input type="checkbox" id="lifthigh" name="lifthigh" value="yes"/>
                                            <label id="labellifthigh" for="lifthigh">Robot can high lift</label>
                                        </div>
                                        <div class="4u 12u$(medium)">
                                            <input type="number" min="0" step="any" id="liftmaxweight" name="liftmaxweight" placeholder="Maximum Lift Weight (in lb)"/>
                                        </div>
                                        <div class="4u 12u$(medium)">
                                            <input type="number" min="0" max="10" step="1" id="liftspeed" name="liftspeed" placeholder="Lift Speed (from 1-10)"/>
                                        </div>
                                        <div class="4u$ 12u$(medium)">
                                            <input type="number" min="0" max="10" step="1" id="liftreliability" name="liftreliability" placeholder="Reliability (from 1-10)"/>
                                        </div>
                                        <div class="12u$"><h3>Robot Build</h3></div>
                                        <div class="6u 12u$(medium)">
                                            <input type="number" min="0" max="18" step="any" id="robotheight" name="robotheight" placeholder="Height of Robot (in in)"/>
                                        </div>
                                        <div class="6u$ 12u$(medium)">
                                            <input type="number" min="0" max="18" step="any" id="robotshooterheight" name="robotshooterheight" placeholder="Height of Shooter (in in)"/>
                                        </div>
                                        <div class="6u 12u$(medium)">
                                            <input type="number" min="0" step="any" id="robotweight" name="robotweight" placeholder="Robot Weight (in lb)"/>
                                        </div>
                                        <div class="6u$ 12u$(medium)">
                                            <input type="number" min="0" max="10" step="1" id="robotbuildquality" name="robotbuildquality" placeholder="Build Quality (from 1-10)"/>
                                        </div>
                                        <div class="12u$"><h3>Autonomous Programming</h3></div>
                                        <div class="12u$ 12u$(medium)">
                                            <input type="checkbox" id="autonexists" name="autonexists" onclick="updateautonform()" onload="updateautonform()" checked>
                                            <label for="autonexists">Robot has an autonomous routine</label>
                                        </div>
                                        <div class="4u 12u$(medium)">
                                            <input type="number" min="0" step="1" id="autonpointsscored" name="autonpointsscored" placeholder="Points Scored"/>
                                        </div>
                                        <div class="4u 12u$(medium)">
                                            <input type="number" min="0" step="1" id="autonpointsattempted" name="autonpointsattempted" placeholder="Points Attempted"/>
                                        </div>
                                        <div class="4u$ 12u$(medium)">
                                            <input type="number" min="0" max="10" step="1" id="autonreliability" name="autonreliability" placeholder="Reliability (from 1-10)"/>
                                        </div>
                                        <div class="12u$"><h3>Driver Ability</h3></div>
                                        <div class="4u 12u$(medium)">
                                            <input type="number" min="0" max="10" step="1" id="driverskill" name="driverskill" placeholder="Driver Skill (from 1-10)"/>
                                        </div>
                                        <div class="4u 12u$(medium)">
                                            <input type="number" min="0" max="10" step="1" id="driverstrategy" name="driverstrategy" placeholder="Driver Strategy (from 1-10)"/>
                                        </div>
                                        <div class="4u$ 12u$(medium)">
                                            <input type="number" min="0" max="10" step="1" id="driverruleknowledge" name="driverruleknowledge" placeholder="Rule Knowledge (from 1-10)"/>
                                        </div>
                                        <div class="12u$"><h3>Qualification Match Performance</h3></div>
                                        <div class="12u$ 12u$(medium)">
                                            <input type="checkbox" id="qualifiersexists" name="qualifiersexists" onclick="updatequalifiersform()" onload="updatequalifiersform()" checked>
                                            <label for="qualifiersexists">Robot participated in the qualification matches</label>
                                        </div>
                                        <div class="12u$ 12u$(medium)">
                                            <input type="number" min="0" step="1" id="qualifiersmatchesplayed" name="qualifiersmatchesplayed" placeholder="Matches Played"/>
                                        </div>
                                        <div class="6u 12u$(medium)">
                                            <input type="number" min="0" step="1" id="qualifierswp" name="qualifierswp" placeholder="Win Points"/>
                                        </div>
                                        <div class="6u$ 12u$(medium)">
                                            <input type="number" min="0" step="1" id="qualifierssp" name="qualifierssp" placeholder="Strength of Schedule Points"/>
                                        </div>
                                        <div class="12u$"><h3>Skills Challenge Performance</h3></div>
                                        <div class="12u$ 12u$(medium)">
                                            <input type="checkbox" id="skillsexists" name="skillsexists" onclick="updateskillsform()" onload="updateskillsform()" checked>
                                            <label for="skillsexists">Robot participated in the skills challenge</label>
                                        </div>
                                        <div class="6u 12u$(medium)">
                                            <input type="number" min="0" step="any" id="skillsdriver" name="skillsdriver" placeholder="Robot Skills Score"/>
                                        </div>
                                        <div class="6u$ 12u$(medium)">
                                            <input type="number" min="0" step="any" id="skillsprog" name="skillsprog" placeholder="Programming Skills Score"/>
                                        </div>
                                        <div class="12u$"><h3>Additional Notes</h3></div>
                                        <div class="12u$">
                                            <textarea name="message" id="message" placeholder="Enter any additional notes (optional)" rows="6"></textarea>
                                        </div>
                                        <input type="hidden" id="csrftoken" name="token" value="<?php echo $_SESSION['token']; ?>"/>
                                        <input type="hidden" id="robottype" name="robottype" value="field" />
                                        <div class="12u$">
                                            <ul class="actions">
                                                <li><input type="submit" value="Submit" class="special" /></li>
                                                <li><input type="reset" value="Reset" /></li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
							</section>

					</div>
				</div>

			<!-- Footer -->
            <footer id="footer">
                <ul class="icons">
                    <li><a href="https://www.facebook.com/SBHS-Robotics-Team-750C-4Chainz-498571030224657" class="icon alt fa-facebook"><span class="label">Facebook</span></a></li>
                    <li><a href="mailto:team750c@gmail.com" class="icon alt fa-envelope"><span class="label">Email</span></a></li>
                </ul>
                <ul class="copyright">
                    <li>&copy; Team 750C. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
                </ul>
            </footer>

		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
            <script src="assets/js/bootstrap.min.js"></script>
            <script src="assets/js/bootbox.min.js"></script>
            <script src="assets/js/global_funcs.js"></script>
            <script src="assets/js/form_funcs.js"></script>
            <script>
                function updateshooterform() {
                    if(document.getElementById('shooterexists').checked) {
                        document.getElementById('shooterselectwrapper').innerHTML =
                        `<select name="shootertype" id="shootertype">
                            <option value="None">- Shooter Type -</option>
                            <option value="SFly">Single Flywheel</option>
                            <option value="DFly">Double Flywheel</option>
                            <option value="Naut">Nautilus Gear</option>
                            <option value="Cata">Catapult</option>
                            <option value="SBar">Spinning Bar</option>
                            <option value="Othr">Other</option>
                        </select>`;
                        document.getElementById('shooterselectwrapper').setAttribute('class', 'select-wrapper');
                        document.getElementById('shootertype').value = "None";
                        document.getElementById('shooterdist').setAttribute('type', 'number');
                        document.getElementById('shooterspeed').setAttribute('type', 'number');
                        document.getElementById('shooterballsshot').setAttribute('type', 'number');
                        document.getElementById('shooterballshit').setAttribute('type', 'number');
                        document.getElementById('shooterpositions').setAttribute('type', 'number');
                        document.getElementById('shooterdist').value = null;
                        document.getElementById('shooterspeed').value = null;
                        document.getElementById('shooterballsshot').value = null;
                        document.getElementById('shooterballshit').value = null;
                        document.getElementById('shooterpositions').value = null;
                        //unhide shooter form elements
                    } else {
                        document.getElementById('shootertype').value = "None";
                        document.getElementById('shooterselectwrapper').innerHTML = "";
                        document.getElementById('shooterselectwrapper').setAttribute('class', '');
                        document.getElementById('shooterdist').value = 0;
                        document.getElementById('shooterspeed').value = 0;
                        document.getElementById('shooterballsshot').value = 0;
                        document.getElementById('shooterballshit').value = 0;
                        document.getElementById('shooterpositions').value = 0;
                        document.getElementById('shooterdist').setAttribute('type', 'hidden');
                        document.getElementById('shooterspeed').setAttribute('type', 'hidden');
                        document.getElementById('shooterballsshot').setAttribute('type', 'hidden');
                        document.getElementById('shooterballshit').setAttribute('type', 'hidden');
                        document.getElementById('shooterpositions').setAttribute('type', 'hidden');
                        //rehide shooter form elements
                    }
                }
                function updatedriveform() {
                    if(document.getElementById('driveexists').checked) {
                        document.getElementById('drivespeed').setAttribute('type', 'number');
                        document.getElementById('drivepushingpower').setAttribute('type', 'number');
                        document.getElementById('drivemaneuverability').setAttribute('type', 'number');
                        document.getElementById('drivespeed').value = null;
                        document.getElementById('drivepushingpower').value = null;
                        document.getElementById('drivemaneuverability').value = null;
                        //unhide drive form elements
                    } else {
                        document.getElementById('drivespeed').setAttribute('type', 'hidden');
                        document.getElementById('drivepushingpower').setAttribute('type', 'hidden');
                        document.getElementById('drivemaneuverability').setAttribute('type', 'hidden');
                        document.getElementById('drivespeed').value = 0;
                        document.getElementById('drivepushingpower').value = 0;
                        document.getElementById('drivemaneuverability').value = 0;
                        //rehide drive form elements
                    }
                }
                function updateintakeform() {
                    if(document.getElementById('intakeexists').checked) {
                        document.getElementById('intakespeed').setAttribute('type', 'number');
                        document.getElementById('intakeconsistency').setAttribute('type', 'number');
                        document.getElementById('intakecapacity').setAttribute('type', 'number');
                        document.getElementById('intakespeed').value = null;
                        document.getElementById('intakeconsistency').value = null;
                        document.getElementById('intakecapacity').value = null;
                        //unhide intake form elements
                    } else {
                        document.getElementById('intakespeed').setAttribute('type', 'hidden');
                        document.getElementById('intakeconsistency').setAttribute('type', 'hidden');
                        document.getElementById('intakecapacity').setAttribute('type', 'hidden');
                        document.getElementById('intakespeed').value = 0;
                        document.getElementById('intakeconsistency').value = 0;
                        document.getElementById('intakecapacity').value = 0;
                        //rehide intake form elements
                    }
                }
                function updateliftform() {
                    if(document.getElementById('liftexists').checked) {
                        document.getElementById('liftlow').setAttribute('type', 'checkbox');
                        document.getElementById('lifthigh').setAttribute('type', 'checkbox');
                        document.getElementById('labelliftlow').style.display = "";
                        document.getElementById('labellifthigh').style.display = "";
                        document.getElementById('liftmaxweight').setAttribute('type', 'number');
                        document.getElementById('liftspeed').setAttribute('type', 'number');
                        document.getElementById('liftreliability').setAttribute('type', 'number');
                        document.getElementById('liftlow').value = "yes";
                        document.getElementById('lifthigh').value = "yes";
                        document.getElementById('liftlow').checked = false;
                        document.getElementById('lifthigh').checked = false;
                        document.getElementById('liftmaxweight').value = null;
                        document.getElementById('liftspeed').value = null;
                        document.getElementById('liftreliability').value = null;
                        //unhide lift form elements
                    } else {
                        document.getElementById('liftlow').checked = false;
                        document.getElementById('lifthigh').checked = false;
                        document.getElementById('labelliftlow').style.display = "none";
                        document.getElementById('labellifthigh').style.display = "none";
                        document.getElementById('liftlow').setAttribute('type', 'hidden');
                        document.getElementById('lifthigh').setAttribute('type', 'hidden');
                        document.getElementById('liftmaxweight').setAttribute('type', 'hidden');
                        document.getElementById('liftspeed').setAttribute('type', 'hidden');
                        document.getElementById('liftreliability').setAttribute('type', 'hidden');
                        document.getElementById('liftlow').value = "no";
                        document.getElementById('lifthigh').value = "no";
                        document.getElementById('liftmaxweight').value = 0;
                        document.getElementById('liftspeed').value = 0;
                        document.getElementById('liftreliability').value = 0;
                        //rehide lift form elements
                    }
                }
                function updateautonform() {
                    if(document.getElementById('autonexists').checked) {
                        document.getElementById('autonpointsscored').setAttribute('type', 'number');
                        document.getElementById('autonpointsattempted').setAttribute('type', 'number');
                        document.getElementById('autonreliability').setAttribute('type', 'number');
                        document.getElementById('autonpointsscored').value = null;
                        document.getElementById('autonpointsattempted').value = null;
                        document.getElementById('autonreliability').value = null;
                        //unhide auton form elements
                    } else {
                        document.getElementById('autonpointsscored').setAttribute('type', 'hidden');
                        document.getElementById('autonpointsattempted').setAttribute('type', 'hidden');
                        document.getElementById('autonreliability').setAttribute('type', 'hidden');
                        document.getElementById('autonpointsscored').value = 0;
                        document.getElementById('autonpointsattempted').value = 0;
                        document.getElementById('autonreliability').value = 0;
                        //rehide auton form elements
                    }
                }
                function updatequalifiersform() {
                    if(document.getElementById('qualifiersexists').checked) {
                        document.getElementById('qualifiersmatchesplayed').setAttribute('type', 'number');
                        document.getElementById('qualifierswp').setAttribute('type', 'number');
                        document.getElementById('qualifierssp').setAttribute('type', 'number');
                        document.getElementById('qualifiersmatchesplayed').value = null;
                        document.getElementById('qualifierswp').value = null;
                        document.getElementById('qualifierssp').value = null;
                        //unhide qualifiers form elements
                    } else {
                        document.getElementById('qualifiersmatchesplayed').setAttribute('type', 'hidden');
                        document.getElementById('qualifierswp').setAttribute('type', 'hidden');
                        document.getElementById('qualifierssp').setAttribute('type', 'hidden');
                        document.getElementById('qualifiersmatchesplayed').value = 0;
                        document.getElementById('qualifierswp').value = 0;
                        document.getElementById('qualifierssp').value = 0;
                        //rehide qualifiers form elements
                    }
                }
                function updateskillsform() {
                    if(document.getElementById('skillsexists').checked) {
                        document.getElementById('skillsdriver').setAttribute('type', 'number');
                        document.getElementById('skillsprog').setAttribute('type', 'number');
                        document.getElementById('skillsdriver').value = null;
                        document.getElementById('skillsprog').value = null;
                        //unhide qualifiers form elements
                    } else {
                        document.getElementById('skillsdriver').setAttribute('type', 'hidden');
                        document.getElementById('skillsprog').setAttribute('type', 'hidden');
                        document.getElementById('skillsdriver').value = 0;
                        document.getElementById('skillsprog').value = 0;
                        //rehide qualifiers form elements
                    }
                }
            </script>
	</body>
</html>