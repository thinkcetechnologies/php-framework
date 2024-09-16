<?php
class Router{
    /**
     * @param mixed $urls
     */
    public static $patterns = [];

    public static function urlPattern(){
        foreach (apps as $app) {
            include_once $app . "/urls.php";
            foreach ($urlpatterns as $urlpattern) {
                foreach($urlpattern as $key => $value){
                    $viewMethod = strtolower($app) . "/" . $value;
                    $urlpattern[$key] = $viewMethod;
                }
                array_unshift(self::$patterns, $urlpattern);
            }
        }
        return self::$patterns;
    }

    public static function resolveUrl():void{
        self::urlPattern();
        foreach (self::$patterns as $pattern) {
            echo "<pre>";
                print_r($pattern);
            echo "</pre>";
        }
    }
    /**
     * @return array
     * @param mixed $path
     * @param mixed $view
     * @param mixed $name
     */
    public static function path($path, $view, $name = ""): array {
        return array(trim($path, "/") => $view);
    }
}
