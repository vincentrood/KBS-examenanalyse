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
		
		if(!checkIfUserExists($email)) {
			$_SESSION['message'] = 'Email adres niet gevonden.';
		} else {
			$user_data = checkIfUserExists($email);
			$user_id = $user_data['gebruiker_id'];
			$email_code = $user_data['email_code'];
			$url_code ="index.php?id=" . $user_id . "&email_code=" . $email_code;
			$mail_content = passwordResetMail($user_data,$url_code);
			sendMail($mail_content);
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
		<link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all">
		<link rel="stylesheet" href="assets/css/login.css" type="text/css" media="all">
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	</head>
	<body>
		<?php include(ROOT_PATH . "includes/partials/message.html.php"); ?>
		<div class="container">
			<h1>Nieuw wachtwoord</h1>
			<div class="contact-form">
				<div class="formulier">
					<form method="post" action="">
						<input type="email" class="user" name = "user" value="<?php if(isset($_POST['user'])) { echo $_POST['user']; }else{echo"Email adres";}?>"onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Gebruikersnaam';}" />
						<input type="submit" value="Vestuur mail" />
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