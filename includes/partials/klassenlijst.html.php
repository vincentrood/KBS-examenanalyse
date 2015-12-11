<?php 

foreach($klassenlijst as $klas) {
	echo "<tr>";
	foreach($klas as $key => $value) {
		echo '<td>' 
		.($key == 'klas' ? '<a href="http://localhost/kbs/admin/leerlingenlijst.php?klas=' . $value . '">' : '') 
		. $value  
		. ($key == 'klas' ? '</a>' : '' )
		. '</td>';
	}
	echo "</tr>";
}