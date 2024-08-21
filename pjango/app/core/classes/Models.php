<?php
abstract class Models{

    private $_string;

    abstract public function fields() : array ;

    public function db(){
        return DB::getInstance();
    }

    /**
     * @return $this
     */
    public function integer(){
        $this->_string = "INT ";
        return $this;
    }

    /**
     * @param $length
     * @return $this
     */
    public function varchar($length){
        $this->_string .= "VARCHAR({$length}) ";
        return $this;
    }

    /**
     * @return $this
     */
    public function text(){
        $this->_string .= "TEXT ";
        return $this;
    }

    /**
     * @return $this
     */
    public function unique(){
        $this->_string .= "UNIQUE ";
        return $this;
    }

    /**
     * @return $this
     */
    public function datetime(){
        $this->_string .= "DATETIME ";
        return $this;
    }

    /**
     * @return $this
     */
    public function timestamp(){
        $this->_string .= "TIMESTAMP ";
        return $this;
    }

    /**
     * @return mixed
     */
    public function set(){
        $fieldsAttr = $this->_string;
        $this->_string = "";
        return $fieldsAttr;
    }

    /**
     * @param $value
     */
    public function default($value){
         
    }

    /**
     * @param array $fields
     * @return array
     */
    public function data($fields = []) : array {
        return $fields;
    }

    /**
     * @param $table
     * @param $fields
     */
    public function insert($table, $fields){
        $this->db()->insert($table, $fields);
    }
}