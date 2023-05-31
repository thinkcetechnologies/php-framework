<?php
class Hash {
    public static function make($string){
        return password_hash($string, PASSWORD_DEFAULT);
    }
    public static function unique(){
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
