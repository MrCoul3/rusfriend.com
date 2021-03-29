<?php
namespace Classes;
session_start();
class User
{
    protected $dbAccess = null;
    protected $requireFieldsforUsers = [
        'id',
        'name',
        'password',
        'email',
        'skype',
        'status'
    ];

    protected $adminEmails = [
        'mr.coul@inbox.ru',
        'svetlanatotr@inbox.ru'
    ];

    public function __construct()
    {
        $this->dbAccess = new DbAccess();
    }

    function getPassHash($userPassword)
    {
        $sold = '1asd173sh';
        $hashString = $userPassword . $sold;
        return md5(md5(trim($hashString)));
    }

    public function addUser($request)
    {
        $err = [];

        if (!preg_match("/^[а-яА-ЯёЁa-zA-Z0-9]+$/", $request['name'])) {
            $err[] = "Логин может состоять только из букв и цифр";
        }

        if (strlen($request['name']) < 3 or strlen($request['name']) > 30) {
            $err[] = "имя может быть от 3 до 30 символов";
        }

        $identicalNameQuery = "SELECT id FROM users WHERE email = '{$request['email']}'";
        if (mysqli_num_rows($this->dbAccess->query($identicalNameQuery)) > 0) {
            $err[] = "Пользователь с таким email уже существует";
        } else {
            $err = [];
        }

        if (count($err) == 0) {
            $_SESSION['email'] = $request['email'];

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
            $this->dbAccess->query($registerQuery);
            return true;
        }
    }

    public function login($request)
    {
        $query = "SELECT  * FROM users WHERE email = '{$request['email']}'";
        $result = $this->dbAccess->query($query);
        $dataFromDB = mysqli_fetch_assoc($result);

        if ($dataFromDB['password'] === $this->getPassHash($request['password'])) {
            $_SESSION = array(
                'user_id' => $dataFromDB['id'],
                'email' => $dataFromDB['email'],
                'name' => $dataFromDB['name']
            );
            if (in_array($dataFromDB['email'], $this->adminEmails)) {
                $_SESSION['status'] = 'admin';
                return 'admin';
            } else {
                $_SESSION['status'] = 'user';
                return 'user';
            }
        }
    }


    public function checkLogin()
    {
//        if (isset($_SESSION['user_id'])) {
//            return $_SESSION['user_id'];
//        }
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
//        $_SESSION = [];
        session_destroy();
        return true;
    }

    public function checkSkype()
    {
        $query = "SELECT `skype` FROM `users` WHERE email = '{$_SESSION['email']}'";
        $result = $this->dbAccess->query($query);
        $getSkype = mysqli_fetch_assoc($result);
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
        $query = "SELECT * FROM `users` WHERE email = '{$_SESSION['email']}'";
        $result = $this->dbAccess->query($query);
        $getUserInfo = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $getUserInfo['name'];
        return $getUserInfo;
    }
    public function getAllUsersInfo()
    {
        $query = "SELECT `name`, `email`, `skype`, `status` FROM `users` WHERE 1=1";
        $result = $this->dbAccess->query($query);
        return $result;
//        $getUsersInfo = mysqli_fetch_assoc($result);
//        return $getUsersInfo;
    }
    public function getUserSkype($request)
    {
        $query = "SELECT `skype` FROM `users` WHERE `name` = '{$request['name']}'";
        $result = $this->dbAccess->query($query);
        $getUserSkype =  mysqli_fetch_assoc($result);
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

    // ------------- SETTINGS

    public function changeSettings($request)
    {
        $errors = [];

        if ($request['dataType'] === 'password') {
            // --------ПРОВЕРКА СТАРОГО ПАРОЛЯ
            $oldPasswordEncode = $this->getPassHash($request['old']); // шифрование введенного старого пароля
            $query = "SELECT `{$request['dataType']}` FROM `users` WHERE `email` = '{$_SESSION['email']}'"; // запрос на получение пароля из БД
            $passwordFromDBEncode = mysqli_fetch_assoc($this->dbAccess->query($query));  // получение старого пароля из БД
//            var_dump($oldPasswordEncode);
//            var_dump($passwordFromDBEncode['password']);
            if ($oldPasswordEncode !== $passwordFromDBEncode['password']) {
                $errors[] = 'пароли не совпадают';
            }
        }
        //                          `password`
        //  "UPDATE `users` SET `{$request['dataType']}` = '{$request['data']}' WHERE `email` = '{$_SESSION['email']}'";
        if (empty($errors)) {
            $query = "UPDATE `users` SET `{$request['dataType']}` = '{$request['data']}' WHERE `email` = '{$_SESSION['email']}'";
            $this->dbAccess->query($query);
        }

//        $checkQuery = "SELECT `{$request['dataType']}` FROM `users` WHERE `email` = '{$_SESSION['email']}'";
//        $check = mysqli_fetch_assoc($this->dbAccess->query($checkQuery));
        //---------------- проверка имени пользователя
        if ($request['dataType'] === 'name') {
            $response = [];
            if ($check['name'] === $request['data']) {
                $_SESSION['name'] = $check['name'];
                $response = [
                    'name'=>$check['name'],
                    'type'=>'name',
                    'status'=>'success'
                ];
                return $response;
            } else {
                return 'error';
            }
        }


    }

}

