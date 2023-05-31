<?php
//this contains the configuration to access db, cookies, server, etc
class Config {
    //method to check get the path of the db instances
    public static function get($path = null){
        // check if the path exist or not
        if($path){
            //use the globals to get for the config path 
            $config = $GLOBALS['config'];
            // explode the path if it exist
            $path = explode('/', $path);
            // setting each path to the config variables
            foreach($path as $bit){
                // if the path exist as bit the set it to the config
                if(isset($config[$bit])){
                    $config = $config[$bit];
                }
            }
            // return the path to the config variable
            return $config;

        }
        return false;
    }
}
