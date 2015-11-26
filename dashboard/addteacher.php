<?php
// leraar toevoegen
require_once("/../includes/init.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//checken als er gegevens ingevoerd zijn
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
			$afkorting = trim($_POST['afkorting']);
			$emailadres = trim($_POST['emailadres']);
			$rol = 2; // is leeraar
			$account_activated = 0; //account is nog niet geactiveerd, dit wordt pas gedaan als gebruiker eerste keer inlogt.
			$generated_password = generate_random_password();
			//returned $generated_password
			$generated_password = password_hash($generated_password, PASSWORD_BCRYPT);
			//checken of email en afkorting uniek zijn
			if(checkIfUserExists($emailadres)){
				//email adres niet in gebruik, dus gebruiker kan worden toegevoegd.
				// gegevens inserten
				addTeacher($voornaam, $tussenvoegsel, $achternaam, $afkorting, $emailadres, $generated_password, $rol);
				//nog niet af!!
				//wachtwoord mailen naar gebruiker	
			} else {
				//email adres in gebruik gebruiker wordt op de hoogte gesteld dat dit email adres bezet is.
				echo "Email adres is al in gebruik";
			}
			
		}
	}
}	

?>

<p>Voeg leraar toe</p>
<form action="" method="POST">
  Voornaam <input type="text" name="voornaam"><br>
  Tussenvoegsel <input type="text" name="tussenvoegsel"><br>
  Achternaam <input type="text" name="achternaam"><br>
  Afkorting <input type="text" name="afkorting"><br>
  Emailadres <input type="text" name="emailadres"><br>
  <input type="submit" value="Voeg toe">
</form>