<?php
require_once "pjango/app/core/functions/functions.php";
define("URL", __DIR__);

define('staticfiles', URL .'static/');
define("url", trim($_SERVER["REQUEST_URI"], "/"));

define("apps", [
    "main",
    "accounts",
]);

$schemas = new Schemas();

$schemas->migrate();
