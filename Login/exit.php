<?php
define('PROJECT_ROOT_PATH', './');
include_once PROJECT_ROOT_PATH. "classes/connection.php";

unset($_SESSION['id']);
unset($_SESSION['name']);
ob_start();

Redirect('/index.php', false);

?>