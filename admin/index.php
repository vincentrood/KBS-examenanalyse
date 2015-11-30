<?php

// de admin pagina, dit wordt natuurlijk nog uitgebreid.
require_once("/../includes/init.php");
require_once('/../includes/admin_functions.php');

session_start();

//Als gebruiker al is ingelogd , weer terugsturen naar het dashboard
if (isset($_SESSION['gebruiker_id'])) {
	if(!checkRole($_SESSION['gebruiker_id']) == 3){
                    	header('Location: '  . BASE_URL . 'dashboard/');
                    	exit;
                    }
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
				<a href="#" class="menulink">
					<li class="menuheading">
						Dashboard
					</li>
				</a>
				<a href="#" class="menulink">
					<li class="menuitem">
						<a href="#">Leerling(en) toevoegen</a>
					</li>
				</a>
				<a href="#" class="menulink">
					<li class="menuitem">
						<a href="<?php echo BASE_URL; ?>admin/docent.php">Docent Toevoegen</a>
					</li>
				</a>
				<a href="#" class="menulink">
					<li class="menuitem">
						<a href="#">Klas toevoegen</a>
					</li>
				</a>
				<a href="#" class="menulink">
					<li class="menuitem">
						<a href="#">Examens toevoegen</a>
					</li>
				</a>
			</ul>
		</div>
		<div class="contentblock">
			<div class="content">
				<h1>omdat het menu nog niet goed weergegeven wordt hier nog een keer</h1>
				<a href="<?php echo BASE_URL; ?>admin/docent.php">Docent Toevoegen</a>
		<a href="#">Leerling(en) toevoegen</a>
		<a href="#">Klas toevoegen</a>
		<a href="#">Examens toevoegen</a>
			</div>
		</div>
	</body>
</html>







