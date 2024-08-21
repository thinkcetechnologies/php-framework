<?php
class Schemas{
    private  $_db,
             $_error,
             $_is_created = false,
             $_data;


    public function __construct(){
        $this->_db = DB::getInstance();
    }

    public function migrate(){
        foreach (apps as $app){
            $models = scandir($app . '/models');
            $hideName = ['.','..','.DS_Store'];
            foreach ($models as $modelName){
                if(!in_array($modelName, $hideName)){
                    require_once $app . "/models/" . $modelName;
                    $m = explode(".", $modelName);
                    $model = $m[0];
                    $tableName = strtolower($model) . "s";
                    $table = new $model();
                    $this->_db->schemas($tableName, $table->fields());
                }
            }
        }
    }
}