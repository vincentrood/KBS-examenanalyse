<?php
// de admin pagina, dit wordt natuurlijk nog uitgebreid.
require_once("/../includes/init.php");

$pagename = "dashboard";
checkSession();
checkIfAdmin();

?>
<!DOCTYPE html>
<html>
	<body>
		<?php include(ROOT_PATH . "includes/templates/header.php");?>
		<?php include(ROOT_PATH . "includes/templates/sidebar-admin.php");?>
		<div class="wrapper">
			<?php include(ROOT_PATH . "includes/templates/sidebar-admin.php"); ?>
			<div class="page-wrapper">
				<div class="container-fluid">
					<h1>hoi</h1>
				</div>
			</div>
		</div>
	</body>
</html>