<?php


class Auth extends Models
{
    public function create()
    {
        echo "<script>alert('". Input::get("username") ."');</script>";
    }

}