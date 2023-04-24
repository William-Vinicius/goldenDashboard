<?php 
    include_once 'classes/connection.php'; 
    $user = new User();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="src/css/styles.css" >
    <link rel="shortcut icon" href="src/img/favcon.ico" type="image/x-icon">
    <title>Teste Login</title>
</head>
<body>  

    <?php

        function Redirect($url, $permanent = false)
        {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
        }

        function getMessage($msg){
            if(isset($_SESSION[$msg])){
                echo $_SESSION[$msg];
                unset($_SESSION[$msg]);
            }
        }
        
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($dados['sendLogin'])){
            $dbverify = $user->connection();

            if($dbverify == true){
                $loginValidation = $user->login( $dados['login'], $dados['password'] );
            
                if($loginValidation == true){
                    Redirect('/cadastro.php', false);
                }
                else{
                    $_SESSION['message'] = "Usuário ou senha incorretas";
                }
            }
            else{
                $_SESSION['message'] = "Erro ao conectar com o banco de dados";
            }

        }
    ?>

    <div class="dad columns">
        <div class="container columns centraliser">
        

            <header class="centraliser">
                <h1 class="center-text">Bem Vindo</h1>
                <h2 class="center-text dark-font">Faça seu Login de membro</h2>
            </header>

            <form action="" method="POST" class="columns centraliser">
                <input type="text" name="login" class="login-input txInput" placeholder="Usuário" maxlength="16" required>
                <input type="password" name="password" class="login-input txInput" placeholder="Senha" maxlength="16" required>
                <input type="submit" value="Acessar" name="sendLogin" class="bt-color switch-button login-btn">
            </form>
            
        </div>
        <div class ="error-message">
            <?php getMessage('message')?> 
        </div>
    </div>



</body>
</html>