<?php
require("vendor/autoload.php");
$request = json_decode(file_get_contents('php://input'), true);
//echo "<pre>";
//print_r($request[0]['method']);
//echo "</pre>";
//var_dump($_SESSION);




$obj = new \Classes\User();
$objCalendar = new \Classes\Calendar();
//$objMailer = new \Classes\Mailer();
// --------------------- регистрация

if ($request['method'] == 'register') {
    $response = [];
    $register = $obj->addUser($request);
    $userName = $obj->getUserInfo();
    if ($register) {
        $response = [
            'success' => true,
            'name' => $userName['name'],
            'email' => $userName['email'],
        ];
    } else {
        $response = [
            'success' => false
        ];
    }
    echo json_encode($response);
}
// -----------------------------------

// --------------------- логин
if ($request['method'] == 'login') {
    $response = [];
    $login = $obj->login($request);
    $userInfo = $obj->getUserInfo();

    if ($login === 'admin') {
        $response = [
            'success' => true,
            'name' => $userInfo['name'],
            'status' => 'admin'
        ];
    } elseif ($login === 'user') {
        $response = [
            'success' => true,
            'userID' => $userInfo['id'],
            'name' => $userInfo['name'],
            'status' => 'user',
            'avatar' => $userInfo['avatar'],
            'email' => $userInfo['email'],
        ];

    } elseif ($login === 'blocked') {
        $response = [
            'success' => false,
            'status' => 'blocked'
        ];
    } else {
        $response = [
            'success' => false
        ];
    }
    echo json_encode($response);
}
// -----------------------------------

// --------------------- проверка лоина при перезагрузке
if ($request['method'] == 'reload' or $request['method'] == 'checkLoginOnBookedLesson') {
    $response = [];
    $check = $obj->checkLogin();
    $userInfo = $obj->getUserInfo();
    if ($userInfo !== null) {
        if ($userInfo['status'] === 'blocked') {
            $obj->logout();
        }
    }
//    $_SESSION['isActive'] = $userInfo['status'];
    if ($check === 'admin') {
        $response = [
            'success' => true,
            'name' => $userInfo['name'],
            'sessionName' => $_SESSION['email'],
            'status' => 'admin'
        ];
    } elseif ($check === 'user') {
        $response = [
            'success' => true,
            'name' => $userInfo['name'],
            'sessionName' => $_SESSION['email'],
            'status' => 'user',
            'status_2' => $userInfo['status'], // new / active / blocked
            'avatar' => $userInfo['avatar'],
        ];
    } else {
        $response = [
            'success' => false
        ];
    }
    echo json_encode($response);
}
// -----------------------------------

// --------------------- логаут
if ($request['method'] == 'logout') {
    $logout = $obj->logout();
    if ($logout) {
        $response = [
            'logout' => true
        ];
    } else {
        $response = [
            'logout' => false
        ];
    }
    echo json_encode($response);
}
// -----------------------------------


// --------------------- установка куки при смене языка
if ($request['method'] == 'language') {
    setcookie('btnLang', $request['btnLang']);
    setcookie('langChanger', $request['langChanger']);
    if ($request['btnLang'] === 'eng-lang') {
        $response = 'eng-lang';
    } else {
        $response = 'rus-lang';
    }
    echo json_encode($response);
}
// -----------------------------------


if ($request['method'] == 'addTimeIntervals') {
  $res= $objCalendar->addTimeIntervals($request);
    $timeIntervals = $objCalendar->returnTimeIntervals();
    foreach ($timeIntervals as $day => $time) {
        $response[] = [
            'day' => $time[0],
            'time' => $time[1],
            'gmt' => $time[2],
        ];
    }
    echo json_encode($response);
}

if ($request['method'] == 'getTimeIntervals') {
    $timeIntervals = $objCalendar->returnTimeIntervals();
    foreach ($timeIntervals as $day => $time) {
        $response[] = [
            'day' => $time[0],
            'time' => $time[1],
            'gmt' => $time[2],
        ];
    }
    echo json_encode($response);
}

if ($request['method'] == 'getBooksTime') {
    $timeIntervals = $objCalendar->returnBooksTime();
    foreach ($timeIntervals as $day => $time) {
        $response[] = [
            'name' => $time[0],
            'day' => $time[1],
            'time' => $time[2],
            'type' => $time[3],
            'payment' => $time[4],
            'gmt' => $time[5],
            'confirmation' => $time[6],
        ];
    }
    echo json_encode($response);
}

if ($request['method'] == 'deleteTimeIntervals') {
    $deleteTimeIntervals = $objCalendar->deleteTimeIntervals($request);
}

if ($request['method'] == 'checkSkype') {
    $checkSkype = $obj->checkSkype();
    if (trim($checkSkype['skype']) != "") {
        $response = [
            'status' => 'filled'
        ];
    } else {
        $response = [
            'status' => 'empty'
        ];
    }
    echo json_encode(($response));
}

