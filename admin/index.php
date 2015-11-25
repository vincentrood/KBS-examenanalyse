<?php

// de admin pagina, dit wordt natuurlijk nog uitgebreid.

require_once('/../includes/admin_functions.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {

$password = generate_random_password();

$mail_adress = $_POST["address"];

$mail_content = array(
	"address" => $mail_adress,
	"name" 	  => "",
	"subject" => "Registratie",
	"body"    => "Hierbij verzend ik het tijdelijke wachtwoord: " . $password . "<br>Log in op de site om een wachtwoord in te stellen",
	"altbody" => "wachtwoordregistratie",
);
sendMail($mail_content);
}
?>

<html>
	<body>
		<h2>Voer gegevens in</h2>
		<form method="post" action="/KBS/admin/index.php">
			<table>
				<tr>
					<th>
						<label for="address">Email</label>
					</th>
					<td>
						<input type="email" name="address">
					</td>
				</tr>	
			</table>
			<input type="submit" value="Verzend">
		</form>
	</body>
</html>