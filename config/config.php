<?php

//Hier kunnen constanten gedefineerd worden die door het hele project terugkomen 
//en hier ook makkelijk te vervangen zijn. erg handig dus.



	//URL constanten
	define("BASE_URL","/");
	define("ROOT_PATH",$_SERVER["DOCUMENT_ROOT"] . "/");


	//database connectie constanten
	define("DB_HOST","localhost");
	define("DB_NAME","examenanalyse");
	define("DB_USER","root"); 
	define("DB_PASS","");

	//tijd voordat sessie verloopt
	define("SESSION_TIME", 10 * 60);	