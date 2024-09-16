<?php
$urlpatterns = [
    Router::path("/", "home"),
    Router::path("/about", "about"),
    Router::path("/contact/{path}/{id}", "contact"),
];
