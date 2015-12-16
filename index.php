<?php 
require_once("includes/init.php");
session_start();
/*
$wachtwoord = 'vincent';
$wachtwoord = password_hash($wachtwoord, PASSWORD_BCRYPT);
echo $wachtwoord;
exit;
*/
//Als gebruiker al is ingelogd , weer terugsturen naar het dashboard


if (isset($_SESSION['gebruiker_id'])) {
	if(checkRole($_SESSION['gebruiker_id']) == 3){
    	header('Location: '  . BASE_URL . 'admin/');
    	exit;
    }
    else{
    	header('Location: '  . BASE_URL . 'dashboard/');
    	exit;
	}
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

			$gebruiker = filter_var($gebruiker, FILTER_VALIDATE_EMAIL);
			if (!$gebruiker) {
			$_SESSION['message'] = 'Voer een geldig e-mailadres in.';	
			}
			else {
				$user_data = Authenticate($gebruiker);
		        if ($gebruiker !== $user_data['emailadres']) {
		            $_SESSION['message'] = 'Gebruiker niet gevonden';
		        	}
	    		//naam gevonden, nu controleren of wachtwoord overeenkomt. zoja doorsturen.
	        	else {
		            $match = password_verify($wachtwoord, $user_data["wachtwoord"]);
		            if ($match === FALSE) {
		                $_SESSION['message'] = 'Wachtwoord onjuist.';
		                header('Location: ' . BASE_URL);
		                exit;
		            } else if($user_data['account_activated'] == 0) { 
		            	$_SESSION['account_activated'] = $user_data["account_activated"];
		            	$_SESSION['gebruiker_id'] = $user_data["gebruiker_id"];
		            	$_SESSION['timeout'] = time();
		            	header('Location: ' . BASE_URL . 'password/');
		            	exit;
	            	}
	            	$_SESSION['gebruiker_id'] = $user_data["gebruiker_id"];
	                $_SESSION['timeout'] = time();
	                if(checkRole($_SESSION['gebruiker_id']) == 3){
	                	$_SESSION['message-success'] = 'U bent nu ingelogd';
	                	header('Location: '  . BASE_URL . 'admin/');
	                	exit;
	                }
	                else {
	                	$_SESSION['message-success'] = 'U bent nu ingelogd';
	                    header('Location: '  . BASE_URL . 'dashboard/');
	                    exit;
	                }
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
		<link rel="stylesheet" href="assets/css/bootstrap.css" type="text/css" media="all">
		<link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all">
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	</head>
	<body class="alternative-body">
		<?php include(ROOT_PATH . "includes/partials/message.html.php"); ?>
		<div class="container loginmargin">
			<div class="row loginmargin">
				<div class="col-sm-6 col-sm-offset-3 loginblock">
					<h1><center><b>Examen Analyse</b></center></h1>
					<form method="post" action="">
						<input type="text" class="form-control login-form" name="user" placeholder="<?php if(isset($_POST['user'])) { echo $_POST['user']; }else{echo"Gebruikersnaam";}?>"/>
						<input type="password" class="form-control login-form" name="password" placeholder="Wachtwoord"/>
						<p class="help-block"><a href="wachtwoord_vergeten.php">Wachtwoord vergeten?</a></p>
						<input type="submit" class="btn btn-default" value="Inloggen" />
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
 