if ($request['method'] === 'sendSkype') {
    $addSkype = $obj->addkype($request);
}

if ($request['method'] === 'getUserInfo') {
    $getUserInfo = $obj->getUserInfo();
    echo json_encode($getUserInfo);
}

if ($request[0]['method'] === 'bookEvent') {
    $objCalendar->addBooksTime($request);
}


if ($request['method'] === 'getLessons') {
    $result = $objCalendar->getLessons();
    echo json_encode(($result));
}

if($request[0]['method'] === 'setToBooksTimeGMT') {
    $result = $objCalendar->setLessonsToBookstimeGMT($request);
    echo json_encode(($result));
}

if($request[0]['method'] === 'getLessonsFromBookstimeGMT' OR $request['method'] === 'getLessonsFromBookstimeGMT') {
    $result = $objCalendar->getLessonsFromBookstimeGMT();
    echo json_encode(($result));
}


// ------ изменить статус confirmation на 1: click on btn [confirm payment]
if ($request[0]['method'] === 'confirmLessons') {
    $result = $objCalendar->confirmLessons($request);
    echo json_encode(($result));
}

// ------ удаление неоплаченного бронирования нажатие на
// кнопку [cancel a lesson] в меню unconfirmed-menu-frame
if ($request[0]['method'] === 'delUnconfirmedBooks') {
    $result = $objCalendar->delUnconfirmedBooks($request);
    echo json_encode(($result));
}

if ($request['obj']['method'] === 'successPay') {
    $result = $objCalendar->successPay($request);
    if ($result) {
        $response = [
            'payment'=>'success'
        ];
    } else {
        $response = [
            'payment'=>'failed status change'
        ];
    }
    echo json_encode(($response));
}



if ($request['method'] === 'getAllUsersInfo') {

    $result = $obj->getAllUsersInfo();
    $booksTime = $objCalendar->returnBooksTime();
    array_reverse($booksTime);
    $arr = [];
    foreach ($result as $k => $val) {
        $arr[] = $val;
    }

    foreach ($arr as $k => $val) {
        foreach ($booksTime as $item) {
//            print_r($item[0]);
            if ($item[0] === $val['name']) {
//                print_r($arr[$k]['name']);
                // в массив добавляется последний элемент из БД, а надо первый
                $arr[$k]['date'] = $item[1];
                $arr[$k]['time'] = $item[2];
            }
        }
    }
//    echo "<pre>";
//    print_r($arr);
//    echo "</pre>";

    echo json_encode($arr);
}

if ($request['method'] === 'getUserSkype') {
    $result = $obj->getUserSkype($request);
    echo json_encode($result);
}

if ($request['method'] === 'delBooksTime') {
    $result = $objCalendar->delBooksTime($request);
}

if ($request['method'] === 'blockUser') {
    $result = $obj->blockUser($request);
    echo $result;
}

if ($request['method'] === 'unBlockUser') {
    $result = $obj->unBlockUser($request);
    echo $result;
}


// ------------- SETTINGS --------------- \\

if ($request['method'] === 'changeSettings') {
    $result = $obj->changeSettings($request);
    echo json_encode($result);
}

if ($request['method'] === 'delAvatar') {
    $result = $obj->delAvatar();
    $del =  unlink($_SERVER['DOCUMENT_ROOT']. $request['path']);
    $delMax =  unlink($_SERVER['DOCUMENT_ROOT']. $request['pathMax']);
    if ($del AND $delMax) {
        $response = 'success';
    } else {
        $response ='error';
    }
    echo json_encode($response);

}
//--------------------------------------------  end settings


// ----- изменить статус new На active при оплате занятия
if ($request['method'] === 'changeSatusOnActive') {
    $obj->changeSatusOnActive();
}




// -------- обработчики для изменения часового пояса
// добавление интервалов, которые необходимо перенести на
// другой день в БД
if ($request['method'] === 'setToTempGMT') {
    $result = $objCalendar->setToTempGMT($request);
    echo $result;
}

if ($request['method'] === 'getFromTempGMT') {
    $result = $objCalendar->getFromTempGMT();
    echo json_encode($result);
}

// ----- отправка писем

if ($request['method'] === 'sendEmail') {
//    $send = $objMailer->sendMail($request);

}

// ------ получение цены
if ($request['method'] === 'getPrice') {
    $result = $objCalendar->getPrice();
    echo json_encode($result);
}
// ------ изменение  цены
if ($request['method'] === 'setPrice') {
    $result = $objCalendar->setPrice($request);
    echo json_encode($result);
}
// ---- занесение в БД admin-data часового пояса
if ($request['method'] === 'adminPanelReload') {
    $result = $objCalendar->setAdminGMT($request);
}

