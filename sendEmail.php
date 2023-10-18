<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include phpmailer Lib
include('./phpmailer/src/Exception.php');
include('./phpmailer/src/PHPMailer.php');
include('./phpmailer/src/SMTP.php');

$title = $_POST["title"];
$content = $_POST["content"];

if($title === "" || $content === "") {
    echo 1;
} else {
    $emailSender = "bilaljibrilliant@gmail.com";
    $name = "bill";
    $emailReceiver = "bilaljibril772@gmail.com";
    $subject = $title;
    $message = $content;

    $mail = new PHPMailer();
    $mail->isSMTP();

    $mail->Host = "smtp.gmail.com";
    $mail->Username = $emailSender;
    $mail->Password = 'sjmxssfqzfezksae';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = 2;

    $mail->setFrom($emailSender, $name);
    $mail->addAddress($emailReceiver);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    $send = $mail->send();

    if($send) {
        echo "Success";
    } else {
        echo "Fail";
    }

}
