<?php
require("vendor/autoload.php");

// ------- croppie
$uploaddir = 'images/user-avatars/';
$userID = $_REQUEST['user_id'];
setcookie('user_id', $userID);
$obj = new \Classes\User();
$str  = str_random(8);
if(isset($_POST['photo'])) {

    $arr = [];
    if($_POST['photo']) {
        $userID = $_REQUEST['user_id'];
        $file = $str . '_' . $_COOKIE['user_id'] .'_min.png';
        $uploadfile = $uploaddir . $file;

        $img = str_replace('data:image/png;base64,', '', $_POST['photo']);
        $img = str_replace(' ', '+', $img);
        $fileData = base64_decode($img);

        $url = $uploadfile;
        file_put_contents($url, $fileData);

        $arr['status'] = 'success';
        $arr['path_mini'] = '/'.$uploadfile;
        $arr['file_mini'] = $file;
        $request = $arr['path_mini'];
        $res = $obj->addAvatar($request);

    }
}
else {
    $type = explode('/', $_FILES['file']['type'])[1];
//    $uploadfile = $uploaddir . basename($_FILES['file']['name']);
    $uploadfile = $uploaddir . $str . '_' . $userID . '.' . $type;
    $arr = array();
    //crop
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
        $arr['status'] = 'success';
        $arr['path_max'] = '/'.$uploadfile;
        $arr['file_max'] = $userID . '.' . $type;
    } else {
        $arr['status'] = 'fail';
    }
}

function str_random($length) {
    return substr(md5(microtime()),0,$length);
}
header('Content-type: application/json');
echo json_encode($arr);
exit();
// -----------------------------