<!DOCTYPE html>
<?php

require_once("/../includes/init.php");

checkSession();
checkIfAdmin();

?>
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
				</div>	
			</div>
		</div>
		<?php include(ROOT_PATH . "includes/templates/footer.php");?>
	</body>
</html>
