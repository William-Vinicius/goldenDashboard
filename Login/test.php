<?php
    require_once 'classes/user.php';
    $conection = new User;

    $login = addslashes($_POST['login']);
    $password = addslashes($_POST['password']);

    $conection->connect('logintest','localhost','root','admin');

    if ($conection->errorMessage == ""){
        
        // $conection->login($login, $password);
        $conection->login();
    }
    else{
        echo "Eita ".$conection->errorMessage;
    }
?>