<?php

function rebuildArray($data) {
    $data = $_POST;
	$temp_array = array_values($data);
		$count = count($temp_array[0]) ;

		for($j = 0; $j<$count; $j++) {
			$i = 0;
		foreach($data as $key => $value){
    		$data[$key] = $temp_array[$i][$j];
    		$i++;
		}
		$gegevens[] = $data;
	}
	return $gegevens;
}

function addKlasFilter($gegevens) {
    foreach($gegevens as $values => $keys) {
	    $gegevens[$values]["klas"] = filter_var($gegevens[$values]["klas"], FILTER_SANITIZE_STRING);
	    $gegevens[$values]["examenjaar"] = filter_var(trim($gegevens[$values]["examenjaar"]), FILTER_SANITIZE_NUMBER_INT);
	    $gegevens[$values]["docent_afk"] = filter_var(trim($gegevens[$values]["docent_afk"]), FILTER_SANITIZE_STRING);
	}
	return $gegevens;
}

function updateKlasFilter($gegevens) {
	    $gegevens["klas"] = filter_var($gegevens["klas"], FILTER_SANITIZE_STRING);
	    $gegevens["examenjaar"] = filter_var(trim($gegevens["examenjaar"]), FILTER_SANITIZE_NUMBER_INT);
	    $gegevens["docent_afk"] = filter_var(trim($gegevens["docent_afk"]), FILTER_SANITIZE_STRING);
	return $gegevens;
}