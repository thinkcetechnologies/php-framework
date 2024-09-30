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
    public function varchar($length): static
    {
        $this->_string .= "VARCHAR({$length}) ";
        return $this;
    }

    /**
     * @return $this
     */
    public function text(): static
    {
        $this->_string .= "TEXT ";
        return $this;
    }

    /**
     * @return $this
     */
    public function unique(): static
    {
        $this->_string .= "UNIQUE ";
        return $this;
    }

    /**
     * @return $this
     */
    public function datetime(): static
    {
        $this->_string .= "DATETIME ";
        return $this;
    }

    /**
     * @return $this
     */
    public function timestamp(): static
    {
        $this->_string .= "TIMESTAMP ";
        return $this;
    }

    /**
     * @return mixed
     */
    public function set(): mixed
    {
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
    public function data(array $fields = []) : array {
        return $fields;
    }

    /**
     * @param $table
     * @param $fields
     */
    public function insert($table, $fields): void
    {
        $this->db()->insert($table, $fields);
    }
}