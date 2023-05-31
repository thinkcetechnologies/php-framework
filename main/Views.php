<?php
class Views extends Controller {
    public function index(){
        echo "Yes ThinkCE The Genius";
    }

    public function about($request){

        $model = $this->model("main", "Bookmark");
        if($request == "POST"){
            $url = Input::get("url");
            $name = Input::get("name");
            $user_id = Input::get("user_id");
            $data = [
                $model->url => $url,
                $model->user_id => $user_id,
                $model->name => $name,
            ];
            $model->save($data);
            echo "Okkkk";
        }
        $var = explode("/", Input::get("url"));
        print_r($var);
        $this->render( $request,"main/index.thinkce");
    }
}
