<?php

namespace Classes;


class Calendar
{
    protected $dbAccess = null;
    protected $requireFields = [
        'id',
        'day',
        'time',
        'gmt'
    ];
    protected $requireFieldsForBooksTime = [
        'id',
        'name',
        'day',
        'time',
        'type',
        'confirmation',
        'price',
        'gmt',
        'payment',
        'bookingTime',
        'idFromBookstime'
    ];

    public function __construct()
    {
        $this->dbAccess = new DbAccess();
    }

    public function addTimeIntervals($request)
    {
        $times = [];
        $errors = [];
        $requestDay = "'" . trim($request['day']) . "'";
        $requestGmt = "'" . trim($request['gmt']) . "'";

        $identicalNameQuery = "DELETE FROM `time-intervals` WHERE `day` = {$requestDay}";
        $this->dbAccess->query($identicalNameQuery);

        if (trim($request['time'] === '')) {
            $identicalNameQuery = "DELETE FROM `time-intervals` WHERE `day` = {$requestDay}";
            $this->dbAccess->query($identicalNameQuery);
        }

        if (count($errors) == 0) {
            foreach ($request as $k => &$val) {
                if (!in_array($k, $this->requireFields)) {
                    unset($request[$k]);
                }
                foreach ($val as $k => $value) {
                    $times[] = $value;
                }
            }
            $requestKeys = implode(', ', array_keys($request));
            $requestTimes = "'" . implode(', ', $times) . "'";
            $query = "INSERT INTO `time-intervals` ({$requestKeys}) VALUES ({$requestDay}, {$requestTimes}, {$requestGmt});";
            $this->dbAccess->query($query);
        }
    }

    public function deleteTimeIntervals($request)
    {
        $requestDay = "'" . trim($request['day']) . "'";
        $identicalNameQuery = "DELETE FROM `time-intervals` WHERE `day` = {$requestDay}";
        $this->dbAccess->query($identicalNameQuery);
    }

    public function getTimeIntervals()
    {
        $query = "SELECT `day`, `time`, `gmt` FROM `time-intervals` WHERE 1";
        $result = mysqli_fetch_all($this->dbAccess->query($query));
        return $result;
    }

    public function returnBooksTime()
    {
        $query = "SELECT `name`, `day`, `time`, `type`, `payment`, `gmt`, `confirmation`  FROM `bookstime` WHERE 1";
        $result = mysqli_fetch_all($this->dbAccess->query($query));
        return $result;
    }

    public function addBooksTime($request)
    {
        $errors = [];
        if (count($errors) === 0) {
            foreach ($request as $i => &$arr) {
                foreach ($arr as $k => &$val) {
                    if (!in_array($k, $this->requireFieldsForBooksTime)) {
                        unset($arr[$k]);
                    }
                    if ($val != '') {
                        $val = "'" . $val . "'";
                    }
                }
                $requestKeys = implode(',', array_keys($arr));
                $requestVals = implode(',', $arr);
                $query = "INSERT INTO `bookstime` ({$requestKeys}) VALUES ({$requestVals});";
                var_dump($query);
                $result = $this->dbAccess->query($query);
            }
        }
    }

    public function getLessons()
    {

        $query = "SELECT * FROM `bookstime` WHERE 1";;
        $result = $this->dbAccess->query($query);
        $getUnpayLessons = mysqli_fetch_all($result);
        return $getUnpayLessons;
    }

    public function setToBooksTimeGMT($request)
    {
        $delete = $this->dbAccess->query('DELETE FROM `bookstime-gmt`');
        $this->dbAccess->query($delete);
        $incr = "ALTER TABLE `bookstime-gmt` AUTO_INCREMENT=0;";
        $this->dbAccess->query($incr);

        if ($delete) {
            foreach ($request as $i => &$arr) {

                foreach ($arr as $k => &$val) {
                    if (!in_array($k, $this->requireFieldsForBooksTime)) {
                        unset($arr[$k]);
                    }
                    if ($val != '') {
                        $val = "'" . $val . "'";
                    }
                }
                $requestKeys = implode(',', array_keys($arr));
                $requestVals = implode(',', $arr);
                $query = "INSERT INTO `bookstime-gmt` ({$requestKeys}) VALUES ({$requestVals});";
                $result = $this->dbAccess->query($query);
                $response = [
                    'request' => $request,
                    'success' => 'success',
                    'delete' => $delete,
                    'query' => $query];
            }
        } else {
            $response = 'Ошибка удаления интервалов';
        }
        return $response;
    }

