#!/usr/bin/php
<?php
#About: this script sends an email if your IP address change, it's supposed to run on cron

$name= "Your name";
$from="Your email";
$password="123456";
$mailServer="ssl://smtp.googlemail.com";
$mailPort=465;
$to="Your rcpt";
$subject="IP Changed";

function sendMail($message){
    global $name, $from, $password, $mailServer, $mailPort, $to, $subject;
    require 'PHPMailer/PHPMailerAutoload.php';

    $email = new PHPMailer();
    $email->isSMTP();
    $email->SMTPDebug = false;
    $email->Host = $mailServer;
    $email->SMTPAuth = true;
    $email->Port     = $mailPort;
    $email->Username = $from;
    $email->Password = $password;
    $email->FromName = $name;
    $email->From     = $from;
    $email->AddAddress($to, $to);
    $email->Subject  = $subject;
    $email->Body = $message;

    if(!$email->send())
        echo 'Mailer Error: ' . $email->ErrorInfo;
}
function checkIp(){
    $json = json_decode(file_get_contents('http://jsonip.com'));
    $jsonip = $json->ip;
    $f=fopen("lastIp",'a+b');
    $lastIp=stream_get_contents($f);
    if ($jsonip != $lastIp){
        sendMail("Hello, my ip changed to: ".$jsonip);
        ftruncate($f,0);
        fwrite($f,$jsonip);
    }
    fclose($f);
}
checkIp();

?>