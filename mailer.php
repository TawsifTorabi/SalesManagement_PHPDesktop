<?php
require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer();

$mail->Host = "smtp.gmail.com";

$mail->SMTPAuth = true;

$mail->Username = ""; //Type in Email
$mail->Password = "";//Type in password
$mail->SMTPSecure = "ssl";
$mail->Port = 465;
$mail->Subject = "Test Subject";
$mail->Body = "This is Body";
$mail->setFrom("address:'".$mail->Username."'", "name:'Foo Bar'");
$mail->addAddress("address:'random@random'");
if($mail->send()){
	echo "Sent";
} else {
	echo "Error Sending";
}
?>
