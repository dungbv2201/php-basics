<?php
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

$data = getData('post');
echo "<pre>";
var_dump($data);