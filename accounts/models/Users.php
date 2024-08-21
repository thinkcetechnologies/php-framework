<?php
class Users extends Models {
    public $username = "username";
    public $password = "password";
    public function fields(): array{
        return [
            $this->username => $this->varchar(20)->unique()->set(),
            $this->password => $this->varchar(100)->set(),
        ];
    }
}