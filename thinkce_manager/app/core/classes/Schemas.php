<?php


class Schemas{
    private  $_db,
             $_error,
             $_is_created = false,
             $_data;


    public function __construct(){
        $this->_db = DB::getInstance();
    }

//    public function makeAuth(){
//        if(!$this->_is_created) {
//            foreach (DefaultConfig::get('default_tables/') as $key => $value) {
//                if($this->_db->schemas($key, DefaultConfig::get("default_tables/{$key}"))) {
//                    echo "<script>console.log('Auth Tables Made Successfully');</script>";
//                }
//            }
//        }
//    }
    public function makeTables($app){
        $models = scandir('../../' . $app . '/models');
        $hideName = ['.','..','.DS_Store'];
        foreach ($models as $modelName){
            if(!in_array($modelName, $hideName)){
                require_once "../../" . $app . "/models/" . $modelName;
                $m = explode(".", $modelName);
                $model = $m[0];
                $tableName = strtolower($model) . "s";
                $table = new $model();
                if($this->_db->schemas($tableName, $table->fields())) {
                    echo "<script>console.log('Auth Tables Made Successfully');</script>";
                }
            }
        }
    }
}