<?php
// de admin pagina, dit wordt natuurlijk nog uitgebreid.
require_once("/../includes/init.php");

checkSession();
checkIfAdmin();

?>
<!DOCTYPE html>
<html>
	<?php include(ROOT_PATH . "includes/templates/header.php");?>
	<?php include(ROOT_PATH . "includes/templates/sidebar-admin.php");?>
		<div class="contentblock">
			<div class="content">
				<h1>omdat het menu nog niet goed weergegeven wordt hier nog een keer</h1>
				<a href="<?php echo BASE_URL; ?>admin/docent.php">Docent Toevoegen</a>
				<a href="<?php echo BASE_URL; ?>admin/leerling.php">Leerling(en) toevoegen</a>
				<a href="#">Klas toevoegen</a>
				<a href="#">Examens toevoegen</a>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	</body>
</html>
