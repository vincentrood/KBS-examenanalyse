<?php

// de admin pagina, dit wordt natuurlijk nog uitgebreid.
require_once('/../config/config.php');
require_once(ROOT_PATH . "includes/init.php");
require_once(ROOT_PATH . 'includes/admin_functions.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	//****************  DOCENT TOEVOEGEN ******************//

	if(isset($_POST['submit_docent'])) {
		if (isset($_POST['voornaam'], $_POST['achternaam'], $_POST['afkorting'], $_POST['emailadres'])) {
			//checken of er geen lege waarden zijn ingevoerd
			if ($_POST['voornaam'] == "" OR $_POST['achternaam'] == "" OR $_POST['afkorting'] == "" OR $_POST['emailadres'] == "") {
				echo "Je moet alle gegevens invullen!";
			} 
			else {
				// overbodige ingevoerde spaties weghalen met functie trim
				$voornaam = trim($_POST['voornaam']);
				$achternaam = trim($_POST['achternaam']);
				$tussenvoegsel = $_POST['tussenvoegsel'];//tussenvoegsel mag spatie bevatten
				$docent_afkorting = trim($_POST['afkorting']);
				$emailadres = trim($_POST['emailadres']);
				$role = 2; // is leraar
				$account_activated = 0; //account is nog niet geactiveerd, dit wordt pas gedaan als gebruiker eerste keer inlogt.
				$generated_password = generate_random_password();
				$wachtwoord = password_hash($generated_password, PASSWORD_BCRYPT);
				//returned $generated_password

				$gegevens = [ 
					$voornaam,
					$tussenvoegsel,
					$achternaam,
					$emailadres,
					$wachtwoord,
					$account_activated,
					$role
				];

				//checken of email en afkorting uniek zijn
				if(checkIfUserExists($emailadres)){
					//email adres niet in gebruik, dus gebruiker kan worden toegevoegd.
					// gegevens inserten
					addUser($gegevens);
					addTeacher($gegevens[3], $docent_afkorting);
					//nog niet af!!
					//wachtwoord mailen naar gebruiker
					$mail_content = createEmail($gegevens,$generated_password);
					sendMail($mail_content);
				} else {
					//email adres in gebruik gebruiker wordt op de hoogte gesteld dat dit email adres bezet is.
					echo "Email adres is al in gebruik";
				}
			}
		}
	}
}

?>

<html>
	<body>
		<h2>Voeg leraar toe</h2>
		<form action="" method="POST">
  			Voornaam <input type="text" name="voornaam"><br>
  			Tussenvoegsel <input type="text" name="tussenvoegsel"><br>
  			Achternaam <input type="text" name="achternaam"><br>
  			Afkorting <input type="text" name="afkorting"><br>
  			Emailadres <input type="email" name="emailadres"><br>
  			<input type="submit" name="submit_docent" value="Voeg toe">
		</form>
	</body>
</html>