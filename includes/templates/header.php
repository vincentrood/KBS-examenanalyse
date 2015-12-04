<?php

//stukken html die zoiezo op elke pagina terugkomen zoals het bovenstuk(header),onderkant(footer) en misschien een menu 
//aan de zijkant??(sidebar) zodat je deze makkelijk kunt includen op de verschillende paginas.
//hieronder een voorbeeldje van een header:

/*
<?php

$search_term = "";
if (isset($_GET["s"])) {
	$search_term = trim($_GET["s"]);
	if($search_term != "" ) {
		require_once(ROOT_PATH . "inc/products.php");
		$products = get_products_search($search_term);
	} 
}

if(isset($_SESSION["item"])) {
	foreach($_SESSION["item"] as $item) {
		$cartproducts[] = get_products_cart($item["name"], $item["size"]); 
	}
	$_SESSION["productscount"] = strval(count($cartproducts));

}
?>
<html>
<head>
	<title><?php echo $pageTitle; ?></title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css" type="text/css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700" type="text/css">
	<link rel="shortcut icon" href="<?php echo BASE_URL; ?>favicon.ico">
</head>
<body>

	<div class="header">

		<h1 class="branding-title"><a href="<?php echo BASE_URL; ?>">Shirts 4 Mike</a></h1>

			<ul class="nav">
				<li class="shirts <?php if ($section == "shirts") { echo "on"; } ?>"><a href="<?php echo BASE_URL; ?>shirts/">Shirts</a></li>
				<li class="contact <?php if ($section == "contact") { echo "on"; } ?>"><a href="<?php echo BASE_URL; ?>contact/">Contact</a></li>
				<li class="cart"><a href="<?php echo BASE_URL; ?>cart/"><?php if(isset($_SESSION["productscount"])) { echo $_SESSION["productscount"]; } else{ echo "0"; } ?></a></li>
				<li class="search <?php if ($section == "search") { echo "on"; } ?>"><a href="<?php echo BASE_URL; ?>search/">Search</a></li>
				<li class="searchbox">			
					<form method="get" action="<?php echo BASE_URL; ?>shirts/">
						
						<input type="text" name="s" value="<?php if(isset($search_term)){ echo htmlspecialchars($search_term); } ?>">
					</form>
				</li>
			</ul>
		
		</div>

	<div id="content">
	*/