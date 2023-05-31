<?php


class Home extends Controller
{
    public function index()
    {
        echo "OK";
        $this->adminView("home/admin");
    }

}