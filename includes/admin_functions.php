<?php

//Verschillende functies die van belang zijn voor het admin beheer



//random wachtwoord genereren
function generate_random_password() {
	$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
	$generated_password = substr(str_shuffle($charset), 0, 8);
	return $generated_password;
}

//wachtwoord mailen naar gebruiker
function sendMail($mail_content) {

	require_once('/../config/mail_config.php');

	$mail->addAddress($mail_content["address"], $mail_content["name"]);
	$mail->Subject = $mail_content["subject"];
	$mail->Body = $mail_content["body"];
	$mail->AltBody = $mail_content["altbody"];

	if (!$mail->send()){ // email verzenden
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
	else {
		echo 'Bericht verzonden!';
	}
}

