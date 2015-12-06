	<head>
		<title>Examen Analyse</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="theme-color" content="#1BBC9B">
		<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->
		<link rel="stylesheet" href="../assets/css/style.css" type="text/css" media="all">
		<link rel="stylesheet" href="../assets/css/dashboard.css" type="text/css" media="all">
	</head>
	<body>
		<?php include(ROOT_PATH . "includes/partials/message.html.php"); ?>
		<div class="stickymenu">
			<div class="titlemenu">
				<div class="logoimg">
					<img src="../images/dashboard/logo_fruytier.png" alt="logo_fruytier">
					<img src="../images/dashboard/logo.png" alt="logo">
				</div>
				<div class="apptitle">
					<h1>EXAMENANALYSE</h1>
				</div>
			</div>
			<div class="usermenu">
				<div class="headicon">
					<img src="../images/dashboard/maleicon.png" alt="headicon">
				</div>
				<div class="username">
					<h3><?php $data = getUserData($_SESSION['gebruiker_id']);echo $data['voornaam']." ".$data['tussenvoegsel']." ".$data['achternaam'];?></h3>
				</div>
				<div class="settings">
					<img src="../images/dashboard/settings.png" alt="settings">
					<ul class="submenu">
						<li>
							<a href="#" class="submenuitem">Settings</a>
						</li>
						<li>
							<a href="../includes/logout.php" class="submenuitem">Uitloggen</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</body>