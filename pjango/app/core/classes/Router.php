<?php
class Router{
    /**
     * @param mixed $urls
     */
    public static array $patterns = [];

    public static function urlPattern(): array
    {

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
     * @param mixed $path
     * @param mixed $view
     * @param string|null $name
     * @return array
     */
    public static function path(mixed $path, mixed $view, null|string $name = ""): array {
        return array(trim($path, "/") => $view);
    }
}
