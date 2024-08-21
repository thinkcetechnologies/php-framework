<?php


class Decode_DB_Fields{

    public static function getTables($config){
       $keys = array_keys(DefaultConfig::get($config));
//       foreach ($keys as $key)
//       {
//           return $key;
//       }
       return $keys;
    }
    public static function getFields($t){
        foreach (self::getTables($t) as $table) {
            return array_keys(DefaultConfig::get("$t/$table/"));

        }
        return none;
    }
    public function createSchemas(){

    }

}