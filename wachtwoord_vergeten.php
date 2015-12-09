<?php 
require_once("includes/init.php");
session_start();
if (isset($_SESSION['gebruiker_id'])) {
	header('Location: '  . BASE_URL . 'dashboard/');
	exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//checken als er gegevens ingevoerd zijn
	if (isset($_POST['user'])) {
		$email = trim($_POST['user']);
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		if (!$email) {
			$_SESSION['message'] = 'Voer een geldig e-mailadres in.';	
		}
		else {
			if(!checkIfUserExists($email)) {
				$_SESSION['message'] = 'Email adres niet gevonden.';
			} 
			else {
				$user_data = checkIfUserExists($email);
				$user_id = $user_data['gebruiker_id'];
				$email_code = $user_data['email_code'];
				$url_code ="index.php?id=" . $user_id . "&email_code=" . $email_code;
				$mail_content = passwordResetMail($user_data,$url_code);
				sendMail($mail_content);
				$_SESSION['message-success'] = 'Er is een e-mail verstuurd om uw wachtwoord opnieuw in te stellen.';
			}
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
		<link rel="stylesheet" href="assets/css/bootstrap.css" type="text/css" media="all">
		<link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all">
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	</head>
	<body class="alternative-body">
		<?php include(ROOT_PATH . "includes/partials/message.html.php"); ?>
		<div class="container loginmargin">
			<div class="row loginmargin">
				<div class="col-sm-6 col-sm-offset-3 loginblock">
					<h1><center><b>Wachtwoord vergeten?</b></center></h1>
					<form method="post" action="">
						<input type="text" class="form-control" name="user" placeholder="<?php if(isset($_POST['user'])) { echo $_POST['user']; }else{echo"Gebruikersnaam";}?>"/>
						<input type="submit" class="btn btn-default" value="Vestuur mail" />
					</form>
				</div>
			</div>
		</div>
		<div class="copyrightelement">
			<center>Copyright &copy; 2015. All Rights Reserved | Design by KBS ICTM1a KPM05</center>
		</div>
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="<?php echo BASE_URL; ?>assets/js/alert_message.js"></script>
	</body>
</html>