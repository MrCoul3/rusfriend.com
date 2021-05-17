<?php

namespace Classes;
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require './phpmailer/PHPMailer.php';
require './phpmailer/SMTP.php';
require './phpmailer/Exception.php';

class User
{

    protected $dbAccess = null;
    protected $requireFieldsforUsers = [
        'id',
        'name',
        'password',
        'email',
        'skype',
        'register',
        'status',
        'avatar'
    ];

    protected $adminEmails = [
        'mr.coul@inbox.ru',
        'svetlanatotr@inbox.ru'
    ];

    public function __construct()
    {
        $this->dbAccess = new DbAccess();
    }
//    function getCode()
//    {
//        return $code = rand(1000, 9999);
//    }

    function getPassHash($userPassword)
    {
        $sold = '1asd173sh';
        $hashString = $userPassword . $sold;
//        return md5(md5(trim($hashString)));
        return hash('sha256',trim($hashString));
    }

    public function addUser($request)
    {
        $err = [];

        if (!preg_match("/^[а-яА-ЯёЁa-zA-Z0-9]+$/", $request['name'])) {
            if (isset($_COOKIE['btnLang'])) {
                if ($_COOKIE['btnLang'] === 'eng-lang') {
                    $err[] = "The login can only consist of letters and numbers";
                } else {
                    $err[] = "Логин может состоять только из букв и цифр";
                }
            } else {
                $err[] = "The login can only consist of letters and numbers";
            }
        }

        if (strlen($request['name']) < 3 or strlen($request['name']) > 30) {
            if (isset($_COOKIE['btnLang'])) {
                if ($_COOKIE['btnLang'] === 'eng-lang') {
                    $err[] = "The name can be from 3 to 30 characters";
                } else {
                    $err[] = "имя может быть от 3 до 30 символов";
                }
            } else {
                $err[] = "The name can be from 3 to 30 characters";
            }
        }

        $identicalNameQuery = "SELECT id FROM users WHERE email = '{$request['email']}'";
//        var_dump(mysqli_fetch_assoc($this->dbAccess->query($identicalNameQuery)));
        if ((int)mysqli_num_rows($this->dbAccess->query($identicalNameQuery)) > 0) {
            if (isset($_COOKIE['btnLang'])) {
                if ($_COOKIE['btnLang'] === 'eng-lang') {
                    $err[] = "A user with this email already exists";
                } else {
                    $err[] = "Пользователь с таким email уже существует";
                }
            } else {
                $err[] = "A user with this email already exists";
            }
        }
//        var_dump(count($err) === 0);

        if (count($err) === 0) {
            $_SESSION = array(
                'email' => $request['email'],
                'name' => $request['name'],
                'isActive'=>'active',
            );
            foreach ($request as $k => &$val) {
                if (!in_array($k, $this->requireFieldsforUsers)) {
                    unset($request[$k]);
                }

                if ($k === 'password') {
                    $val = $this->getPassHash($val);
                }

                if ($val != '') {
                    $val = "'" . $val . "'";
                }

            }

            $requestKeys = implode(',', array_keys($request));
            $requestVals = implode(',', $request);
            $registerQuery = "INSERT INTO `users` ({$requestKeys}) VALUES ({$requestVals});";
//            var_dump($registerQuery);
            $this->dbAccess->query($registerQuery);
            return 'success';
        } else {
            return $err;
        }
    }

    public function login($request)
    {
        $query = "SELECT  * FROM users WHERE email = '{$request['email']}'";
        $result = $this->dbAccess->query($query);
        $dataFromDB = mysqli_fetch_assoc($result);
        // проверка на блокировку пользователя
        if ($dataFromDB['status'] !== 'blocked') {
            if ($dataFromDB['password'] === $this->getPassHash($request['password'])) {
                $_SESSION = array(
                    'user_id' => $dataFromDB['id'],
                    'email' => $dataFromDB['email'],
                    'name' => $dataFromDB['name'],
                    'isActive'=>$dataFromDB['status'],
                );
                if (in_array($dataFromDB['email'], $this->adminEmails)) {
                    $_SESSION['status'] = 'admin';
                    return 'admin';
                } else {
                    $_SESSION['status'] = 'user';
                    return 'user';
                }
            }
        } else {
            return 'blocked';
        }

    }


