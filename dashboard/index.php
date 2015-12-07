<?php
require_once('/../config/config.php');
require_once(ROOT_PATH . "includes/init.php");

session_start();

if (!isset($_SESSION['gebruiker_id'])) {
	$_SESSION['message'] = 'Je bent niet ingelogd.';
	header('Location: ' . BASE_URL);
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
	<?php include(ROOT_PATH . "includes/templates/header.php") ?>
	<?php include(ROOT_PATH . "includes/partials/message.html.php"); ?>
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
			<h1>INFORMATIE</h1>
		</div>
	</div>
	<?php include(ROOT_PATH . "includes/templates/footer.php") ?>

