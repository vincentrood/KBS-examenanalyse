<?php
// de admin pagina, dit wordt natuurlijk nog uitgebreid.
require_once("/../includes/init.php");

checkSession();
checkIfAdmin();

if(isset($_GET['klas'])) {
	$klas = $_GET['klas'];
	$leerlingen = getLeerlingenKlas($klas);
}

?>





<!DOCTYPE html>

<html>
	<?php include(ROOT_PATH . "includes/templates/header.php");?>
    <?php include(ROOT_PATH . "includes/templates/sidebar-admin.php");?>
    <body>
		<div class="contentblock">
			<div class="content">
				<table class="table table-condensed table-bordered">
				    <thead>
				      <tr>
				        <th>Leerlingnummer</th>
				        <th>Voornaam</th>
				        <th>Tussenvoegsel</th>
				        <th>Achternaam</th>				        
				        <th>E-mail Adres</th>
				      </tr>
				    </thead>
				    <tbody>					    	
				    	<?php 
				    		if(isset($leerlingen))  
				    			include(ROOT_PATH . "includes/partials/leerlingenlijst.html.php"); 
				    	?>
					</tbody>
				</table>
			</div>
		</div>
		<?php include(ROOT_PATH . "includes/templates/footer.php");?>
	</body>
</html>