<?php
require_once("/../includes/init.php");
$pagename = "leerlingen";
checkSession();
checkIfAdmin();

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
			                //$mail_content = createTempPasswordMail($leerling_gegevens);
			                //sendMail($mail_content);
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
	<body>
		<?php include(ROOT_PATH . "includes/templates/header.php") ?>
		<?php include(ROOT_PATH . "includes/templates/sidebar-admin.php");?>
		<div class="wrapper">
			<?php include(ROOT_PATH . "includes/templates/sidebar-admin.php"); ?>
			<div class="page-wrapper">
				<div class="container-fluid">
					<div class="contentblock">
						<div class="content">
							<div class="panel panel-default">
								<!-- Default panel contents -->
								<div class="panel-heading">Leerling Toevoegen</div>
							        <form action="" method="POST">
							        	<div class="form-group leerling">
							        	<table class="table table-condensed table-bordered">
										    <thead>
										      <tr>
										        <th>Voornaam</th>
										        <th>Tussenvoegsel</th>
										        <th>Achternaam</th>
										        <th>Leerlingnummer</th>
										        <th>Emailadres</th>
										        <th>Klas</th>
										      </tr>
										    </thead>
										    <tbody>					    	
											    	<tr class="inputrow">
											            <td><input type="text" class="form-control leerling" name="voornaam[]"></td>
											            <td><input type="text" class="form-control leerling" name="tussenvoegsel[]"></td>
											            <td><input type="text" class="form-control leerling" name="achternaam[]"></td>
											            <td><input type="text" class="form-control leerling" name="leerling_id[]"></td>
											            <td><input type="text" class="form-control leerling" name="emailadres[]"></td>
											            <td><input type="text" class="form-control leerling" name="klas[]"></td>	
								            		</tr>
											</tbody>
										</table>
										<input type ="button" class="btn btn-default" id="add_leerling" onclick="insertLeerlingRow()" value="Rij toevoegen"/>
										<input type="submit" class="btn btn-default" name="submit_leerling" value="Opslaan en verzenden">
									</div>
							        </form>
							    </div>
					        </div>			        
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include(ROOT_PATH . "includes/templates/footer.php");?>
	</body>
</html>
