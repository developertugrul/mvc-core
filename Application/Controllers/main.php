<?php


class main extends controller
{
    function index()
    {
        $this->render("index", ["name" => "Yıldırım", "surname" => "Tuğrul"]);
    }
}