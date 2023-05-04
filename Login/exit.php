<?php
    include 'autoload.php';
    $head = new head();
    ob_start();
    
    setcookie('LoginValidation', '', 1);
    $head->Redirect('login.php');
?>