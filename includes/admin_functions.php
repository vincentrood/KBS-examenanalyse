<?php

//Verschillende functies die van belang zijn voor het admin beheer



//random wachtwoord genereren
function generate_random_password() {
	$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
	$generated_password = substr(str_shuffle($charset), 0, 8);
	return $generated_password;
}


function createTempPasswordMail($gegevens) {
        $mail_content = array(
            "address" => $gegevens["emailadres"],
            "name"    => "",
            "subject" => "Registratie",
            "body"    => "Beste " . $gegevens["voornaam"] . " " . (empty($gegevens["tussenvoegsel"]) ? $gegevens["tussenvoegsel"]: $gegevens["tussenvoegsel"] . ' ') . $gegevens["achternaam"] . ",<br>" . 
            "<br>Hierbij verzend ik het tijdelijke wachtwoord: " . $gegevens["generated_password"] . "<br>Log in op de site om een wachtwoord in te stellen",
            "altbody" => "wachtwoordregistratie",
        );
        return $mail_content;
    }

//wachtwoord mailen naar gebruiker
function sendMail($mail_content) {

	require('/../config/mail_config.php');

	$mail->addAddress($mail_content["address"], $mail_content["name"]);
	$mail->Subject = $mail_content["subject"];
	$mail->Body = $mail_content["body"];
	$mail->AltBody = $mail_content["altbody"];

	if (!$mail->send()){ // email verzenden
		$_SESSION['message'] = 'Mailer Error: ' . $mail->ErrorInfo;
	}
}


//body staat nu nog localhost voor de base_url voor lokaal gebruik
function passwordResetMail($user_data,$url_code) {
        $mail_content = array(
            "address" => $user_data['emailadres'],
            "name"    => "",
            "subject" => "Wachtwoord wijzigen",
            "body"    => 'Beste ' . $user_data['voornaam'] . ' ' 
            . (empty($user_data['tussenvoegsel']) ? $user_data['tussenvoegsel']: $user_data['tussenvoegsel'] . ' ') 
            . $user_data['achternaam'] . ',<br>' 
            . '<br>Hierbij verzend ik de link om uw wachtwoord opnieuw in te stellen:<br> 
            <a href="http://localhost' . BASE_URL . 'password/' . $url_code . '">localhost' . BASE_URL . 'password/' . $url_code . '</a>',
            "altbody" => "wachtwoordregistratie",
        );
        return $mail_content;
    }