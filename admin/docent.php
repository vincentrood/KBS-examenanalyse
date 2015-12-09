<?php

require_once("/../includes/init.php");
$pagename = "docenten";
checkSession();
checkIfAdmin();


if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	//****************  DOCENT TOEVOEGEN ******************//

	if(isset($_POST['submit_docent'])) {
		if (isset($_POST['voornaam'], $_POST['achternaam'], $_POST['afkorting'], $_POST['emailadres'])) {
			//checken of er geen lege waarden zijn ingevoerd
			if ($_POST['voornaam'] == "" OR $_POST['achternaam'] == "" OR $_POST['afkorting'] == "" OR $_POST['emailadres'] == "") {
				$_SESSION['message'] = "Je moet alle gegevens invullen!";
			} 
			else {
				// overbodige ingevoerde spaties weghalen met functie trim
				$voornaam = filter_var(trim($_POST['voornaam']), FILTER_SANITIZE_STRING);

				$achternaam = filter_var(trim($_POST['achternaam']), FILTER_SANITIZE_STRING);
				$tussenvoegsel = filter_var($_POST['tussenvoegsel'], FILTER_SANITIZE_STRING);//tussenvoegsel mag spatie bevatten
				$docent_afkorting = filter_var(trim($_POST['afkorting']), FILTER_SANITIZE_STRING);
				$emailadres = filter_var(trim($_POST['emailadres']), FILTER_VALIDATE_EMAIL);
				if (!$emailadres) {
					$_SESSION['message'] = 'Voer een geldig e-mailadres in.';
				}
				else {	
					$role = 2; // is leraar
					$account_activated = 0; //account is nog niet geactiveerd, dit wordt pas gedaan als gebruiker eerste keer inlogt.
					$generated_password = generate_random_password();
					$wachtwoord = password_hash($generated_password, PASSWORD_BCRYPT);
					$email_code = md5($voornaam + microtime());

					//returned $generated_password

					$gegevens = [ 
						"voornaam" => $voornaam,
						"tussenvoegsel" => $tussenvoegsel,
						"achternaam" => $achternaam,
						"emailadres" => $emailadres,
						"email_code" => $email_code,
						"generated_password" => $generated_password,
						"wachtwoord" => $wachtwoord,
						"account_activated" => $account_activated,
						"role" => $role,
						"docent_afkorting" => $docent_afkorting,
					];

					//checken of email en afkorting uniek zijn
					if(checkIfUserExists($gegevens["emailadres"]) === FALSE){
						//email adres niet in gebruik, dus gebruiker kan worden toegevoegd.
						// gegevens inserten
						addUser($gegevens);
						addTeacher($gegevens["emailadres"], $gegevens["docent_afkorting"]);
						//nog niet af!!
						//wachtwoord mailen naar gebruiker
						$mail_content = createTempPasswordMail($gegevens);
						sendMail($mail_content);
					} else {
						//email adres in gebruik gebruiker wordt op de hoogte gesteld dat dit email adres bezet is.
						$_SESSION['message'] = "Email adres is al in gebruik";
					}
				}
			}
		}
	}
}

?>
<!DOCTYPE html>
<html>
	<body>
		<?php include(ROOT_PATH . "includes/templates/header.php");?>
		<?php include(ROOT_PATH . "includes/templates/sidebar-admin.php");?>
		<div class="wrapper">
			<?php include(ROOT_PATH . "includes/templates/sidebar-admin.php"); ?>
			<div class="page-wrapper">
				<div class="container-fluid">
					<div class="contentblock">
						<div class="content">
							<h2>Voeg leraar toe</h2>
							<form action="" method="POST">
					  			Voornaam <input type="text" name="voornaam"><br>
					  			Tussenvoegsel <input type="text" name="tussenvoegsel"><br>
					  			Achternaam <input type="text" name="achternaam"><br>
					  			Afkorting <input type="text" name="afkorting"><br>
					  			Emailadres <input type="text" name="emailadres"><br>
					  			<input type="submit" name="submit_docent" value="Voeg toe">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include(ROOT_PATH . "includes/templates/footer.php");?>
	</body>
</html>
