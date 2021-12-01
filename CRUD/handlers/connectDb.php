<?php
function connectDb(){
    $servername = "localhost";
    $username = "vandung";
    $password = "vandung94";
    $connect = null;
    try {
        $connect = new PDO("mysql:host=$servername;dbname=php-basics", $username, $password);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    return $connect;
}