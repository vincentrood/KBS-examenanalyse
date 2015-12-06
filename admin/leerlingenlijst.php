<?php
// de admin pagina, dit wordt natuurlijk nog uitgebreid.
require_once("/../includes/init.php");
require_once('/../includes/admin_functions.php');

if(isset($_GET['klas'])) {
	$klas = $_GET['klas'];

	$leerlingen = getLeerlingenKlas($klas);
}



?>





<!DOCTYPE html>

<html>
	<?php include(ROOT_PATH . "includes/templates/header.php") ?>
	<body>
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
				<a href="#" class="menulink itembottom">
					<li class="menuitem">
						Settings
					</li>
				</a>
				<a href="../includes/logout.php" class="menulink itembottom">
					<li class="menuitem">
						Uitloggen
					</li>
				</a>
			</ul>
		</div>
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
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	</body>
</html>