<?php

class Authentication {
    private $_db,
            $_data,
            $_sessionName,
            $_isLoggedIn,
            $_cookieName;
    /**
     * @param mixed $user
     */
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
    /**
     * @param mixed $fields
     * @return void
     * @throws
     */
    public function create($fields): void{
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
    /**
     * @param mixed $user
     * @return bool
     */
    public function find($user = null): bool{
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
    /**
     * @param mixed $username
     * @param mixed $password
     * @param mixed $remember
     * @return bool
     */
    public function login($username = null, $password = null, $remember = false): bool{
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

    /**
     * @return bool
     */
    public function exists(): bool{
        return (!empty($this->_data)) ? true : false;
    }
    /**
     * @return void
     */
    public function logout(): void{
        $this->_db->delete('users_session', array('user_id','=',$this->data()["id"]));
        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);

    }

    /**
     * @return mixed
     */
    public function data(){
        return $this->_data;
    }

    /**
     * @return bool
     */
    public function isLoggedIn(){
        return $this->_isLoggedIn;
    }

}
