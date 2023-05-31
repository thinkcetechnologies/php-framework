<?php


class Controller{
    public function model($app, $model){
        if(file_exists('../../' . $app . '/models/' . $model .'.php')) {
            require_once '../../' . $app . '/models/' . $model .'.php';
        }
        return new $model();
    }
    public function adminModel($model){
        if(file_exists('../app/admin/models/' . $model .'.php')) {
            require_once '../app/admin/models/' . $model .'.php';
        }
        return new $model();
    }

    public function render($request, $view, $data = []){
        $var = explode("/", $view);
        if(file_exists('../../' . $var[0] .'/templates/' . $view . '.php')) {
            require_once '../../' . $var[0] . '/templates/' . $view . '.php';
        }
//        require_once '../../' . $var[0] . '/templates/' . $view . '.php';
    }
    public function adminView($view, $data = []){
        if (file_exists('../app/admin/views/' . $view . '.php')) {
            $this->layout(HEADERLAYOUT);
            require_once '../app/admin/views/' . $view . '.php';
            $this->layout(FOOTERLAYOUT);
        }
    }

    public function layout($layout){
        if(file_exists('../views/' . $layout . '.php')) {
            require_once '../views/' . $layout . '.php';
        }
    }
}