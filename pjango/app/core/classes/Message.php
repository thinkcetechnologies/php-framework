<?php
class Message{
    public static function success($message = ""): mixed
    {
        if($message == "") {
            return Session::flash('success');
        } else {
            return Session::flash('success', $message);
        }
    }
    public static function error($message = ""): mixed
    {
        if($message == "") {
            return Session::flash('error');
        } else {
            return Session::flash('error', $message);
        }
    }
    public static function warning($message = ""): mixed
    {
        if($message == "") {
            return Session::flash('warning');
        } else {
            return Session::flash('warning', $message);
        }
    }
    public static function info($message = ""): mixed
    {
        if($message == "") {
            return Session::flash('info');
        } else {
            return Session::flash('info', $message);
        }
    }
    public static function primary($message = ""): mixed
    {
        if($message == "") {
            return Session::flash('primary');
        } else {
            return Session::flash('primary', $message);
        }
    }
}