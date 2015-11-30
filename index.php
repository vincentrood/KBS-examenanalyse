<?php 
require_once("includes/init.php");
session_start();

//Als gebruiker al is ingelogd , weer terugsturen naar het dashboard
if (isset($_SESSION['gebruiker_id'])) {
	header('Location: '  . BASE_URL . 'dashboard/');
	exit;
}

//gegevens opvragen
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//checken als er gegevens ingevoerd zijn
	if (isset($_POST['user'], $_POST['password'])) {
		//checken of er geen lege waarden zijn ingevoerd
		if ($_POST['user'] == "Gebruikersnaam" OR $_POST['password'] == "Wachtwoord") {
				$_SESSION['message'] = 'Je moet eerst een gebruikersnaam en een wachtwoord invoeren voordat je kan inloggen!';
		} 
		else {
			// overbodige ingevoerde spaties weghalen met functie trim
			$gebruiker = trim($_POST['user']);
			$wachtwoord = trim($_POST['password']);
			$user_data = Authenticate($gebruiker, $wachtwoord);
	        if ($gebruiker !== $user_data['emailadres']) {
	            $_SESSION['message'] = 'Gebruiker niet gevonden';
	        	}
    		//naam gevonden, nu controleren of wachtwoord overeenkomt. zoja doorsturen.
        	else {
	            $match = password_verify($wachtwoord, $user_data["wachtwoord"]);
	            if ($match === FALSE) {
	                $_SESSION['message'] = 'Wachtwoord onjuist.';
	            }
	            else {
	            	$_SESSION['gebruiker_id'] = $user_data["gebruiker_id"];
	            	$_SESSION['timeout'] = time();
					header('Location: '  . BASE_URL . 'dashboard/');
					exit;
        		}
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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all">
		<link rel="stylesheet" href="assets/css/login.css" type="text/css" media="all">
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	</head>
	<body>
		<?php include(ROOT_PATH . "includes/partials/message.html.php"); ?>
		<div class="container">
			<h1>INLOGGEN</h1>
			<div class="contact-form">
				<div class="formulier">
					<form method="post" action="">
						<input type="text" class="user" name = "user" value="<?php if(isset($_POST['user'])) { echo $_POST['user']; }else{echo"Gebruikersnaam";}?>"onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Gebruikersnaam';}" />
						<input type="password" class="pass" name = "password" placeholder="Wachtwoord" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Wachtwoord';}" />
						<input type="submit" value="Inloggen" />
						<p><a href="vergeten.html">Wachtwoord vergeten?</a></p>
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
 