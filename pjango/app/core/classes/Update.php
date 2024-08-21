<?php

class Update{
  private $_db;
  public function __construct(){
    $this->_db = DB::getInstance();
  }
  public function update($table,$fields,$id){
    if(!$this->_db->update($table,$id,$fields)){
      throw new Exception("Update Failed");

    }
    return true;
  }
}
