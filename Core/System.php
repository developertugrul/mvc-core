<?php


class System
{
    protected $controller;
    protected $method;

    public function __construct()
    {
        $this->controller = "main";
        $this->method = "index";

        //GET URL
        if (isset($_GET['act'])) {
            $url = explode("/", filter_var(rtrim($_GET['act'], "/"), FILTER_SANITIZE_URL));
        } else {
            $url[0] = $this->controller;
            $url[1] = $this->method;
        }

        //GET CONTROLLER
        if (file_exists(CONTROLLERS_PATH . "/" . $url[0] . ".php")) {
            $this->controller = $url[0];
            //Remove the first item from the array
            array_shift($url);
        }

        //FETCH FILE
        require_once CONTROLLERS_PATH . "/" . $this->controller . ".php";

        //GET CLASS
        if (class_exists($this->controller)) {
            $this->controller = new $this->controller;
        } else {
            exit($this->controller." sınıfı bulunamadı");
        }

        //GET METHOD
        if (isset($url[0])) {
            if (method_exists($this->controller, $url[0])) {
                $this->method = $url[0];
                array_shift($url);
            } else {
                exit($this->method." methodu bulunamadı");
            }
        }

        //This function runs the controller and method and sends the params
        call_user_func([$this->controller, $this->method], $url);
    }
}