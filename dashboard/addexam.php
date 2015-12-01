<?php
require_once('/../config/config.php');
require_once(ROOT_PATH . "includes/init.php");

session_start();

if (!isset($_SESSION['gebruiker_id'])) {
	$_SESSION['message'] = 'Je bent niet ingelogd.';
	header('Location: ' . BASE_URL);
}

if(checkRole($_SESSION['gebruiker_id']) == 3){
                    	header('Location: '  . BASE_URL . 'admin/');
                    	exit;
                    }
                    

if (isset($_SESSION['timeout']) && $_SESSION['timeout'] + SESSION_TIME < time()) {
	// sessie destroyen als sessie verlopen is.
	session_destroy();
	session_start();
	$_SESSION['message'] = 'Sessie is verlopen.';
	header('Location: ' . BASE_URL);
} else {
	//als sessie niet verlopen is sessie verlengen
	$_SESSION['timeout'] = time();
}



?>
<!DOCTYPE html>
<html>
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
		<div class="sidemenu">
			<ul>
				<a href="/" class="menulink">
					<li class="menuheading">
						Dashboard
					</li>
				</a>
				<a href="#" class="menulink">
					<li class="menuitem">
						Examen
					</li>
				</a>
				<a href="#" class="menulink">
					<li class="menuitem">
						Resultaten
					</li>
				</a>
				<a href="#" class="menulink">
					<li class="menuitem">
						Score
					</li>
				</a>
			</ul>
		</div>
		<div class="contentblock">
			<div class="content">
				<h1>Voeg een examen toe</h1>
				<form action="" method="POST">
		  			Vak <input type="text" name="voornaam"><br>
		  			Jaar <input type="text" name="tussenvoegsel"><br>
		  			Tijdvak <input type="text" name="achternaam"><br>
		  			nTerm <input type="text" name="afkorting"><br>
		  			Niveau <input type="email" name="emailadres"><br>
		  			<input type="submit" name="submit_docent" value="Voeg toe">

		  			<form method="post" action="collect_vals.php">
<div class="input_fields_wrap">
    <button class="add_field_button">Add More Fields</button>
    <div><input type="text" name="mytext[]"></div>
    <div><input type="text" name="mytext[]"></div>
    <div><input type="text" name="mytext[]"></div>
    <div><input type="text" name="mytext[]"></div>
    <div><input type="text" name="mytext[]"></div>
</div>
</form>
				</form>
			</div>
		</div>
	</body>
</html>

