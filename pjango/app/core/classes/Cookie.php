<?php
class Cookie {
    /**
     * @param mixed $name
     * @return bool
     */
    public static function exists($name): bool{
        return (isset($_COOKIE[$name])) ? true : false;
    }
    /**
     * @param mixed $name
     * @return string
     */
    public static function get($name){
        return $_COOKIE[$name];
    }
    /**
     * @param mixed $name
     * @param mixed $value
     * @param mixed $expiry
     * @return bool
     */
    public static function put($name, $value, $expiry): bool {
        if(setcookie($name, $value, time() + $expiry, '/')){
            return true;
        }
        return false;
    }
    /**
     * @param mixed $name
     * @return void
     */
    public static function delete($name): void{
        self::put($name,'', time() - 1);
    }
}
