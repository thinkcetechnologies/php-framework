<?php
class  DB {
    private static ?DB $_instance = null;
    private $_results, $_query;
    private int $_count = 0;
    private bool $_error = false;
    private PDO $_pdo;

    private function __construct(){
        try{
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'),Config::get('mysql/password'));
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    /**
     * @
     * @return DB|null
     */
    public static function getInstance(): ?DB{
        if(!isset(self::$_instance)){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
    /**
     * @param mixed $sql
     * @param null|array $params
     * @return DB
     */
    public function query(mixed $sql, null|array $params = []): DB{
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
    /**
     * @param mixed $action
     * @param mixed $table
     * @param null|array $where
     * @return DB|bool
     */
    private function action(mixed $action, mixed $table, null|array $where = []): DB|bool{
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
    /**
     * @param mixed $name
     * @param null|array $columns
     * @return bool
     */
    public function schemas(mixed $name, null|array $columns = []) : bool{
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
            $sql = "CREATE TABLE IF NOT EXISTS {$name} (id INTEGER AUTO_INCREMENT , ". $fields . " PRIMARY KEY (id));";

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
    /**
     * @param mixed $table
     * @param null|array $fields
     * @return bool
     */
    public function insert(mixed $table, null|array $fields = array()) : bool {
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
    /**
     * @param mixed $table
     * @param mixed $id
     * @param mixed $fields
     * @param null $field
     *@return bool
     */
    public function update(mixed $table, mixed $id, mixed $fields, null|string $field = "id"): bool{
        $set = '';
        $x = 1;
        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";
            if($x < count($fields)){
                $set .= ', ';
            }
            $x++;
        }
        $sql = "UPDATE {$table} SET {$set} WHERE {$field} = {$id}";
        if(!$this->query($sql, $fields)->error()){
            return true;
        }
        return false;
    }
    /**
     * @param mixed $table
     * @param mixed $field
     * @param mixed $value
     * @return bool
     */
    public function liveSearch(mixed $table, mixed $field, mixed $value): bool{
        $sql = "SELECT * FROM {$table} WHERE {$field} LIKE '%{$value}%'";

        if($this->query($sql)){
            return true;
        }
        return false;
    }
    /**
     * @param mixed $table
     * @param mixed $where
     * @return DB | bool
     */
    public function get(mixed $table, mixed $where): DB|bool{
        return $this->action('SELECT *',$table, $where);
    }
    /**
     * @param mixed $table
     * @return bool
     */
    public function fetchAll(mixed $table): bool{
        $sql = "SELECT * FROM {$table} ORDER BY id DESC";
        if($this->query($sql)){
            return true;
        }
        return false;
    }
    /**
     * @param mixed $table
     * @param mixed $limit
     */
    public function getAll($table, $limit = 10): bool{
        $sql = "SELECT * FROM {$table} ORDER BY id DESC LIMIT = {$limit}";
        if($this->query($sql)){
            return true;
        }
        return false;
    }

    /**
     * @param mixed $table
     * @param mixed $start_page
     * @param mixed $per_page
     * @param string|null $order
     * @return bool
     */
    public function Paginator(mixed $table, mixed $start_page, mixed $per_page, null|string $order = "DESC"): bool{
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
        return false;
    }
    /**
     * @param mixed $table
     * @param mixed $where
     * @return DB | bool
     */
    public function delete(mixed $table, mixed $where): DB|bool{
        return $this->action('DELETE',$table, $where);
    }
    public function results(){
        return $this->_results;
    }
    public function first(){
        return $this->results()[0];
    }
    public function error(): bool
    {
        return $this->_error;
    }
    public function count(): int
    {
        return $this->_count;
    }
}
