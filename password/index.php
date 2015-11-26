<?php
require_once('/../config/config.php');
require_once(ROOT_PATH . "includes/init.php");

session_start();

if (!isset($_SESSION['gebruiker_id'])) {
	$_SESSION['message'] = 'Je bent niet ingelogd.';
	header('Location: ' . BASE_URL);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['gebruiker_id'])) {
	$pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);
	$pass_confirm = filter_input(INPUT_POST, 'pass_confirm', FILTER_SANITIZE_SPECIAL_CHARS);

	$result = passTest($pass, $pass_confirm);
	
	if($result === TRUE)
	{
		$password = password_hash($pass, PASSWORD_BCRYPT);
		updatePassword($password, $_SESSION['gebruiker_id']);
		echo $password;
	}
	else {
		echo $result;
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Examen Analyse</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="theme-color" content="#1BBC9B">
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css" type="text/css" media="all">
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login.css" type="text/css" media="all">
	</head>
	<body>
		<div class="container">
			<h1>WACHTWOORD INSTELLEN</h1>
			<div class="contact-form">
				<div class="formulier">
					<form autocomplete="off" method="post" action="">
						<input type="password" class="user" name = "pass" />
						<input type="password" class="pass" name = "pass_confirm" />
						<input type="submit" value="Inloggen" />
						<p><a href="vergeten.html">Wachtwoord vergeten?</a></p>
					</form>
				</div>
			</div> 
		</div>
		<div class="footer">
			<p>Copyright &copy; 2015. All Rights Reserved | Design by KBS ICTM1a</p>
		</div>
	</body>
</html>