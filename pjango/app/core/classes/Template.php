<?php
abstract class Template{
    public function render($request, $template, $data = []){
        $tem = explode("/", $template);

        if($request == "GET"){
            return require_once $tem[0] . "/templates/" . $template . ".pjango.php";
        }elseif ($request == "POST"){
            if(empty(Input::get("csrf_token"))){
                die("CSRF TOKEN EXISTS NOT");
            }
        }
    }
}
