<?php

//instellingen voor de email module.

require_once('/../includes/libs/PHPMailer-master/PHPMailerAutoload.php');

$mail = new PHPMailer;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = 'smtp.gmail.com';
$mail->Username = 'kbswindesheim@gmail.com';
$mail->Password = 'windesheim';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->From = 'kbswindesheim@gmail.com';
$mail->FromName = 'Sjaak van Lenten';
$mail->addReplyTo('kbswindesheim@gmail.com', 'Reply Address');

$mail->isHTML(true); 
//$mail->addAttachment('','')   ----- voor bijlagen