<?php
class Views extends Template {
    public function index($request){
        echo "Yes ThinkCE The Genius";
    }
    public function about($request){
        $users = ["Afari", "samuel"];
         return $this->render($request, "main/about", $users);
    }
    public function contact($request){
        echo "Contact us page";
    }
    public function home($request){
        echo "Home Page";
    }
}
