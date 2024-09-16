<?php


class Errors{
    private static $errors = [];
    /**
     * @param mixed $error
     * @return void
     */
    public static function addErrors($error = []): void{
        self::$errors = $error;
    }
    /**
     * @param mixed $for
     * @return string|string[]
     */
    public static function getError($for): string|array{
        foreach (self::$errors as $error) {
            if (strpos($error, $for) !== false) {
                $e = str_replace( "_", " ", $error);
                return $e;
            }
        }
        return "";
    }
}
