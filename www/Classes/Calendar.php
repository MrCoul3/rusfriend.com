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
        'gmt',
        'payment'
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

    public function returnTimeIntervals()
    {
        $query = "SELECT `day`, `time`, `gmt` FROM `time-intervals` WHERE 1";
        $result = mysqli_fetch_all($this->dbAccess->query($query));
        return $result;
    }

    public function returnBooksTime()
    {
        $query = "SELECT `name`, `day`, `time`, `type`, `payment`, `gmt`  FROM `bookstime` WHERE 1";
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
                $result = $this->dbAccess->query($query);
            }
        }
    }

//    public function getLessonsForThisUser()
//    {
//        $query = "SELECT * FROM `bookstime` WHERE `name` = '{$_SESSION['name']}'";
//        $result = $this->dbAccess->query($query);
//        $getUnpayLessons = mysqli_fetch_all($result);
//        return $getUnpayLessons;
//    }

    public function getLessons()
    {
        $query = "SELECT * FROM `bookstime` WHERE 1=1";
        $result = $this->dbAccess->query($query);
        $getUnpayLessons = mysqli_fetch_all($result);
        return $getUnpayLessons;
    }

    public function successPay($request)
    {
        $name = $request['obj']['name'];
        $time = $request['obj']['time'];
        $date = $request['obj']['date'];
        $query = "UPDATE `bookstime` SET `payment` = 'payed' WHERE `name` = '{$name}' AND `time` = '{$time}' AND `day` = '{$date}'";
        $result = $this->dbAccess->query($query);
        return $result;
    }

    public function delUnpayedBooks()
    {
        $query = "DELETE FROM `bookstime` WHERE `payment` = 'unpayed'";
        $this->dbAccess->query($query);
    }

    // удалить урок
    public function delBooksTime($request)
    {
        $name = $request['name'];
        $day = $request['day'];
        $time = $request['time'];
        $query = "DELETE FROM `bookstime` WHERE `name` = '{$name}' AND `day` = '{$day}' AND `time` = '{$time}'";
        $this->dbAccess->query($query);
    }

    public function getFromTempGMT()
    {
        $query = "SELECT `day`, `time` FROM `temp-gmt` WHERE 1=1";
        $result = $this->dbAccess->query($query);
        $getTempIntervals = mysqli_fetch_all($result);
        return $getTempIntervals;
    }

    public function setToTempGMT($request)
    {
//        echo "<pre>";
//        print_r($request['intervals']);
//        echo "</pre>";
        $err = [];
        $incr = "ALTER TABLE `temp-gmt` AUTO_INCREMENT=0;";
        $query1 = "DELETE FROM `temp-gmt`;";
        $del = $this->dbAccess->query($query1);
        $reset = $this->dbAccess->query($incr);
        if ($del || $reset) {
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


}