    public function getLessonsFromBookstimeGMT()
    {
        $query = "SELECT * FROM `bookstime-gmt` WHERE 1";;
        $result = $this->dbAccess->query($query);
        $getUnpayLessons = mysqli_fetch_all($result);
        return $getUnpayLessons;
    }

    public function confirmLessons($request)
    {
//        echo "<pre>";
//        print_r($request);
//        echo "</pre>";
        $errors = [];
        foreach ($request as $k => $arr) {

            $name = $arr['name'];
            $time = $arr['time'];
            $date = $arr['date'];
            $query = "UPDATE `bookstime` SET `confirmation` = '1' WHERE `name` = '{$name}' AND `time` = '{$time}' AND `day` = '{$date}'";
            $result = $this->dbAccess->query($query);
            $errors[] = $result;
        }
        if (!in_array(false, $errors)) {
            $response = 'success';
        } else {
            $response = 'unSuccess';
        }
        return $response;
    }

    public function successPay($request)
    {
//        $name = $request['obj']['name'];
//        $time = $request['obj']['time'];
//        $date = $request['obj']['date'];
        $id = $request['obj']['id'];
//        $query = "UPDATE `bookstime` SET `payment` = 'payed' WHERE `name` = '{$name}' AND `time` = '{$time}' AND `day` = '{$date}'";
        $query = "UPDATE `bookstime` SET `payment` = 'payed' WHERE `id` = '{$id}'";
//        var_dump($query);
        $result = $this->dbAccess->query($query);
        return $result;
    }


    // ----- удалить неоплаченые уроки
    public function delUnconfirmedBooks($request)
    {
        foreach ($request as $k => &$val) {
            $name = $val['name'];
            $time = $val['time'];
            $date = $val['day'];
            $query = "DELETE FROM `bookstime` WHERE `name` = '{$name}' AND `day` = '{$date}' AND `time` = '{$time}'";
//            var_dump($query);
            $result = $this->dbAccess->query($query);
        }
        return $result;
    }

    // --------- удалить урок из БД
    public function delBooksTime($request)
    {
        $id = $request['id'];
        $query = "DELETE FROM `bookstime` WHERE `id` = '{$id}'";
        $this->dbAccess->query($query);
    }


    // ------------- получаем данные из БД с временными интервалами
    public function getFromTempGMT()
    {
        $query = "SELECT `day`, `time`, `gmt` FROM `temp-gmt` WHERE 1=1";
        $result = $this->dbAccess->query($query);
        $getTempIntervals = mysqli_fetch_all($result);
        return $getTempIntervals;
    }

    // -------------- сохраняем данные в БД с временными интервалами
    public function setToTempGMT($request)
    {
        $err = [];
        $dropID = "ALTER TABLE `temp-gmt` DROP id";
        $setID = "ALTER TABLE `temp-gmt` ADD `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
        $dropRes = $this->dbAccess->query($dropID);
        $setRes = $this->dbAccess->query($setID);
        $clearTableQuery = "DELETE FROM `temp-gmt`;";
        $clearTable = $this->dbAccess->query($clearTableQuery);
        if ($clearTable) {
            $err = [];
        } else {
            $err[] = 'не произведено удаление предыдущих записей';
        }

        if (count($err) == 0) {
            foreach ($request['intervals'] as $k => &$arr) {
                foreach ($arr as $k => &$val) {
                    if (!in_array($k, $this->requireFields)) {
                        unset($request[$k]);
                    }
                    if ($val != '') {
                        $val = "'" . $val . "'";
                    }
                }
                $requestKeys = implode(', ', array_keys($arr));
                $requestVals = implode(', ', $arr);
                $query = "INSERT INTO `temp-gmt` ({$requestKeys}) VALUES ({$requestVals});";
                $result = $this->dbAccess->query($query);
            }
        } else {
            echo $err;
        }
    }
    // --------------------------------------------------------------------


    // ------------ ФУНКЦИИ ДЛЯ УСТАНОВКИ И ПОЛУЧЕНИЯ ЦЕНЫ НА УРОКИ
    public function setPrice($request)
    {
        $query = "UPDATE `admin-data` SET `{$request['type']}` = '{$request['price']}' WHERE 1";
        $this->dbAccess->query($query);
        $result = $this->getPrice();
        return $result;
    }

    public function getPrice()
    {
        $query = "SELECT `private`, `sclub` FROM `admin-data` WHERE 1";
        $result = $this->dbAccess->query($query);
        return mysqli_fetch_assoc($result);
    }
    // --------------------------------------------------------------------
    // ---- занесение в БД admin-data часового пояса
    public function setAdminGMT($request)
    {
        $query = "UPDATE `admin-data` SET `gmt` = '{$request['gmt']}' WHERE 1";
        $this->dbAccess->query($query);
    }

}