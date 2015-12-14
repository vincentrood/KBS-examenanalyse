<?php 

foreach($klassenlijst as $klas) {
	echo "<tr>";
	foreach($klas as $key => $value) {
		if($key != 'klas_id') {
			echo '<td>' 
			.($key == 'klas' ? '<a href="' . BASE_URL . 'admin/leerlingenlijst.php?klas=' . $value . '"><button type="button" class="btn btn-info btn-md">' : '') 
			. $value  
			. ($key == 'klas' ? '</button></a>' : '' )
			. '</td>';
		}
	}
	echo 
		'<td>
			<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#' . $klas["klas"] . '">
				Bewerken
			</button>
		</td>
	</tr>';
}