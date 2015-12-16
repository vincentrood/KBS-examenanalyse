	<!-- Button trigger leerling toevoegen modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#leerling-toevoegen">
  Leerling Toevoegen
</button>

<!-- Leerling toevoegen Modal -->
<div class="modal fade" id="leerling-toevoegen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="myModalLabel">Leerling Toevoegen</h4>
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
							        <th>Klas</th>
						    	</tr>
						    </thead>
						    <tbody>					    	
						    	<tr class="inputrow">
						            <td><input type="text" class="form-control leerling" name="voornaam[]"></td>
						            <td><input type="text" class="form-control leerling" name="tussenvoegsel[]"></td>
						            <td><input type="text" class="form-control leerling" name="achternaam[]"></td>
						            <td><input type="text" class="form-control leerling" name="leerling_id[]"></td>
						            <td><input type="text" class="form-control leerling" name="emailadres[]"></td>
						            <td><input type="text" class="form-control leerling" name="klas[]"></td>	
			            		</tr>
							</tbody>
						</table>
					</div>							        
      		</div>
      		<div class="modal-footer">
      			<input type ="button" class="btn btn-default" id="delete_leerling" onclick="deleteleerlingRow()" value="Rij verwijderen"/>
      			<input type ="button" class="btn btn-default" id="add_leerling" onclick="insertLeerlingRow()" value="Rij toevoegen"/>
				<input type="submit" class="btn btn-default" name="submit_add_leerling" value="Opslaan en verzenden">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>						      
      		</div>
      		</form>
    	</div>
  	</div>
</div>