<?php
require_once('/../config/config.php');
require_once(ROOT_PATH . "includes/init.php");
$pagename = "dashboard";
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
	<body>
		<?php include(ROOT_PATH . "includes/partials/message.html.php"); ?>
        <?php include(ROOT_PATH . "includes/templates/header.php");?>
		<div class="wrapper">
			<?php include(ROOT_PATH . "includes/templates/sidebar-leerling.php"); ?>
			<div class="page-wrapper">
				<div class="container-fluid">
					<h1>hoi</h1>
				</div>
				<!--HIER KOMT ALLE CONTENT-->
			</div>
		</div>
		<?php include(ROOT_PATH . "includes/templates/footer.php");?>
	</body>
</html>

