<?php
class Models{
    private $_string;
    public function db(){
        return DB::getInstance();
    }
    public function integer(){
        $this->_string = "INT ";
        return $this;
    }
    public function varchar($length){
        $this->_string .= "VARCHAR({$length}) ";
        return $this;
    }
    public function text(){
        $this->_string .= "TEXT ";
        return $this;
    }
    public function unique(){
        $this->_string .= "UNIQUE ";
        return $this;
    }
    public function datetime(){
        $this->_string .= "DATETIME ";
        return $this;
    }
    public function timestamp(){
        $this->_string .= "TIMESTAMP ";
        return $this;
    }
    public function set(){
        $fieldsAttr = $this->_string;
        $this->_string = "";
        return $fieldsAttr;
    }
    public function default($value){
         
    }
    public function data($fields = []) : array {
        return $fields;
    }
    public function insert($table, $fields){
        $this->db()->insert($table, $fields);
    }
}