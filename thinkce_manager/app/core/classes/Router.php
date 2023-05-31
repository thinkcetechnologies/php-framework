<?php
class Router{
      public static function get($name, $url, $params = []){
          $parameters = '';
          foreach ($params as $param){
              $parameters .= $param . '/';
          }
          $urls = rtrim($url, "/");
          define($name, URL. $urls . $parameters);
      }

      public static function post($name, $url){
          define($name, URL. $url);
      }
}
