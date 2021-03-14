<?php


namespace Classes;


class Calendar
{
    protected $dbAccess = null;
    protected $requireFields = [
        'id',
        'day',
        'time'
    ];
    protected $requireFieldsForBooksTime = [
        'id',
        'name',
        'day',
        'time',
        'type',
        'payment'
    ];
    public function __construct()
    {
        $this->dbAccess = new DbAccess();
    }
    public function addTimeIntervals($request)
    {
        $times = [];
        $errors =[];
        $requestDay = "'" . trim($request['day']) . "'";
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
            $query = "INSERT INTO `time-intervals` ({$requestKeys}) VALUES ({$requestDay}, {$requestTimes});";
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
        $query = "SELECT `day`, `time` FROM `time-intervals` WHERE 1";
        $result = mysqli_fetch_all($this->dbAccess->query($query));
        return $result;
    }
    public function returnBooksTime()
    {
        $query = "SELECT `name`, `day`, `time`, `type`, `payment` FROM `bookstime` WHERE 1";
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

    public function successPay()
    {
        $query = "UPDATE `bookstime` SET `payment` = 'payed' WHERE `name` = '{$_SESSION['name']}'";
        var_dump($query);
        $result = $this->dbAccess->query($query);
        return $result;
    }

}