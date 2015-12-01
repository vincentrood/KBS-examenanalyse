<?php
require_once('/../config/config.php');
require_once(ROOT_PATH . "includes/init.php");
session_start();
if (!isset($_SESSION['gebruiker_id'])) {
	if(!isset($_SESSION['account_activated'])) {
		if (!isset($_GET['id'],$_GET['email_code'])) {
		$_SESSION['message'] = 'Toegang geweigerd.';
		header('Location: ' . BASE_URL);
		exit;
		} else {
			$user_id = intval($_GET['id']);
			$email_code = $_GET['email_code'];
			if(!checkEmailCode($user_id,$email_code)) {
				unset($user_id,$email_code);
				$_SESSION['message'] = 'Toegang geweigerd.';
				header('Location: ' . BASE_URL);
				exit;
			}
			$pass = 1;
		}
	}
}
if(!isset($_SESSION['account_activated']) AND !isset($pass)) {
	$_SESSION['message'] = 'Toegang geweigerd.';
	header('Location: ' . BASE_URL);
	exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);
	$pass_confirm = filter_input(INPUT_POST, 'pass_confirm', FILTER_SANITIZE_SPECIAL_CHARS);
	
	if(passTest($pass, $pass_confirm) === TRUE) {
		if(isset($_SESSION['gebruiker_id'])) {
			$user_id = $_SESSION['gebruiker_id'];
		}
		$password = password_hash($pass, PASSWORD_BCRYPT);
		//wachtwoord invoeren in de database en activate_account op 1 zetten ( dus geactiveerd )
		updatePassword($password, $user_id);
		unset($_SESSION['account_activated']);
		if(isset($user_id,$email_code)) {
			//nieuwe email code aanmaken en opslaan.
			$email_code = md5($user_id + microtime());
			update_email_code($user_id,$email_code);
			header('Location: ' . BASE_URL);
		}
		else {
			header('Location: ' . BASE_URL . 'dashboard/');
		}		
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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css" type="text/css" media="all">
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login.css" type="text/css" media="all">
	</head>
	<body>
		<?php include(ROOT_PATH . "includes/partials/message.html.php"); ?>
		<div class="container">
			<h1>WACHTWOORD INSTELLEN</h1>
			<div class="contact-form">
				<div class="formulier">
					<form autocomplete="off" method="post" action="">
						<input type="password" class="user" name = "pass" placeholder="Nieuw wachtwoord">
						<input type="password" class="pass" name = "pass_confirm" placeholder="Herhaal wachtwoord">
						<input type="submit" value="Stel wachtwoord in">
					</form>
				</div>
			</div> 
		</div>
		<div class="footer">
			<p>Copyright &copy; 2015. All Rights Reserved | Design by KBS ICTM1a KPM05</p>
		</div>
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="<?php echo BASE_URL; ?>assets/js/alert_message.js"></script>
	</body>
</html>