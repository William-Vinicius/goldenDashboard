<?php 
include_once 'connection.php';
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
            <?php

                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);


                if (!empty($dados['sendLogin'])) {
                        // var_dump($dados);

                    $query = "SELECT * FROM tbUser WHERE loginUser LIKE :username LIMIT 1";

                    $resultQuery = $pdo->prepare($query);
                    $resultQuery->bindParam(':username', $dados['login'], PDO::PARAM_STR);

                    $resultQuery->execute();
                   
                    if($resultQuery->rowCount() > 0){
                        $validation = $resultQuery->fetch(PDO::FETCH_ASSOC);
                        // var_dump($validation);

                        // if (password_verify($dados['password'], $validation['passwordUser'])) {
                        if($dados['password'] == $validation['passwordUser']){
                            echo "Só sucesso BD";
                        }
                        else{
                            echo "Problema na senha uhuuu";
                        }
                    }
                    else{
                        echo "Usuário ou Senha incorreta, meu confrade";
                    }
                    
                    
                }
            ?>
        </div>
    </div>



</body>
</html>