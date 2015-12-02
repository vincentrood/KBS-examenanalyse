<?php

//Dit stukje ('try') probeert een verbinding te maken met de database. Dit kun je dus elke keer requiren in een query functie 
//om een verbinding te leggen. Hier worden ook de constanten gebruikt die in config.php zijn opgegeven.
//ALs het om een of andere reden niet lukt wordt het catch blok uitgevoerd. Hierin vangt hij de error op die heeft plaatsgevonden.
//In het geval van een error geven we een bericht weer naar de gebruiker toe ( dit bericht kan naar wens aangepast worden).

try {
	$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,DB_USER,DB_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$db->exec("SET NAMES 'utf8'");
} catch (Exception $e) {
	$_SESSION['message'] = "Kon geen verbinding maken met de database.";
	exit;
}
