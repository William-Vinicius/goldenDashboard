<!DOCTYPE html>
<html lang="pt-br">
    <?php

            // include_once '../classes/connection.php';
            session_start();
            ob_start();


            function Redirect($url, $permanent = false){
                header('Location: ' . $url, true, $permanent ? 301 : 302);
                exit();
            }

            function setTitle($title)
            {
                echo 
                "<head>
                    <title> $title </title>
                    <link rel='stylesheet' type='text/css' href='../styles.css/'>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <script src='https://unpkg.com/@phosphor-icons/web'></script>
                </head>";
            }

            function getMessage($msg){
                if(isset($_SESSION[$msg])){
                    echo $_SESSION[$msg];
                    unset($_SESSION[$msg]);
                }
            }

        // if(!isset($_SESSION['id']) AND !isset($_SESSION['name'])){
        //     $_SESSION['message'] = "Necessário realizar o login para acessar";
        //     Redirect("../index.php");
        // }
    ?>
