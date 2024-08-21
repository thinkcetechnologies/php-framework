<?php
class App{
    protected $app = "main";
    protected $method = "index";
    protected $params = [];

    /**
     * App constructor.
     */
    public function __construct(){
        $url = $this->parseUrl();

        if(is_array($url)) {
            if($url[0] === "admin") {
                if(isset($url[1])) {
                    if(file_exists('pjango/app/admin/controllers/' . $url[1] .".php")) {
                        $this->app = ucwords($url[1]);
                        unset($url[1]);
                    }
                }
                require_once "../app/admin/controllers/" . $this->app . ".php";
                $this->app = new $this->app;
                if(isset($url[2])) {
                    if(method_exists($this->app, $url[2])) {
                        $this->method = $url[2];
                        unset($url[2]);
                    }
                    $this->params = $url ? array_values($url) : [];
                }
            } else {
                if(file_exists( strtolower($url[0])  . "/Views.php")) {
                    $this->app = ucwords($url[0]);
                    unset($url[0]);
                }
                require_once strtolower($this->app) ."/Views.php";
                $this->app = new Views();
                if(isset($url[1])) {
                    if(method_exists($this->app, $url[1])) {
                        $this->method = $url[1];
                        unset($url[1]);
                    }
                    $this->params = $url ? array_values($url) : [];
                }
            }
        } else {
            if(file_exists( $this->app ."/Views.php")){
                require_once $this->app ."/Views.php";
                $this->app = new Views();
            }
        }
        array_unshift($this->params, $_SERVER["REQUEST_METHOD"]);
        call_user_func_array([$this->app, $this->method], $this->params);

    }
    /**
     * @return string[]|bool|string
     */
    public function parseUrl(){
        $urlPatterns = Router::urlPattern();
        $p = "";
        $url = explode("/", filter_var(url, FILTER_SANITIZE_URL),);
        foreach ($urlPatterns as $pattern) {
            foreach ($pattern as $path => $method){
                $path_split = explode("/", $path);

               if($path == $url[0]){
                   $viewMethod = explode("/", filter_var($method),);
                   return $viewMethod;
               }elseif ((strpos($path_split[0], "<") !== false) && strpos($path_split[0], ">") !== false){

               }
            }
        }
        die("Path not found");

    }

}
