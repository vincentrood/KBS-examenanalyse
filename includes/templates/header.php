	<?php

	$data = getUserData($_SESSION['gebruiker_id']);
	$gebruikersnaam = $data['voornaam']." ".$data['tussenvoegsel']." ".$data['achternaam'];

	?>

	<head>
		<title>Examen Analyse</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="theme-color" content="#1BBC9B">
		<link rel="stylesheet" href="../assets/css/bootstrap.css" type="text/css" media="all">
		<link rel="stylesheet" href="../assets/css/style.css" type="text/css" media="all">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	</head>
	<body>
		<?php include(ROOT_PATH . "includes/partials/message.html.php"); ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-8 col-md-7 col-sm-6 header">
					<img src="../images/dashboard/logo.png" alt="logo">
					<h3><b>Examen Analyse</b></h3>
				</div>
				<div class="col-lg-4 col-md-5 col-sm-6 header usermenu">
					<img src="../images/dashboard/maleicon.png" alt="usericon">
					<h3><?php $data = getUserData($_SESSION['gebruiker_id']);echo $data['voornaam']." ".$data['tussenvoegsel']." ".$data['achternaam'];?></h3>
					<a href="../includes/logout.php">
						<img src="../images/dashboard/logout.png" alt="logout">
					</a>
				</div>
			</div>
		</div>
	</body>