    public function checkLogin()
    {
            if (isset($_SESSION['email'])) {
                if (in_array($_SESSION['email'], $this->adminEmails)) {
                    $_SESSION['status'] = 'admin';
                    return 'admin';
                } else {
                    $_SESSION['status'] = 'user';
                    return 'user';
                }
            }


    }

    public function logout()
    {
        session_destroy();
        return true;
    }

    public function checkSkype()
    {
        if (isset($_SESSION['email'])) {
            $query = "SELECT `skype` FROM `users` WHERE email = '{$_SESSION['email']}'";
            $result = $this->dbAccess->query($query);
            $getSkype = mysqli_fetch_assoc($result);
        } else {
            $getSkype = null;
        }

        return $getSkype;
    }

    public function addkype($request)
    {
        $errors = [];
        if (trim($request['skype']) == '') {
            $errors[] = 'поле не может быть пустым';
        }
        if (count($errors) == 0) {
            $query = "UPDATE `users` SET `skype` = '{$request['skype']}' WHERE email = '{$_SESSION['email']}'";
            $result = $this->dbAccess->query($query);
            return $result;
        }

    }

    public function getUserInfo()
    {
        if (isset($_SESSION['email'])) {
            $query = "SELECT * FROM `users` WHERE email = '{$_SESSION['email']}'";
            $result = $this->dbAccess->query($query);
            $getUserInfo = mysqli_fetch_assoc($result);
            $_SESSION['name'] = $getUserInfo['name'];
        } else {
            $getUserInfo = null;
        }

        return $getUserInfo;
    }

    public function getAllUsersInfo()
    {
        $query = "SELECT `name`, `email`, `skype`, `status`, `avatar`  FROM `users` WHERE `status` != 'admin'";
        $result = $this->dbAccess->query($query);
        return $result;
//        $getUsersInfo = mysqli_fetch_assoc($result);
//        return $getUsersInfo;
    }

    public function getUserSkype($request)
    {
        $query = "SELECT `skype` FROM `users` WHERE `name` = '{$request['name']}'";
        $result = $this->dbAccess->query($query);
        $getUserSkype = mysqli_fetch_assoc($result);
        return $getUserSkype;
    }

//    public function getUserName()
//    {
//        $query = "SELECT `name` FROM `users` WHERE id = '{$_SESSION['user_id']}' OR email = '{$_SESSION['email']}'";
//        $result = $this->dbAccess->query($query);
//        $getUserName = mysqli_fetch_assoc($result);
//        $_SESSION['username'] = $getUserName['name'];
//        return $getUserName;
//    }

    // заблокировать пользователя
    public function blockUser($request)
    {
        $query = "UPDATE `users` SET `status` = 'blocked' WHERE `email` = '{$request['email']}'";
        $result = $this->dbAccess->query($query);
        return 'blocked';
    }

    public function unBlockUser($request)
    {
        $query = "UPDATE `users` SET `status` = 'active' WHERE `email` = '{$request['email']}'";
        $result = $this->dbAccess->query($query);
        return 'active';
    }

    public function mailSend($sendToEmail, $sendToName, $mailText)
    {
        $sendToEmail = $sendToEmail;  // почта получателя
        $sendToName = $sendToName;  // имя получатлея
        $myEmail = 'svetlana.tutoronline@gmail.com';    // почта отправителя
        $myDomen = 'rusfriend.com';         // хост отправителя
        $mail = new PHPMailer();
        $mail->isSMTP();                    // Отправка через SMTP
//            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->CharSet = "UTF-8";
        $mail->Host = 'smtp.gmail.com';     // Адрес SMTP сервера
        $mail->SMTPAuth = true;             // Enable SMTP authentication
//            $mail->Username = 'svetlana.tutoronline';       // ваше имя пользователя (без домена и @)
        $mail->Username = 'svetlana.tutoronline@gmail.com';       // ваше имя пользователя (без домена и @)
        $mail->Password = '252525st';       // ваш пароль
        $mail->SMTPSecure = 'tls';       // шифрование ssl
        $mail->Port = 587;                  // порт подключения
        $mail->setFrom($myEmail, $myDomen); // от кого
        $mail->addAddress($sendToEmail, $sendToName);
        $mail->Subject = 'Confirmation code';
        $mail->msgHTML($mailText);

        if ($mail->send()) {
//            return $mail->send();
//                echo 'Письмо отправлено!';
        } else {
            echo 'Ошибка: ' . $mail->ErrorInfo;
        }
    }

