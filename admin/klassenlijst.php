<?php
require_once("/../includes/init.php");

checkSession();
checkIfAdmin();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //****************  KLAS TOEVOEGEN ******************//
    if(isset($_POST['submit_add_klas'])) {
        if (isset($_POST['klas'], $_POST['examenjaar'], $_POST['docent_afk'])) {
            //checken of er geen lege waarden zijn ingevoerd

            if ($_POST['klas'] == "" OR $_POST['examenjaar'] == "" OR $_POST['docent_afk'] == "") {
                $_SESSION['message'] = "Je moet alle gegevens invullen!";
                			
            } 
            else {
            	//binnenkomende array ombouwen
            	unset($_POST['submit_add_klas']);
            	$gegevens = rebuildArray($_POST);

                //Ingevoerde gegevens door filter halen en trimmen
            	$gegevens = addKlasFilter($gegevens);

                foreach($gegevens as $klas_gegevens) {		     
		                addKlas($klas_gegevens);		
                }
            }
        }
    }

    //********** KLAS BEWERKEN **********//
    if(isset($_POST["submit_bewerk_klas"])) {
		if ($_POST['klas'] == "" OR $_POST['examenjaar'] == "" OR $_POST['docent_afk'] == "") {
			$_SESSION['message'] = "Je moet alle gegevens invullen!";
		} 
		else {
			$klas_id = intval($_POST['klas_id']);
			$gegevens = [ 
				"klas" => $_POST['klas'],
				"examenjaar" => $_POST['examenjaar'],
				"docent_afk" => $_POST['docent_afk'],
			];
			//******** KLAS GEGEVENS FILTEREN *********//
			updateKlasFilter($gegevens);
			//******** KLAS UPDATEN IN DATABASE ********//
			updateKlas($gegevens,$klas_id);	
		}
    }

    //******** KLAS VERWIJDEREN **********//
    if(isset($_POST["submit_verwijder_klas"])) {
    	$klas_id = intval($_POST['klas_id']);

    	deleteKlas($klas_id);
    }
}



//Pak alle klassen uit de database----------------------
$klassenlijst = getKlassen();

//Tel aantal leerlingen per klas
foreach($klassenlijst as $klas => $keys) {
	$klassenlijst[$klas]['aantal'] = getAantalLeerlingenKlas($klassenlijst[$klas]['klas']);
}

$pagename = "klassen";
?>

<?php include(ROOT_PATH . "includes/templates/header.php") ?>
	<?php include(ROOT_PATH . "includes/templates/sidebar-admin.php");?>
	<div class="wrapper">
		<?php include(ROOT_PATH . "includes/templates/sidebar-admin.php"); ?>
		<div class="page-wrapper">
			<div class="container-fluid">
				<div class="contentblock">
					<div class="content">
						<table class="table table-condensed table-bordered">
						    <thead>
						      <tr>
						        <th>Klas</th>
						        <th>Examenjaar</th>
						        <th>Docent</th>
						        <th>Aantal Leerlingen</th>
						      </tr>
						    </thead>
						    <tbody>					    	
						    	<?php include(ROOT_PATH . "includes/partials/klassenlijst.html.php") ?>
							</tbody>
						</table>

						<!-- Klas bewerken/verwijderen Modal -->
						<?php
							foreach ($klassenlijst as $klas) {
								foreach ($klas as $key => $value) {
									include(ROOT_PATH . "includes/partials/modals/klas_bewerk_modal.html.php");
								}
							}
						?>

						<!-- Klas Toevoegen Modal -->
						<?php					
							include(ROOT_PATH . "includes/partials/modals/klas_toevoegen_modal.html.php");
						?>

					</div>
				</div>
			</div>	
		</div>
	</div>
<?php include(ROOT_PATH . "includes/templates/footer.php");?>