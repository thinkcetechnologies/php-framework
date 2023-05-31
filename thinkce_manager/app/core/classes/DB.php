<?php
class  DB {
    private static  $_instance = null;
    private     $_pdo,
                $_error = false,
                $_results,
                $_count = 0,
                $_query;

    private function __construct(){
        try{
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'),Config::get('mysql/password'));
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    public static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
    public function query($sql , $params = []){
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if(count($params)){
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
            if($this->_query->execute()){
                $this->_results = $this->_query->fetchAll(PDO::FETCH_ASSOC);
                $this->_count = $this->_query->rowCount();
            }else{
                $this->_error = true;
            }
        }
        return $this;
    }
    private function action($action, $table, $where = []){
        if(count($where) === 3){
            $operators = array('=','>','<','>=','<=');
            $field     =  $where[0];
            $operator  =  $where[1];
            $value     =  $where[2];
            if(in_array($operator, $operators)){
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if(!$this->query($sql, array($value))->error()){
                    return $this;
                }
            }
        }
        return  false;
    }
    public function schemas($name, $columns = []) : bool{
        if(count($columns)){
            $fields = '';
            $x = 0;
            foreach ($columns as $key => $value) {
                $fields .= "{$key} {$value}";
                if($x < count($columns)){
                    $fields .= ', ';
                }
                $x++;
            }
            $sql = "CREATE TABLE IF NOT EXISTS {$name} (id INTEGER AUTO_INCREMENT , ". $fields . " PRIMARY KEY (id))";


            if($this->_query = $this->_pdo->prepare($sql)){
                if($this->_query->execute()){
                    return true;
                }else{
                    $this->_error = true;
                    return false;
                }
            }
        }
        return false;
    }
    public function insert($table, $fields = array()) : bool {
        if(count($fields)){
            $keys = array_keys($fields);
            $values = '';
            $x = 1;
            foreach ($fields as $field) {
                $values .= '?';
                if($x < count($fields)){
                    $values .= ', ';
                }
                $x++;
            }
            $sql = "INSERT INTO {$table} (`" . implode('` , `', $keys) . "`) VALUES ({$values})";
            if(!$this->query($sql, $fields)->error()){
                return true;
            }
        }
        return false;
    }
    public function update($table, $id, $fields){
        $set = '';
        $x = 1;
        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";
            if($x < count($fields)){
                $set .= ', ';
            }
            $x++;
        }
        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        if(!$this->query($sql, $fields)->error()){
            return true;
        }
        return false;
    }
    public function liveSearch($table, $field, $value){
        $sql = "SELECT * FROM {$table} WHERE {$field} LIKE '%{$value}%'";

        if($this->query($sql)){
            return true;
        }
        return false;
    }

    public function get($table, $where){
        return $this->action('SELECT *',$table, $where);
    }
    public function fetchAll($table){
        $sql = "SELECT * FROM {$table} ORDER BY id DESC";
        if($this->query($sql)){
            return true;
        }
        return false;
    }
    public function Paginator($table, $start_page, $per_page, $order = "DESC"){
        $start = ($start_page > 1) ? ($start_page * $per_page) - $per_page : 0;
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM {$table} ORDER BY id {$order} LIMIT {$start}, {$per_page}";
        if($this->_query = $this->_pdo->prepare($sql)){
            if($this->query($sql)){
                $total = $this->_pdo->prepare("SELECT FOUND_ROWS() AS total")->fetch()['total'];
                $pages = ceil($total / $per_page);
                setcookie("pages", $pages);
                return true;
            }
            return false;
        }
    }

    public function delete($table, $where){
        return $this->action('DELETE',$table, $where);
    }
    public function results(){
        return $this->_results;
    }
    public function first(){
        return $this->results()[0];
    }
    public function error(){
        return $this->_error;
    }
    public function count(){
        return $this->_count;
    }
}
