<?php
class App{
    protected $controller = "main";
    protected $method = "index";
    protected $params = [];

    public function __construct(){
        $url = $this->parseUrl();

        if(is_array($url)) {
            if($url[0] === "admin") {
                if(isset($url[1])) {
                    if(file_exists('../app/admin/controllers/' . $url[1] .".php")) {
                        $this->controller = ucwords($url[1]);
                        unset($url[1]);
                    }
                }
                require_once "../app/admin/controllers/" . $this->controller . ".php";
                $this->controller = new $this->controller;
                if(isset($url[2])) {
                    if(method_exists($this->controller, $url[2])) {
                        $this->method = $url[2];
                        unset($url[2]);
                    }
                    $this->params = $url ? array_values($url) : [];
                    array_unshift($this->params, $_SERVER["REQUEST_METHOD"]);
                }
            } else {
                if(file_exists('../../'. $url[0]  . "/Views.php")) {
                    $this->controller = ucwords($url[0]);
                    unset($url[0]);
                }
                require_once "../../". $this->controller ."/Views.php";
                $this->controller = new Views();
                if(isset($url[1])) {
                    if(method_exists($this->controller, $url[1])) {
                        $this->method = $url[1];
                        unset($url[1]);
                    }
                    $this->params = $url ? array_values($url) : [];
                    array_unshift($this->params, $_SERVER["REQUEST_METHOD"]);

                }
            }

        } else {
            if(file_exists("../../". $url[0] ."/Views.php")){
                require_once "../../". $url[0] ."/Views.php";
                $this->controller = new Views();
            }

        }

        call_user_func_array([$this->controller, $this->method], $this->params);

    }
    public function parseUrl(){
        if(isset($_GET["url"])) {
            return explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL ),);
        }
        return "";

    }

}