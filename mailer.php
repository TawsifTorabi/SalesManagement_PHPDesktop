<?php
require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer();

$mail->Host = "smtp.gmail.com";

$mail->SMTPAuth = true;

$mail->Username = "tawsiftorabi.jr@gmail.com";
$mail->Password = "iloveorthimorethanfacebook";
$mail->SMTPSecure = "ssl";
$mail->Port = 465;
$mail->Subject = "Test Subject";
$mail->Body = "This is Body";
$mail->setFrom("address:'tawsiftorabi.jr@gmail.com'", "name:'Tawsif Torabi'");
$mail->addAddress("address:'editor@rupok.net'");
if($mail->send()){
	echo "Sent";
} else {
	echo "Error Sending";
}
?>