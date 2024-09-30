<?php
class Input {
    public static function exists($type = 'POST'): bool
    {
        return match ($type) {
            'POST' => !empty($_POST),
            'GET' => !empty($_GET),
            default => false,
        };
    }
    public static function get($item): string
    {
        if(isset($_POST[$item])){
            return htmlentities($_POST[$item], ENT_QUOTES, 'UTF-8');
        }else if(isset($_GET[$item])){
             return htmlentities($_GET[$item], ENT_QUOTES, 'UTF-8');
        }
        return '';
    }
}
