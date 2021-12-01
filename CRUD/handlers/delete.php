<?php
session_start();
require_once __DIR__ . '/validate.php';
require_once __DIR__ . '/connectDb.php';

function destroy(){
    $id= $_POST['id'] ?? null;
    if(!$id){
        $_SESSION['errorDelete'] = 'Record not found!';
        header('Location: ../index.php');
    }
    try{
        $pdo = connectDb();
        $stmt = $pdo->prepare("SELECT id FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        if(!$user){
            $_SESSION['errorDelete'] = 'Record not found!';
        }else{
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $_SESSION['deleteSuccess'] = "Delete user successfully!";
        }
    }catch (PDOException $exception){
        $_SESSION['errorDelete'] = 'Delete error';
        echo $exception->getMessage();
    }
    header('Location: ../index.php');

}
destroy();
