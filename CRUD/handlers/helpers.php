<?php
session_start();
function getData($method){
    $data = [];
    if(strtolower($method) === 'get'){
        foreach($_GET as $key => $value){
            $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
    }
    if(strtolower($method) === 'post'){
        foreach($_POST as $key => $value){
            $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
    }
    return $data;
}

function renderInValid($field){
    if(isset($_SESSION['errorsValidate'][$field])){
        return '<div class="text-danger mt-1">'.$_SESSION['errorsValidate'][$field][0].'</div>';
    }
}
