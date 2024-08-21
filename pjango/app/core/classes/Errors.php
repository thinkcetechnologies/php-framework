<?php


class Errors{
    private static $errors = [];

    public static function addErrors($error = []){
        self::$errors = $error;
    }

    public static function getError($for){
        foreach (self::$errors as $error) {
            if (strpos($error, $for) !== false) {
                $e = str_replace( "_", " ", $error);
                return $e;
            }
        }
        return "";
    }
}
