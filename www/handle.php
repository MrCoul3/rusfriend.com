<?php
require("vendor/autoload.php");
$request = json_decode(file_get_contents('php://input'), true);
//echo "<pre>";
//print_r($request);
//echo "</pre>";

$obj = new \Classes\User();
$objCalendar = new \Classes\Calendar();
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

if ($request['method'] == 'language') {
    setcookie('btnLang', $request['btnLang']);
    setcookie('langChanger', $request['langChanger']);
}

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
//    print_r($request);
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
//   print_r($result);
    echo json_encode(($result) );
}

if ($request['method'] === 'successPay') {
    $result = $objCalendar->successPay();
}


