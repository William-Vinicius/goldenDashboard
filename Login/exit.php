<?php

include_once 'classes/connection.php';
unset($_SESSION['id']);
unset($_SESSION['name']);
ob_start();


function Redirect($url, $permanent = false){
    header('Location: ' . $url, true, $permanent ? 301 : 302);
    exit();
}

Redirect('/index.php', false);

?>