	<!-- Button trigger leerling toevoegen modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#klas-toevoegen">
  Klas Toevoegen
</button>

<!-- Leerling toevoegen Modal -->
<div class="modal fade" id="klas-toevoegen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="myModalLabel">Klas Toevoegen</h4>
      		</div>
      		<div class="modal-body">
        		<form action="" method="POST">
		        	<div class="form-group leerling">
			        	<table class="table table-condensed table-bordered">
						    <thead>
						    	<tr>
							        <th>Klas</th>
							        <th>Examenjaar</th>
							        <th>Docent Afkorting</th>
						    	</tr>
						    </thead>
						    <tbody>					    	
						    	<tr class="inputrow">
						            <td><input type="text" class="form-control leerling" name="klas[]"></td>
						            <td><input type="text" class="form-control leerling" name="examenjaar[]"></td>
						            <td><input type="text" class="form-control leerling" name="docent_afk[]"></td>	
			            		</tr>
							</tbody>
						</table>
					</div>							        
      		</div>
      		<div class="modal-footer">
      			<input type ="button" class="btn btn-default" id="delete_klas" onclick="deleteleerlingRow()" value="Rij verwijderen"/>
      			<input type ="button" class="btn btn-default" id="add_klas" onclick="insertLeerlingRow()" value="Rij toevoegen"/>
				<input type="submit" class="btn btn-default" name="submit_add_klas" value="Opslaan en verzenden">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>						      
      		</div>
      		</form>
    	</div>
  	</div>
</div>