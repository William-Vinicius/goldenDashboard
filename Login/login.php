<?php 

    include 'autoload.php';

    $user = new user();
    $head = new head();
    $conn = new connection();

    $head->setTitle("Teste Login");
    $dbverify = $conn->getConnection();

    if(isset($_COOKIE['LoginValidation'])){
        $head->Redirect('index.php', false);
    }
    
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['sendLogin'])){
        $dbverify = $conn->getConnection();

        if($dbverify == true){
            $loginValidation = $user->login($dados['login'], $dados['password']);
        
            if($loginValidation == true){
                $head->Redirect('index.php', false);
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

<body>
    <div class="dad columns">
        <div class="container columns centraliser">

            <header class="centraliser">
                <h1 class="center-text">Bem Vindo</h1>
                <h2 class="center-text dark-font">Faça seu Login de membro</h2>
            </header>

            <form action="" method="POST" class="columns centraliser">
                <input type="text" name="login" class="login-input txInput" placeholder="Usuário" maxlength="16" value="<?php if( !empty($dados['login'])){ echo $dados['login']; } ?>" required>
                <input type="password" name="password" class="login-input txInput" placeholder="Senha" maxlength="16" required>
                <input type="submit" value="Acessar" name="sendLogin" class="bt-color switch-button login-btn">
                <a href="registrations/forgotPassword.php" class="blue-link">Esqueceu a Senha?</a>
            </form>
            
        </div>
        <div class ="error-message">
            <?php $head->getMessage('message')?> 
        </div>
    </div>
</body>

</html>