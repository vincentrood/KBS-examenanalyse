<?php
require_once('/../config/config.php');
require_once(ROOT_PATH . "includes/init.php");

session_start();

if (!isset($_SESSION['gebruiker_id'])) {
	$_SESSION['message'] = 'Je bent niet ingelogd.';
	header('Location: ' . BASE_URL);
}

if (isset($_SESSION['timeout']) && $_SESSION['timeout'] + SESSION_TIME < time()) {
	session_destroy();
	session_start();
	$_SESSION['message'] = 'Sessie is verlopen.';
	header('Location: ' . BASE_URL);
} else {
	$_SESSION['timeout'] = time();
}


echo"ingelogd..!<br>";
echo"<a href='/kbs/includes/logout.php'>Log uit</a>";



