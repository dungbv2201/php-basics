<?php
define('MESSAGE_VALIDATE', [
    'required' => 'This field is required',
]);

function validate($rules){
    $_SESSION['errorsValidate'] = [];
    foreach ($rules as $key => $rule){
        $data = $_POST[$key] ?? null;
        echo "<br>";
        foreach (explode('|', $rule) as $callback){
            $agr = explode(':', $callback);
            if(count($agr) > 1){
                $invalid = call_user_func($agr[0],$data,$agr[1]);
            }else{
                $invalid = call_user_func($callback,$data, $key);
            }
            if($invalid){
                $_SESSION['errorsValidate'][$key][] = $invalid;
            }
        }
    }

    return empty($_SESSION['errorsValidate']);
}

function required($value, $agr){
    $msg = null;
    if(!$value){
        $msg =  MESSAGE_VALIDATE['required'];
    }
    return $msg;
}

function minLength($value, $agr){
    $msg = null;
    if(!$value || strlen($value) < $agr){
        $msg =  'This field must be at least '.$agr.' characters.';
    }
    return $msg;
}
