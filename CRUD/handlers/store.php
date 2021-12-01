<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/validate.php';
require_once __DIR__ . '/connectDb.php';


function store(){
    echo "<pre>";
    $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'password' => 'required|minLength:6',
        'email' => 'required',
    ];
    $isValid = validate($rules);
    if(!$isValid){
        $_SESSION['old'] = $_POST;
        header('Location: ../create.php');
    }else{
        $data = getData('post');
        $file  = $_FILES['avatar'] ?? null;
        $targetFile= null;
        if($file){
            $targetDir ="public/images/";
            $targetFile = $targetDir . time().basename($_FILES["avatar"]["name"]);
            $data['avatar'] = $targetFile;
        }

        $fields = [];
        $params = [];
        foreach ($data as $key => $value){
            if($value){
                $fields[] = $key;
                $params[] = ":$key";
            }
        }
        try{
            $pdo = connectDb();
            $stmt = $pdo->prepare("INSERT INTO users (".implode(',',$fields).")
                                         VALUES (".implode(',',$params).")");
            foreach ($fields as $key => $field){
                if($field === 'password'){
                    $pwd_peppered = hash_hmac("sha256", $data[$field], 'default_key');
                    $data[$field] = password_hash($pwd_peppered, PASSWORD_ARGON2ID);
                }
                $stmt->bindParam($params[$key], $data[$field]);
            }
            $stmt->execute();
            if($targetFile){

               $rs =  move_uploaded_file($_FILES["avatar"]["tmp_name"],  __DIR__."/../$targetFile");
            }
            $_SESSION['created'] = true;
            header('Location: ../index.php');
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}

store();
