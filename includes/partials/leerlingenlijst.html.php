<?php

foreach($leerlingen as $leerling) {
	echo "<tr>";
	foreach($leerling as $key => $value) {
		echo '<td>'  
		. $value  
		. '</td>';
	}
	echo 
		'<td>
			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#' . $leerling["leerling_id"] . '">
				Bewerken
			</button>
		</td>
	</tr>';
}