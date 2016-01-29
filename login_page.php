<?php
    require_once 'vendor/mobiledetect/mobiledetectlib/Mobile_Detect.php';
    $detect = new Mobile_Detect;
    session_start();
    if(isset($_SESSION['id']) && $_SESSION['loggedin'] === true){
        header("Location: index.php?".http_build_query(array(
                'loggedin' => "true"
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
		<title>Log in - 4Chainz</title>
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
							<h2>Log in</h2>
							<p>Log in to access internal use scouting forms.</p>
						</header>

						<!-- Content -->
							<section id="content">
                                <form method="post" action="login.php">
                                    <div class="row uniform 50%">
                                        <div class="6u 12u$(xsmall)">
                                            <input type="text" name="username" id="usernamelog" value="" placeholder="Username" required/>
                                        </div>
                                        <div class="6u$ 12u$(xsmall)">
                                            <input type="password" name="password" id="pwdlog" value="" placeholder="Password" required/>
                                        </div>
                                        <div class="12u$">
                                            <ul class="actions">
                                                <li><input type="submit" value="Log in" class="special" /></li>
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
	</body>
</html>