<?php
$urlpatterns = [
    Router::path("/about", "about"),
    Router::path("/contact/{path}/", "contact"),
    Router::path("/", "home"),
];
