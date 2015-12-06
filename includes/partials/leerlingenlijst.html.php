<?php

foreach($leerlingen as $leerling) {
	echo "<tr>";
	foreach($leerling as $key => $value) {
		echo '<td>'  
		. $value  
		. '</td>';
	}
	echo "<td><button>Bewerken</button><button>Delete</button></td></tr>";
}