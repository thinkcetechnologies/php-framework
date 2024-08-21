<?php
class AjaxSearch
{
    private $_pdo,
            $_data,
            $_user;
    public function __construct()
    {
        $this->_pdo = DB::getInstance();
        $this->_user = new Authentication();
    }
    public function checkIfUserExist($username)
    {
        $result = $this->_user->find($username);
        if($result)
        {
            return true;
        }
        return false;
    }
}