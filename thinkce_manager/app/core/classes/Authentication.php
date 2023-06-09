<?php

class Authentication {
    private $_db,
            $_data,
            $_sessionName,
            $_isLoggedIn,
            $_cookieName;

    public function __construct($user = null){
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');
        if(!$user){
            if(Session::exists($this->_sessionName)){
                $user = Session::get($this->_sessionName);
                if($this->find($user)){
                    $this->_isLoggedIn = true;
                }
            }
        }else{
            $this->find($user);
        }
    }

    public function create($fields){
        if(!$this->_db->insert('users',$fields)){
            throw new Exception("There was a problem in creating an account");
        }else{
            $username = Input::get("username");
            $user = $this->find($username);
            if($user){
                $hash = Hash::unique();
                Session::put($this->_sessionName,$this->data()["id"]);
                $this->_db->insert('users_session',array(
                    'user_id' => $this->data()["id"],
                    'hash'=> $hash
                ));
                Cookie::put($this->_cookieName,$hash,Config::get('remember/cookie_expiry'));
            }
        }
    }

    public function find($user = null){
        if($user){
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));

            if($data->count()){
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function login($username = null, $password = null, $remember = false){
        if(!$username && !$password && $this->exists()){
            Session::put($this->_sessionName,$this->data()["id"]);
        }else{
             $user = $this->find($username);
             $pass = $this->data()["password"];
            if($user){
                if(password_verify($password, $pass)){
                    if($remember){
                        $hash = Hash::unique();
                        $check = $this->_db->get('users_session', array('user_id', '=', $this->data()["id"]));

                        if(!$check->count()){
                            $this->_db->insert('users_session',array(
                                'user_id' => $this->data()["id"],
                                'hash'=> $hash
                            ));
                        }else{
                            $hash = $check->first()["hash"];
                        }
                        Cookie::put($this->_cookieName,$hash,Config::get('remember/cookie_expiry'));
                    }
                    Session::put($this->_sessionName,$this->data()["id"]);
                    $this->_isLoggedIn = true;
                    return true;
                }
            }
        }
        return false;
    }

    public function exists(){
        return (!empty($this->_data)) ? true : false;
    }

    public function logout(){
        $this->_db->delete('users_session', array('user_id','=',$this->data()["id"]));
        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);

    }

    public function data(){
        return $this->_data;
    }

    public function isLoggedIn(){
        return $this->_isLoggedIn;
    }

}
