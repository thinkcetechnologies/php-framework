<?php
session_start();
require_once '../config/routes.php';


$conf_file = file_get_contents("../config/env.json");

$json = json_decode($conf_file, true);

$GLOBALS['config'] = [
    'mysql' => [
        'host' => $json[0]["db"]["host"],
        'username' => $json[0]["db"]["user"],
        'password' => $json[0]["db"]["password"],
        'db' => $json[0]["db"]["db"],
    ],
    'pgsql' => [
        'host' => 'localhost',
        'username' => 'postgres',
        'password' => 'gyenyame',
            'db' => 'thinkce'
    ],
    'sqlite' => [
        'db' => "",
    ],
    'remember' => [
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800,
    ],
    'session' => [
        'session_name' => 'user',
        'token_name' => 'token'
    ],
];
spl_autoload_register(function($class){
    if(file_exists("../app/core/classes/". $class . ".php")){
        require_once '../app/core/classes/' . $class . '.php';
    }else if(file_exists("../app/core/controllers/". $class . ".php")){
        require_once '../app/core/controllers/' . $class . '.php';
    }
});



if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $check = DB::getInstance()->get('users_session',array('hash','=', $hash));
    if($check->count()) {
        $user = new Authentication($check->first()["user_id"]);
        $user->login();
    }
}
