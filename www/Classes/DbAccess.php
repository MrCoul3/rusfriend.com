<?php
namespace Classes;

class DbAccess
{
    protected $mysqli = '';
    function __construct()
    {
        $this->mysqli = new \mysqli('localhost', 'root', 'asd8731ds^8243#Asf!', 'russian-friend');
    }
    public function query($query)
    {
        return $this->mysqli->query($query);
    }
}