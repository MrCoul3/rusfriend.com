<?php
require("vendor/autoload.php");
$request = json_decode(file_get_contents('php://input'), true);
//echo "<pre>";
//print_r($request['method']);
//echo "</pre>";

$obj = new \Classes\User();
$objCalendar = new \Classes\Calendar();

// --------------------- регистрация
if ($request['method'] == 'register') {
    $response = [];
    $register = $obj->addUser($request);
    $userName = $obj->getUserInfo();
    if ($register) {
        $response = [
            'success' => true,
            'name' => $userName['name']
        ];
    } else {
        $response =[
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
    $userName = $obj->getUserInfo();


    if ($login === 'admin') {
        $response = [
            'success' => true,
            'name' => $userName['name'],
            'status' => 'admin'
        ];
    }
    elseif ($login === 'user') {
        $response = [
            'success' => true,
            'name' => $userName['name'],
            'status' => 'user'
        ];

    } else {
        $response =[
            'success' => false
        ];
    }
    echo json_encode($response);
}
// -----------------------------------

// --------------------- проверка лоина при перезагрузке
if ($request['method'] == 'reload' OR $request['method'] == 'checkLoginOnBookedLesson') {
    $response = [];
    $check = $obj->checkLogin();
    $userName = $obj->getUserInfo();
    if ($check === 'admin') {
        $response = [
            'success' => true,
            'name' => $userName['name'],
            'sessionName' => $_SESSION['email'],
            'status' => 'admin'
        ];
    }
    elseif ($check === 'user') {
        $response = [
            'success' => true,
            'name' => $userName['name'],
            'sessionName' => $_SESSION['email'],
            'status' => 'user'
        ];
    }
    else {
        $response =[
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
        $response =[
            'logout' => true
        ];
    } else {
        $response =[
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
}
// -----------------------------------


if ($request['method'] == 'addTimeIntervals') {
    $objCalendar->addTimeIntervals($request);
    $timeIntervals = $objCalendar->returnTimeIntervals();
    foreach ($timeIntervals as $day=>$time) {
        $response[] = [
            'day'=>$time[0],
            'time'=>$time[1]
        ];
    }
    echo json_encode($response);
}

if ($request['method'] == 'getTimeIntervals') {
    $timeIntervals = $objCalendar->returnTimeIntervals();
    foreach ($timeIntervals as $day=>$time) {
        $response[] = [
            'day'=>$time[0],
            'time'=>$time[1]
        ];
    }
    echo json_encode($response);
}

if ($request['method'] == 'getBooksTime') {
    $timeIntervals = $objCalendar->returnBooksTime();
    foreach ($timeIntervals as $day=>$time) {
        $response[] = [
            'name'   => $time[0],
            'day'    => $time[1],
            'time'   => $time[2],
            'type'   => $time[3],
            'payment'=> $time[4]
        ];
    }
    echo json_encode($response);
}

if ($request['method'] == 'deleteTimeIntervals') {
    $deleteTimeIntervals = $objCalendar->deleteTimeIntervals($request);
}

if ($request['method'] == 'checkSkype') {
    $checkSkype = $obj->checkSkype();
    if (trim($checkSkype['skype'])  != "") {
        $response= [
            'status' => 'filled'
        ];
    } else {
        $response= [
            'status' => 'empty'
        ];
    }
    echo json_encode(($response) );
}

if ($request['method'] === 'sendSkype') {
    $addSkype = $obj->addkype($request);
}

if ($request['method'] === 'getUserInfo') {
    $getUserInfo = $obj->getUserInfo();
}

if ($request[0]['method'] === 'bookEvent') {
    $objCalendar->addBooksTime($request);
}

// получение данных для сстраницы payment.php
//if ($request['method'] === 'getLessons') {
//   $result = $objCalendar->getLessonsForThisUser();
////   print_r($result);
//    echo json_encode(($result) );
//}

if ($request['method'] === 'getLessons') {
    $result = $objCalendar->getLessons();
    echo json_encode(($result) );
}

if ($request['method'] === 'successPay') {
    $result = $objCalendar->successPay();
}

if ($request['method'] === 'delUnpayedBooks') {
    $objCalendar->delUnpayedBooks();
}

if ($request['method'] === 'getAllUsersInfo') {

    $result = $obj->getAllUsersInfo();
    $booksTime = $objCalendar->returnBooksTime();
    array_reverse($booksTime);
    $arr = [];
    foreach ($result as $k=>$val) {
        $arr[] = $val;
    }

    foreach ($arr as $k=>$val) {
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
//    echo json_encode($result);
}