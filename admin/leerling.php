<?php

// de admin pagina, dit wordt natuurlijk nog uitgebreid.
require_once('/../config/config.php');
require_once(ROOT_PATH . "includes/init.php");
require_once(ROOT_PATH . 'includes/admin_functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //****************  LEERLING TOEVOEGEN ******************//

    if(isset($_POST['submit_leerling'])) {
        if (isset($_POST['voornaam'], $_POST['achternaam'], $_POST['leerling_id'], $_POST['emailadres'], $_POST['klas'])) {
            //checken of er geen lege waarden zijn ingevoerd
            if ($_POST['voornaam'] == "" OR $_POST['achternaam'] == "" OR $_POST['leerling_id'] == "" OR $_POST['emailadres'] == "" OR $_POST['klas'] == "") {
                $_SESSION['message'] = "Je moet alle gegevens invullen!";
            } 
            else {
            	//binnenkomende array ombouwen
            	unset($_POST['submit_leerling']);
            	$leerlingen = $_POST;
            	$temp_array = array_values($leerlingen);
         		$count = count($temp_array[0]) ;

         		for($j = 0; $j<$count; $j++) {
         			$i = 0;
            		foreach($leerlingen as $key => $value){
	            		$leerlingen[$key] = $temp_array[$i][$j];
	            		$i++;
					}
					$gegevens[] = $leerlingen;
				}
   
                // overbodige ingevoerde spaties weghalen met functie trim
                foreach($gegevens as $values => $keys) {
            	
	                $gegevens[$values]["voornaam"] = filter_var($gegevens[$values]["voornaam"], FILTER_SANITIZE_STRING);
	                $gegevens[$values]["achternaam"] = filter_var(trim($gegevens[$values]["achternaam"]), FILTER_SANITIZE_STRING);
	                $gegevens[$values]["tussenvoegsel"] = filter_var($gegevens[$values]["tussenvoegsel"], FILTER_SANITIZE_STRING);//tussenvoegsel mag spatie bevatten
	                $gegevens[$values]["leerling_id"] = filter_var(trim($gegevens[$values]["leerling_id"]), FILTER_SANITIZE_STRING);
	                $gegevens[$values]["emailadres"] = filter_var(trim($gegevens[$values]["emailadres"]), FILTER_VALIDATE_EMAIL);
	                //moet nog wat an gebeuren
	                $emailcheck = $gegevens[$values]["emailadres"];
	                $gegevens[$values]["klas"] = filter_var(trim($gegevens[$values]["klas"]), FILTER_SANITIZE_STRING);
	               
	                $gegevens[$values]["role"] = 1; // is leerling
	                $gegevens[$values]["account_activated"] = 0; //account is nog niet geactiveerd, dit wordt pas gedaan als gebruiker eerste keer inlogt.
	                $gegevens[$values]["generated_password"] = generate_random_password();
	                $gegevens[$values]["wachtwoord"] = password_hash($gegevens[$values]["generated_password"], PASSWORD_BCRYPT);
	                $gegevens[$values]["email_code"] = md5($gegevens[$values]["voornaam"] + microtime());
  				}
                //moet nog wat an gebeuren
                if (!$emailcheck) {
					$_SESSION['message'] = 'Voer een geldig e-mailadres in voor ' . $gegevens[$values]["voornaam"] 
					. " " . $gegevens[$values]["tussenvoegsel"] . " " . $gegevens[$values]["achternaam"];
				}
				else {
					//checken of email en student_id uniek zijn
	                foreach($gegevens as $leerling_gegevens) {
			            if(checkIfUserExists($leerling_gegevens['emailadres']) === FALSE){
			                //email adres niet in gebruik, dus gebruiker kan worden toegevoegd.
			                // gegevens inserten
			                addUser($leerling_gegevens);
			                
			                addStudent($leerling_gegevens["emailadres"], $leerling_gegevens["leerling_id"], $leerling_gegevens["klas"]);

			                //wachtwoord mailen naar gebruiker
			                $mail_content = createTempPasswordMail($leerling_gegevens);
			                sendMail($mail_content);
			            } else {
			                //email adres in gebruik gebruiker wordt op de hoogte gesteld dat dit email adres bezet is.
			              	$_SESSION['message'] = "Email adres " . $leerling_gegevens['emailadres'] . " is al in gebruik";
	                	}
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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="../assets/css/style.css" type="text/css" media="all">
		<link rel="stylesheet" href="../assets/css/dashboard.css" type="text/css" media="all">
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	</head>
	<body>
		<?php include(ROOT_PATH . "includes/partials/message.html.php"); ?>
		<div class="stickymenu">
			<div class="titlemenu">
				<div class="logoimg">
					<img src="../images/dashboard/logo_fruytier.png" alt="logo_fruytier">
					<img src="../images/dashboard/logo.png" alt="logo">
				</div>
				<div class="apptitle">
					<h1>EXAMENANALYSE</h1>
				</div>
			</div>
			<div class="usermenu">
				<div class="headicon">
					<img src="../images/dashboard/maleicon.png" alt="headicon">
				</div>
				<div class="username">
					<h3><?php if(isset($_SESSION['gebruiker_id'])) {
										$data = getUserData($_SESSION['gebruiker_id']);echo $data['voornaam']." "
							  					.$data['tussenvoegsel']." ".$data['achternaam'];?></h3>
							  			<?php	} else {
							  				echo "Gebruiker";
							  			}?>
				</div>
				<div class="settings">
					<img src="../images/dashboard/settings.png" alt="settings">
					<ul class="submenu">
						<li>
							<a href="#" class="submenuitem">Settings</a>
						</li>
						<li>
							<a href="../includes/logout.php" class="submenuitem">Uitloggen</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="sidemenu">
			<ul>
				<a href="/" class="menulink">
					<li class="menuheading">
						Dashboard
					</li>
				</a>
				<a href="#" class="menulink">
					<li class="menuitem">
						Leerling(en) toevoegen
					</li>
				</a>
				<a href="<?php echo BASE_URL; ?>admin/docent.php" class="menulink">
					<li class="menuitem">
						Docent Toevoegen
					</li>
				</a>
				<a href="#" class="menulink">
					<li class="menuitem">
						Klas toevoegen
					</li>
				</a>
				<a href="#" class="menulink">
					<li class="menuitem">
						Examens toevoegen
					</li>
				</a>
			</ul>
		</div>
		<div class="contentblock">
			<div class="content">
				<h2>Voeg Leerling Toe</h2>
		        <form action="" method="POST">
		        	<table class="table table-striped">
					    <thead>
					      <tr>
					        <th>Voornaam</th>
					        <th>Tussenvoegsel</th>
					        <th>Achternaam</th>
					        <th>leerling_id</th>
					        <th>Emailadres</th>
					        <th>Klas</th>
					      </tr>
					    </thead>
					    <tbody>					    	
						    	<tr class="inputrow">
						            <td><input type="text" name="voornaam[]"></td>
						            <td><input type="text" name="tussenvoegsel[]"></td>
						            <td><input type="text" name="achternaam[]"></td>
						            <td><input type="text" name="leerling_id[]"></td>
						            <td><input type="text" name="emailadres[]"></td>
						            <td><input type="text" name="klas[]"></td>	
			            		</tr>
						</tbody>
					</table>
					<button><input type="submit" name="submit_leerling" value="Opslaan en verzenden"></button>
					
		        </form>
		        <button id="add_leerling">add leerling</button>			        
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="<?php echo BASE_URL; ?>assets/js/alert_message.js"></script>
		<script src="<?php echo BASE_URL; ?>assets/js/table_insert.js"></script>
	</body>
</html>
