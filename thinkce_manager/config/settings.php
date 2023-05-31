<?php
require_once "../app/core/functions/functions.php";
define("URL", "/php/mvc/thinkce_manager/public/");

define('staticfiles', URL .'static/');

define('HEADERLAYOUT', 'layout/layout');
define('FOOTERLAYOUT', "layout/base_footer");


$schemas = new Schemas();

//$schemas->makeAuth();

$schemas->makeTables("main");
