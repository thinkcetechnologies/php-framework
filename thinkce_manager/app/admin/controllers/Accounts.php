<?php


class Accounts extends Controller
{
    public function login()
    {
        $model = $this->adminModel('Auth');
        $model->create($_POST);
        $this->adminView("auth/login");
    }
    public function create()
    {
        $this->adminView("auth/register");
    }
    public function index()
    {
        $this->adminView('home/admin');
    }
}