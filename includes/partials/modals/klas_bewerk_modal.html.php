<div class="modal fade" id="<?php echo $klas["klas"] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="myModalLabel">Klas bewerken</h4>
      		</div>
      		<div class="modal-body">
					<form action="" method="POST">
    				<div class="form-group">
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
						            <td><input type="text" class="form-control" name="klas" value="<?php echo $klas["klas"] ?>"></td>
						            <td><input type="text" class="form-control" name="examenjaar" value="<?php echo $klas["examenjaar"] ?>"></td>
						            <td><input type="text" class="form-control" name="docent_afk" value="<?php echo $klas["docent_afk"] ?>"></td>
			            		</tr>
							</tbody>
						</table>
					</div>
    			
				</div>
				<div class="modal-footer">
					<button style="float:left" type="button" class="btn btn-default" data-toggle="modal" data-target="#verwijder<?php echo $klas["klas"] ?>">
						Klas Verwijderen
				</button>
				<input type="hidden" name="klas_id" value="<?php echo $klas["klas_id"] ?>">
				<input type="submit" class="btn btn-default" name="submit_bewerk_klas" value="Opslaan">
				<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>		  
	 			</div>
	 		</form>
		</div>
		</div>
</div>
<div id="verwijder<?php echo $klas["klas"] ?>" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Klas verwijderen-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Verwijder  <?php echo $klas['klas'] . " " . $klas['examenjaar'] ?></h4>
            </div>
            <div class="modal-body">
                <p>Weet u het zeker dat u de gehele klas met leerlingen wilt verwijderen?</p>
            </div>
            <div class="modal-footer">
            	<form action="" method="POST">
						<input style="float: left;" type="submit" class="btn btn-default" name="submit_verwijder_klas" value="Ja">
						<input type="hidden" name="klas_id" value="<?php echo $klas["klas_id"] ?>">
                    	<button type="button" class="btn btn-default" data-dismiss="modal">Nee</button>
            	</form>
            </div>
        </div>
    </div>
</div>