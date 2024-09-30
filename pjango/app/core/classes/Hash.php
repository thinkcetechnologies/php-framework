<?php
class Hash {
    public static function make($string): string
    {
        return password_hash($string, PASSWORD_DEFAULT);
    }
    public static function unique(): string
    {
        return self::make(uniqid());
    }
    public static function salt(){
        try{
            return random_bytes(64);
        }catch (Exception $e){
            die($e);
        }
    }
}
