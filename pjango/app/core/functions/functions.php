<?php
function includes($element){
    return require_once '../views/' . $element . ".php";
}


function csrf_token(){
    return '<input name="token" value="' . Token::generate() . '" type="hidden">';
}