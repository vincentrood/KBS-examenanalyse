<div class="modal fade" id="<?php echo $leerling["leerling_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="myModalLabel">Leerling bewerken</h4>
      		</div>
      		<div class="modal-body">
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
						      </tr>
						    </thead>
						    <tbody>					    	
						    	<tr class="inputrow">
						            <td><input type="text" class="form-control leerling" name="voornaam" value="<?php echo $leerling["voornaam"] ?>"></td>
						            <td><input type="text" class="form-control leerling" name="tussenvoegsel" value="<?php echo $leerling["tussenvoegsel"] ?>"></td>
						            <td><input type="text" class="form-control leerling" name="achternaam" value="<?php echo $leerling["achternaam"] ?>"></td>
						            <td><input type="text" class="form-control leerling" name="leerling_id" value="<?php echo $leerling["leerling_id"] ?>"></td>
						            <td><input type="text" class="form-control leerling" name="emailadres" value="<?php echo $leerling["emailadres"] ?>"></td>
			            		</tr>
							</tbody>
						</table>
					</div>
    			
				</div>
				<div class="modal-footer">
					<button style="float:left" type="button" class="btn btn-default" data-toggle="modal" data-target="#verwijder<?php echo $leerling["leerling_id"] ?>">
						Leerling Verwijderen
				</button>
				<input type="hidden" name="gebruiker_id" value="<?php echo $leerling["gebruiker_id"] ?>">
				<input type="submit" class="btn btn-default" name="submit_bewerk_leerling" value="Opslaan">
				<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>		  
	 			</div>
	 		</form>
		</div>
		</div>
</div>
<div id="verwijder<?php echo $leerling["leerling_id"] ?>" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Examen verwijderen-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Verwijder  <?php echo $leerling['voornaam'] . " " . $leerling['leerling_id'] ?></h4>
            </div>
            <div class="modal-body">
                <p>Weet u het zeker?</p>
            </div>
            <div class="modal-footer">
            	<form action="" method="POST">
						<input style="float: left;" type="submit" class="btn btn-default" name="submit_verwijder_leerling" value="Ja">
	                    <input type="hidden" name="gebruiker_id" value="<?php echo $leerling["gebruiker_id"] ?>">
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Nee</button>
            	</form>
            </div>
        </div>
    </div>
</div>