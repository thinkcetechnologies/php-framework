<?php
class Views extends Template {
    public function index($request){
        echo "Yes ThinkCE The Genius";
    }
    public function about($request): mixed{
        $users = ["Afari", "samuel"];
        return $this->render($request, "main/about", $users);
    }
    public function contact($request, $path, $id){
        echo "Contact us page {$path} {$id}";
    }
    public function home($request){
        echo "Home Page";
    }
}
