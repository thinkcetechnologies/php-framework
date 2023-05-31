<?php


class Bookmark extends Models {
    public $user_id = "user_id";
    public $url = "url";
    public $name = "name";

    public function fields() : array {
        return [
          $this->user_id => $this->integer()->set(),
          $this->url => $this->text()->set(),
          $this->name => $this->varchar(50)->set(),
        ];

    }
    public function save($fields){
        $this->insert('bookmarks', $fields);
    }
}