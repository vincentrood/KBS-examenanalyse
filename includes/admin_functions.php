<?php

//Verschillende functies die van belang zijn voor het admin beheer



//random wachtwoord genereren
function generate_random_password() {
	$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
	$generated_password = substr(str_shuffle($charset), 0, 8);
	return $generated_password;
}


function createTempPasswordMail($gegevens,$generated_password) {
        $mail_content = array(
            "address" => $gegevens[3],
            "name"    => "",
            "subject" => "Registratie",
            "body"    => "Beste " . $gegevens[0] . " " . (empty($gegevens[1]) ? $gegevens[1]: $gegevens[1] . ' ') . $gegevens[2] . ",<br>" . 
            "<br>Hierbij verzend ik het tijdelijke wachtwoord: " . $generated_password . "<br>Log in op de site om een wachtwoord in te stellen",
            "altbody" => "wachtwoordregistratie",
        );
        return $mail_content;
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

function passwordVerifyMail($gegevens,$generated_password) {
        $mail_content = array(
            "address" => $gegevens[3],
            "name"    => "",
            "subject" => "Registratie",
            "body"    => "Beste " . $gegevens[0] . " " . (empty($gegevens[1]) ? $gegevens[1]: $gegevens[1] . ' ') . $gegevens[2] . ",<br>" . 
            "<br>Hierbij verzend ik het tijdelijke wachtwoord: " . $generated_password . "<br>Log in op de site om een wachtwoord in te stellen",
            "altbody" => "wachtwoordregistratie",
        );
        return $mail_content;
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