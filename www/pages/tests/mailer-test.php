<?php

use PHPMailer\PHPMailer\PHPMailer;
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

$sendToEmail = 'hobbit_baggins@mail.ru';// кому отправить (почта)
$sendToName = 'Frodo Baggins'; // имя получателя



/* ---------------- settings --------------------- */
$mail = new PHPMailer();
$mail->isSMTP();// Отправка через SMTP
$mail->CharSet = "UTF-8";
$mail->Host = 'smtp.gmail.com';  // Адрес SMTP сервера
$mail->SMTPAuth = true;          // Enable SMTP authentication
$mail->Username = 'mritcoul';       // ваше имя пользователя (без домена и @)
$mail->Password = '2309Coul';    // ваш пароль
$mail->SMTPSecure = 'auto';         // шифрование ssl
$mail->Port = 587;               // порт подключения
$mail->setFrom('mritcoul@gmail.com', 'rusfriend.com');    // от кого
/* ---------------- settings --------------------- */


$mail->addAddress($sendToEmail, $sendToName); // кому



$mail->Subject = 'Test sending!';
$top = "<h1><span style='color: red'>H</span>ello, User Name!</h1>";
$mail->msgHTML("<html>
<body>
$top
<p>Online school of Russian as a foreign language welcomes you!</p>
<p>I am sure that you will like my school!</p>
<p>Right now you can book a <span style='color: red'>free</span> 30-min lesson by clicking on this button</p>
<a href='http://www:81/free-lesson' class='button' target='_blank'
   style=
        'display: block;
        width: 200px;
        height: 45px;
        background: red;
        border-radius: 10px;
        color: white;
        font-size: 16px;
        padding-top: 14px;
        box-sizing: border-box;
        text-align: center;
        text-decoration: none;
        font-family: Arial;
        margin-bottom: 10px;'
>get a free lesson</a>
<div style='max-width: 200px; width: 100%;height: 1px;background: #777676'></div>
<h3>Regards, Russian Friend</h3>
</body></html>
");


// Отправляем

if ($mail->send()) {
    echo 'Письмо отправлено!';
} else {
    echo 'Ошибка: ' . $mail->ErrorInfo;
}
