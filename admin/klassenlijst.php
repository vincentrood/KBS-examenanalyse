<?php
// de admin pagina, dit wordt natuurlijk nog uitgebreid.
require_once("/../includes/init.php");

checkSession();
checkIfAdmin();

$klassenlijst = getKlassen();

?>





<!DOCTYPE html>

<html>
	<?php include(ROOT_PATH . "includes/templates/header.php") ?>
	<?php include(ROOT_PATH . "includes/templates/sidebar-admin.php");?>
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