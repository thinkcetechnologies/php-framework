<?php
class Cookie {
    /**
     * @param mixed $name
     * @return bool
     */
    public static function exists(mixed $name): bool{
        return isset($_COOKIE[$name]);
    }
    /**
     * @param mixed $name
     * @return string
     */
    public static function get(mixed $name): string
    {
        return $_COOKIE[$name];
    }
    /**
     * @param mixed $name
     * @param mixed $value
     * @param mixed $expiry
     * @return bool
     */
    public static function put(mixed $name, mixed $value, mixed $expiry): bool {
        if(setcookie($name, $value, time() + $expiry, '/')){
            return true;
        }
        return false;
    }
    /**
     * @param mixed $name
     * @return void
     */
    public static function delete(mixed $name): void{
        self::put($name,'', time() - 1);
    }
}
