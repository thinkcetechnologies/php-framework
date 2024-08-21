<?php

class Validation{
    private $_passed = false,
            $_errors = [],
            $_db = null,
            $_allowed = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];


    public function __construct(){
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = []){
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                $value = trim($source[$item]);
                if ($rule === 'required' && empty($value)) {
                    $this->addError("{$item} is required");
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$item} must be minimum of {$rule_value} characters");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("{$item} must be maximum of {$rule_value} characters");
                            }
                            break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if ($check->count()) {
                                $this->addError("{$item} already exists");
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError("password do not match");
                            }
                            break;
                        case 'integer':
                            if ($rule_value) {
                                if (!is_integer($value)) {
                                    $this->addError("$item must be integer");
                                }
                            }
                            break;
                        case 'numeric':
                            if ($rule_value) {
                                if (!is_numeric($value)) {
                                    $this->addError("$item must be numeric");
                                }
                            }
                            break;
                        case 'string':
                            if ($rule_value) {
                                if (!is_string($value)) {
                                    $this->addError("$item must be string");
                                }
                            }
                            break;
                        case 'email':
                            if ($rule_value) {
                                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                    $this->addError("Invalid email address");
                                }
                            }
                            break;

                        default:
                            break;
                    }
                }
            }
        }
        if (empty($this->_errors)) {
            $this->_passed = true;
        }
        return $this;
    }

    public function upload($file, $folder){
        if (is_array($file)) {
            if (in_array($file['type'], $this->_allowed)) {
                $ran = uniqid();
                move_uploaded_file($file['tmp_name'], $folder . '/' . $ran . '.' . $file['name']);
                return $ran;
            } else {
                return false;
            }
        } else {
            die('No File Selected');
        }
    }

    private function addError($error){
        $this->_errors[] = $error;
    }

    public function errors(){
        return $this->_errors;
    }

    public function passed(){
        return $this->_passed;
    }
}
