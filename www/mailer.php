<?php
require("vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';
$request = json_decode(file_get_contents('php://input'), true);
//echo "<pre>"; print_r($request['data']); echo "</pre>";
$sendToEmail = $request['email'];   // почта получателя
$sendToName = $request['name'];     // имя получатлея

$myEmail = 'svetlana.tutoronline@gmail.com';    // почта отправителя
$myDomen = 'rusfriend.com';         // хост отправителя
$mail = new PHPMailer();
$mail->isSMTP();                    // Отправка через SMTP
$mail->CharSet = "UTF-8";
$mail->Host = 'smtp.gmail.com';     // Адрес SMTP сервера
$mail->SMTPAuth = true;             // Enable SMTP authentication
$mail->Username = 'svetlana.tutoronline';       // ваше имя пользователя (без домена и @)
$mail->Password = '252525st';       // ваш пароль
$mail->SMTPSecure = 'auto';         // шифрование ssl
$mail->Port = 587;                  // порт подключения
$mail->setFrom($myEmail, $myDomen); // от кого


// письмо ученику после регистрации
if ($request['method'] === 'register') {
    $mail->Subject = 'Register success!';
    $mail->msgHTML(
        "<html>
<body>
<h1><span style='color: red'>H</span>ello, $sendToName!</h1>
<p>Online school of Russian as a foreign language welcomes you!</p>
<p>I am sure that you will like my school!</p>
<p>Right now you can book a <span style='color: red'>free</span> 30-min lesson by clicking on this button</p>
<a href='http://rusfriend.com/free-lesson' class='button' target='_blank'
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
</body></html> ");
    $mail->addAddress($sendToEmail, $sendToName);
}
// письмо админу после  регистрации нового пользователя
if ($request['method'] === 'registerNewUser') {
    $mail->Subject = 'Регистрация нового пользователя!';
    $mail->msgHTML(
        "<html>
<body>
<h1><span style='color: red'>Р</span>егистрация нового пользователя.</h1>
<p>Пользователь <span style='color: red'>$sendToName</span>  успешно зарегистрировался на нашем сайте.</p>
<div style='max-width: 200px; width: 100%;height: 1px;background: #777676'></div>
<h3>Regards, Russian Friend</h3>
</body></html> ");
    $mail->addAddress($myEmail, $myDomen);
}

// письмо ученику после  бронирования бесплатного занятия
if ($request['method'] === 'bookedFree') {
    $day = $request['data'][0]['day'];
    $time = $request['data'][0]['time'];
    $timeZone = $request['data'][0]['gmt'];
    $mail->Subject = 'Successfully booked';
    $mail->msgHTML(
        "<html><body>
                <h1><span style='color: red'>H</span>ello, $sendToName!</h1>
                <p>You have successfully booked a <span style='color: red'>free</span> 30-min lesson</p>
                <p>at $time $day $timeZone</p>
                <p>All online classes with the teacher takes place in Skype: <a href='https://join.skype.com/invite/fx3ab3aMIeFq' style='font-weight: bold'>svetlana.tutoronline</a></p>
                <p>Don't forget to come to class on time</p>
                <a href='http://rusfriend.com/student-lessons' class='button' target='_blank'
   style=
        'display: block;
        width: 200px;
        height: 45px;
        background: red;
        border-radius: 10px;
        color: white;
        font-size: 16px;
        padding-top: 12px;
        box-sizing: border-box;
        text-align: center;
        text-decoration: none;
        font-family: Arial;
        margin-bottom: 10px;'
>go to my lessons</a>
                <div style='max-width: 200px; width: 100%;height: 1px;background: #777676'></div>
                <h3>Regards, Russian Friend</h3>
                </body></html>");
    $mail->addAddress($sendToEmail, $sendToName);
}

// письмо админу после  бронирования бесплатного занятия
if ($request['method'] === 'bookedFreeByUser') {
    $day = $request['data'][0]['day'];
    $time = $request['data'][0]['time'];
    $timeZone = $request['data'][0]['gmt'];
    $mail->Subject = 'Пользователь забронировал бесплатный урок';
    $mail->msgHTML("<html>
<body>
<h1><span style='color: red'>Н</span>овый беслатный урок.</h1>
<p>Пользователь <span style='color: red'>$sendToName</span>  забронировал бесплатный урок</p>
<p>$day $time $timeZone</p>
<div style='max-width: 200px; width: 100%;height: 1px;background: #777676'></div>
<h3>Regards, Russian Friend</h3>
</body></html>");
    $mail->addAddress($myEmail, $myDomen);

}

// письмо ученику после оплаты занятия
if ($request['method'] === 'confirmPayByUser') {
    $data = $request['data'];
    $array = [];
    foreach ($data as $i => &$arr) {
        // echo "<pre>"; print_r($arr);echo "</pre>";
        $day = $arr['date'];
        $time = $arr['time'];
        $timeZone = $arr['gmt'];
        $array[] = $day . ' ' . $time . ' ' . $timeZone;
    }

    for ($i = 0; $i < count($array); $i++) {
        $elem .= $array[$i] . '<br>';
    }
    $mail->Subject = 'Successfully booked';
    $mail->msgHTML(
        "<html><body>
                <h1><span style='color: red'>H</span>ello, $sendToName!</h1>
                <p>You have successfully booked a lesson at</p>
                <p>$elem</p> 
                <p>All online classes with the teacher takes place in Skype: <a href='https://join.skype.com/invite/fx3ab3aMIeFq' style='font-weight: bold'>svetlana.tutoronline</a></p>
                <p>Don't forget to come to class on time</p>
                <a href='http://rusfriend.com/student-lessons' class='button' target='_blank'
        style=
        'display: block;
        width: 200px;
        height: 45px;
        background: red;
        border-radius: 10px;
        color: white;
        font-size: 16px;
        padding-top: 12px;
        box-sizing: border-box;
        text-align: center;
        text-decoration: none;
        font-family: Arial;
        margin-bottom: 10px;'
>go to my lessons</a>
                <div style='max-width: 200px; width: 100%;height: 1px;background: #777676'></div>
                <h3>Regards, Russian Friend</h3>
                </body></html>");
    $mail->addAddress($sendToEmail, $sendToName);
}

// письмо админу после оплаты занятия учеником
if ($request['method'] === 'confirmPayByUserToAdmin') {

    $data = $request['data'];
    $array = [];
    foreach ($data as $i => &$arr) {
        // echo "<pre>"; print_r($arr);echo "</pre>";
        $day = $arr['date'];
        $time = $arr['time'];
        $timeZone = $arr['gmt'];
        $array[] = $day . ' ' . $time . ' ' . $timeZone;
    }

    for ($i = 0; $i < count($array); $i++) {
        $elem .= $array[$i] . '<br>';
    }
    $mail->Subject = 'Пользователь забронировал урок';
    $mail->msgHTML("<html>
<body>
<h1><span style='color: red'>Н</span>овый урок.</h1>
<p>Пользователь <span style='color: red'>$sendToName</span>  забронировал урок</p>
<p>$elem</p>
<div style='max-width: 200px; width: 100%;height: 1px;background: #777676'></div>
<h3>Regards, Russian Friend</h3>
</body></html>");
    $mail->addAddress($myEmail, $myDomen);
}

// письмо ученику после подтверждения оплаты учителем
if ($request['method'] === 'confirmedByTutor') {
    $day = $request['data'];
    $time = $request['time'];

    $mail->Subject = 'Payment success!';
    $mail->msgHTML(
        "<html>
<body>
<h1><span style='color: red'>H</span>ello, $sendToName!</h1>
<p>Online school of Russian as a foreign language welcomes you!</p>
<p>The teacher confirmed the payment for the booked lesson </p>
<p>$day $time</p>
<div style='max-width: 200px; width: 100%;height: 1px;background: #777676'></div>
<h3>Regards, Russian Friend</h3>
</body></html> ");
    $mail->addAddress($sendToEmail, $sendToName);
}


// Отправляем
//if ($mail->send()) {
//    echo 'Письмо отправлено!';
//} else {
//    echo 'Ошибка: ' . $mail->ErrorInfo;
//}

