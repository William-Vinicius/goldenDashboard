<?php
define('PROJECT_ROOT_PATH', './');
include_once PROJECT_ROOT_PATH. "classes/connection.php";
secure();

ob_start();
setcookie('LoginValidation', '', 1);
Redirect('/index.php', false);

?>