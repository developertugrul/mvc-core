<?php


class model
{
    public $db;
    function __construct()
    {
        try {
            $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8",DB_USERNAME,DB_PASSWORD);
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }
}