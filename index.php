<?php
    session_start();
?>
<!DOCTYPE HTML>
<!--
	Landed by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Team 750C - 4Chainz</title>
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
	<body class="landing" onload="checkerrors()">
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
                                echo '<li><a href="#" onclick="showlogin()" class="button special">Log In</a></li>';
								echo '<li><a href="#" onclick="showsignup()" class="button special">Sign Up</a></li>';
                            }
                            ?>
						</ul>
					</nav>
				</header>

			<!-- Banner -->
				<section id="banner">
					<div class="content">
						<header>
							<h2>Team 750C &ndash; 4Chainz</h2>
							<p>A VEX Robotics Competition team from South Brunswick, NJ.<br />
							Scroll to learn more about our robot and journey.</p>
						</header>
						<span class="image"><img src="images/4chainz%20square%20logo.jpg" alt="" /></span>
					</div>
					<a href="#one" class="goto-next scrolly">Next</a>
				</section>

			<!-- One -->
				<section id="one" class="spotlight style1 bottom">
					<span class="image fit main"><img src="images/monroe%20tournament%20champions.jpg" alt="" /></span>
					<div class="content">
						<div class="container">
							<div class="row">
								<div class="4u 12u$(medium)">
									<header>
										<h2>Odio faucibus ipsum integer consequat</h2>
										<p>Nascetur eu nibh vestibulum amet gravida nascetur praesent</p>
									</header>
								</div>
								<div class="4u 12u$(medium)">
									<p>Feugiat accumsan lorem eu ac lorem amet sed accumsan donec.
									Blandit orci porttitor semper. Arcu phasellus tortor enim mi
									nisi praesent dolor adipiscing. Integer mi sed nascetur cep aliquet
									augue varius tempus lobortis porttitor accumsan consequat
									adipiscing lorem dolor.</p>
								</div>
								<div class="4u$ 12u$(medium)">
									<p>Morbi enim nascetur et placerat lorem sed iaculis neque ante
									adipiscing adipiscing metus massa. Blandit orci porttitor semper.
									Arcu phasellus tortor enim mi mi nisi praesent adipiscing. Integer
									mi sed nascetur cep aliquet augue varius tempus. Feugiat lorem
									ipsum dolor nullam.</p>
								</div>
							</div>
						</div>
					</div>
					<a href="#two" class="goto-next scrolly">Next</a>
				</section>

			<!-- Two -->
				<section id="two" class="spotlight style2 right">
					<span class="image fit main"><img src="images/pic03.jpg" alt="" /></span>
					<div class="content">
						<header>
							<h2>Interdum amet non magna accumsan</h2>
							<p>Nunc commodo accumsan eget id nisi eu col volutpat magna</p>
						</header>
						<p>Feugiat accumsan lorem eu ac lorem amet ac arcu phasellus tortor enim mi mi nisi praesent adipiscing. Integer mi sed nascetur cep aliquet augue varius tempus lobortis porttitor lorem et accumsan consequat adipiscing lorem.</p>
						<ul class="actions">
							<li><a href="#" class="button">Learn More</a></li>
						</ul>
					</div>
					<a href="#three" class="goto-next scrolly">Next</a>
				</section>

			<!-- Three -->
				<section id="three" class="spotlight style3 left">
					<span class="image fit main bottom"><img src="images/pic04.jpg" alt="" /></span>
					<div class="content">
						<header>
							<h2>Interdum felis blandit praesent sed augue</h2>
							<p>Accumsan integer ultricies aliquam vel massa sapien phasellus</p>
						</header>
						<p>Feugiat accumsan lorem eu ac lorem amet ac arcu phasellus tortor enim mi mi nisi praesent adipiscing. Integer mi sed nascetur cep aliquet augue varius tempus lobortis porttitor lorem et accumsan consequat adipiscing lorem.</p>
						<ul class="actions">
							<li><a href="#" class="button">Learn More</a></li>
						</ul>
					</div>
					<a href="#four" class="goto-next scrolly">Next</a>
				</section>

			<!-- Four -->
				<section id="four" class="wrapper style1 special fade-up">
					<div class="container">
						<header class="major">
							<h2>Accumsan sed tempus adipiscing blandit</h2>
							<p>Iaculis ac volutpat vis non enim gravida nisi faucibus posuere arcu consequat</p>
						</header>
						<div class="box alt">
							<div class="row uniform">
								<section class="4u 6u(medium) 12u$(xsmall)">
									<span class="icon alt major fa-area-chart"></span>
									<h3>Ipsum sed commodo</h3>
									<p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p>
								</section>
								<section class="4u 6u$(medium) 12u$(xsmall)">
									<span class="icon alt major fa-comment"></span>
									<h3>Eleifend lorem ornare</h3>
									<p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p>
								</section>
								<section class="4u$ 6u(medium) 12u$(xsmall)">
									<span class="icon alt major fa-flask"></span>
									<h3>Cubilia cep lobortis</h3>
									<p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p>
								</section>
								<section class="4u 6u$(medium) 12u$(xsmall)">
									<span class="icon alt major fa-paper-plane"></span>
									<h3>Non semper interdum</h3>
									<p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p>
								</section>
								<section class="4u 6u(medium) 12u$(xsmall)">
									<span class="icon alt major fa-file"></span>
									<h3>Odio laoreet accumsan</h3>
									<p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p>
								</section>
								<section class="4u$ 6u$(medium) 12u$(xsmall)">
									<span class="icon alt major fa-lock"></span>
									<h3>Massa arcu accumsan</h3>
									<p>Feugiat accumsan lorem eu ac lorem amet accumsan donec. Blandit orci porttitor.</p>
								</section>
							</div>
						</div>
						<footer class="major">
							<ul class="actions">
								<li><a href="#" class="button">Magna sed feugiat</a></li>
							</ul>
						</footer>
					</div>
				</section>

			<!-- Five -->
				<section id="five" class="wrapper style2 special fade">
					<div class="container">
						<header>
							<h2>Magna faucibus lorem diam</h2>
							<p>Ante metus praesent faucibus ante integer id accumsan eleifend</p>
						</header>
						<form method="post" action="#" class="container 50%">
							<div class="row uniform 50%">
								<div class="8u 12u$(xsmall)"><input type="email" name="email" id="emailaddress" placeholder="Your Email Address" /></div>
								<div class="4u$ 12u$(xsmall)"><input type="submit" value="Get Started" class="fit special" /></div>
							</div>
						</form>
					</div>
				</section>

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