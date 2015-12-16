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
		<div class="wrapper">
			<?php include(ROOT_PATH . "includes/templates/sidebar-admin.php"); ?>
			<div class="page-wrapper">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Welkom op het dashboard!</h3>
								</div>
								<div class="panel-body">
									Hier kan eventueel enige uitleg gegeven worden over deze pagina.
								</div>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="panel panel-default">
								<form action="" method="POST">
									<div class="form-group">
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-hover">
												<tr>
													<th>Leerling_ID</th>
													<th>Voornaam</th>
													<th class="table-column">Tussenvoegsel</th>
													<th>Achternaam</th>
													<th>Email-adres</th>
													<th class="table-column">Klas</th>
												</tr>
												<tr>
													<td>1</td>
													<td>Bernard</td>
													<td>-</td>
													<td>Mussche</td>
													<td>bernardmussche@gmail.com</td>
													<td>5Hb</td>
												</tr>
												<tr>
													<td>2</td>
													<td>Sjaak</td>
													<td>van</td>
													<td>Lenten</td>
													<td>sjaakvanlenten@gmail.com</td>
													<td>5Hb</td>
												</tr>
												<tr>
													<td>1</td>
													<td>Bernard</td>
													<td>-</td>
													<td>Mussche</td>
													<td>bernardmussche@gmail.com</td>
													<td>5Hb</td>
												</tr>
												<tr>
													<td>2</td>
													<td>Sjaak</td>
													<td>van</td>
													<td>Lenten</td>
													<td>sjaakvanlenten@gmail.com</td>
													<td>5Hb</td>
												</tr>
												<tr>
													<td>1</td>
													<td>Bernard</td>
													<td>-</td>
													<td>Mussche</td>
													<td>bernardmussche@gmail.com</td>
													<td>5Hb</td>
												</tr>
												<tr>
													<td>2</td>
													<td>Sjaak</td>
													<td>van</td>
													<td>Lenten</td>
													<td>sjaakvanlenten@gmail.com</td>
													<td>5Hb</td>
												</tr>
												<tr>
													<td>1</td>
													<td>Bernard</td>
													<td>-</td>
													<td>Mussche</td>
													<td>bernardmussche@gmail.com</td>
													<td>5Hb</td>
												</tr>
												<tr>
													<td>2</td>
													<td>Sjaak</td>
													<td>van</td>
													<td>Lenten</td>
													<td>sjaakvanlenten@gmail.com</td>
													<td>5Hb</td>
												</tr>
												<tr class="inputrow">
													<td><input type="text" class="form-control" name="voornaam[]"></td>
													<td><input type="text" class="form-control" name="tussenvoegsel[]"></td>
													<td><input type="text" class="form-control" name="achternaam[]"></td>
													<td><input type="text" class="form-control" name="leerling_id[]"></td>
													<td><input type="text" class="form-control" name="emailadres[]"></td>
													<td><input type="text" class="form-control" name="klas[]"></td>	
												</tr>
												<tr class="inputrow">
													<td><input type="text" class="form-control" name="voornaam[]"></td>
													<td><input type="text" class="form-control" name="tussenvoegsel[]"></td>
													<td><input type="text" class="form-control" name="achternaam[]"></td>
													<td><input type="text" class="form-control" name="leerling_id[]"></td>
													<td><input type="text" class="form-control" name="emailadres[]"></td>
													<td><input type="text" class="form-control" name="klas[]"></td>	
												</tr>
												<tr class="inputrow">
													<td><input type="text" class="form-control" name="voornaam[]"></td>
													<td><input type="text" class="form-control" name="tussenvoegsel[]"></td>
													<td><input type="text" class="form-control" name="achternaam[]"></td>
													<td><input type="text" class="form-control" name="leerling_id[]"></td>
													<td><input type="text" class="form-control" name="emailadres[]"></td>
													<td><input type="text" class="form-control" name="klas[]"></td>	
												</tr>
											</table>
										</div>
									<div class="panel-footer">
									<input type ="button" class="btn btn-default" id="add_leerling" onclick="insertLeerlingRow()" value="Rij toevoegen"/>
									<input type="submit" class="btn btn-default" name="submit_leerling" value="Opslaan en verzenden">
									</di>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>