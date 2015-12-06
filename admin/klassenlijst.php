<?php
// de admin pagina, dit wordt natuurlijk nog uitgebreid.
require_once("/../includes/init.php");
require_once('/../includes/admin_functions.php');

$klassenlijst = getKlassen();
//echo "<pre>";
//var_dump($klassenlijst);
//exit;



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
				        <th>Klas</th>
				        <th>Examenjaar</th>
				        <th>Docent</th>
				      </tr>
				    </thead>
				    <tbody>					    	
				    	<?php include(ROOT_PATH . "includes/partials/klassenlijst.html.php") ?>
					</tbody>
				</table>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	</body>
</html>