    // ------------- SETTINGS

    public function changeSettings($request)
    {
        if ($request['dataType'] === 'password') {
            $oldPasswordEncode = $this->getPassHash($request['old']); // шифрование введенного старого пароля
            $newPasswordEncode = $this->getPassHash($request['data']); // шифрование введенного нового пароля
            $query = "SELECT `{$request['dataType']}` FROM `users` WHERE `id` = '{$_SESSION['user_id']}'";
            $passwordFromDBEncode = mysqli_fetch_assoc($this->dbAccess->query($query));  // получение старого пароля из БД
            // если пароли не совпадают возвращаем 'invalid password'
            if ($oldPasswordEncode !== $passwordFromDBEncode['password']) {
                return 'invalid password';
            } else {
                $query = "UPDATE `users` SET `{$request['dataType']}` = '{$newPasswordEncode}' WHERE `id` = '{$_SESSION['user_id']}'";
                $this->dbAccess->query($query);
                return 'success';
            }

        } elseif ($request['dataType'] === 'email') {
            $_SESSION['newEmail'] = $request['data'];
            $code = rand(1000, 9999);
            $_SESSION['code'] = $code;
            $confCode = $_SESSION['code'];

            $sendToEmail = $request['data'];
            $sendToName = $request['name'];
            $mailBody =
                "<html>
<body>
<h1><span style='color: red'>H</span>ello, $sendToName!</h1>
<p>Your confirmation code: <span style='font-weight: bold'>$confCode</span></p>
<div style='max-width: 200px; width: 100%;height: 1px;background: #777676'></div>
<h3>Regards, Russian Friend</h3>
</body></html> ";
            $this->mailSend($sendToEmail, $sendToName, $mailBody);

            $response = [
                'status' => 'unconfirmed',
            ];
            return $response;

        } elseif ($request['dataType'] === 'confirm-code') {
            // если введенный код совпадает
            if ($request['data'] == $_SESSION['code']) {
                // присваиваем значение email текущей сессии новый емаил
                $_SESSION['email'] = $_SESSION['newEmail'];
//                var_dump('email ' . $_SESSION['email']);
                $response = [
                    'status' => 'confirmed',
                    'email'=> $_SESSION['newEmail'],
                ];
                $query = "UPDATE `users` SET `email` = '{$_SESSION['email']}' WHERE `id` = '{$_SESSION['user_id']}'";
                $this->dbAccess->query($query);
                return $response;
            } else {
                $_SESSION['newEmail'] = '';
                $response = [
                    'status' => 'invalid-code',
                ];
            }
            return $response;

        } else {
            $query = "UPDATE `users` SET `{$request['dataType']}` = '{$request['data']}' WHERE `id` = '{$_SESSION['user_id']}'";
            $this->dbAccess->query($query);
            $checkQuery = "SELECT `{$request['dataType']}` FROM `users` WHERE `id` = '{$_SESSION['user_id']}'";
            $check = mysqli_fetch_all($this->dbAccess->query($checkQuery));
            if ($check[0][0] === $request['data']) {


                if ($request['dataType'] === 'name') {
                    $_SESSION['name'] = $request['data'];
                }

//                if ($request['dataType'] === 'email') {
//                    $_SESSION['email'] = $request['data'];
//
//                }

                $response = [
                    'name' => $request['data'],
                    'type' => $request['dataType'],
                    'status' => 'success'
                ];

                return $response;
            } else {
                return 'error';
            }
        }
    }

    public function addAvatar($request)
    {
        $query = "UPDATE `users` SET `avatar` = '{$request}' WHERE `email` = '{$_SESSION['email']}'";
        $this->dbAccess->query($query);
    }
    public function delAvatar()
    {
        $query = "UPDATE `users` SET `avatar` = '' WHERE `email` = '{$_SESSION['email']}'";
        $this->dbAccess->query($query);
    }
    // ------------------------------------------------------------------------

    // ----- изменить статус new На active при оплате занятия
    public function changeSatusOnActive()
    {
        $query = "UPDATE `users` SET `status` = 'active' WHERE `email` = '{$_SESSION['email']}'";
        $this->dbAccess->query($query);
    }



}

