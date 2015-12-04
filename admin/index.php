<?php

// de admin pagina, dit wordt natuurlijk nog uitgebreid.
require_once("/../includes/init.php");
require_once('/../includes/admin_functions.php');

session_start();

//Als gebruiker al is ingelogd , weer terugsturen naar het dashboard
if (isset($_SESSION['gebruiker_id'])) {
	if(checkRole($_SESSION['gebruiker_id']) != 3){
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
	<?php include(ROOT_PATH . "includes/templates/header.php");?>
	<body>
		<div class="sidemenu">
			<ul>
				<a href="/" class="menulink">
					<li class="menuheading">
						Dashboard
					</li>
				</a>
				<a href="#" class="menulink">
					<li class="menuitem">
						Leerling(en) toevoegen
					</li>
				</a>
				<a href="<?php echo BASE_URL; ?>admin/docent.php" class="menulink">
					<li class="menuitem">
						Docent Toevoegen
					</li>
				</a>
				<a href="#" class="menulink">
					<li class="menuitem">
						Klas toevoegen
					</li>
				</a>
				<a href="#" class="menulink">
					<li class="menuitem">
						Examens toevoegen
					</li>
				</a>
				<a href="#" class="menulink itembottom">
					<li class="menuitem">
						Settings
					</li>
				</a>
				<a href="../includes/logout.php" class="menulink itembottom">
					<li class="menuitem">
						Uitloggen
					</li>
				</a>
			</ul>
		</div>
		<div class="contentblock">
			<div class="content">
				<h1>omdat het menu nog niet goed weergegeven wordt hier nog een keer</h1>
				<a href="<?php echo BASE_URL; ?>admin/docent.php">Docent Toevoegen</a>
				<a href="<?php echo BASE_URL; ?>admin/leerling.php">Leerling(en) toevoegen</a>
		<a href="#">Klas toevoegen</a>
		<a href="#">Examens toevoegen</a>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	</body>
</html>