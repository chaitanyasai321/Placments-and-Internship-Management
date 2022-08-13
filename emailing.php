<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpMailer/src/Exception.php';
require 'phpMailer/src/PHPMailer.php';
require 'phpMailer/src/SMTP.php';
//Load composer's autoloader
require 'vendor/autoload.php';
   $mail = new PHPMailer();
    $mail->CharSet =  "utf-8";
    $mail->SMTPDebug = 6; 
    $mail->IsSMTP(true);
    $mail->Host = 'smtp.gmail.com';
    // enable SMTP authentication
    $mail->SMTPAuth = true;                  
    // GMAIL username
    $mail->Username = "chaitanyasai321@gmail.com";
    // GMAIL password
    $mail->Password = "your_password";
    $mail->SMTPSecure = "ssl";  
    // sets GMAIL as the SMTP server
    $mail->Host = "smtp.gmail.com";
    // set the SMTP port for the GMAIL server
    $mail->Port = "465";
    $mail->From='chaitanyasai321@gmail.com';
    $mail->FromName='Sai Chaitanya';
    $mail->AddAddress('vvivek.18.cse@anits.edu.in', 'Reciever');
    $mail->Subject  =  'Reset Password';
    $mail->IsHTML(true);
    $mail->Body    = 'Click On This Link to Reset Password';
    if($mail->Send())
    {
      echo "Check Your Email and Click on the link sent to your email";
    }
    else
    {
      echo "Mail Error - >".$mail->ErrorInfo;
    }
?>