<?php
namespace Classes;

class DbAccess
{
    protected $mysqli = '';
    function __construct()
    {
        $this->mysqli = new \mysqli('localhost', 'mysql', 'mysql', 'russian-friend');
    }
    public function query($query)
    {
        return $this->mysqli->query($query);
    }
}