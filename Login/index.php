<?php 
    define('PROJECT_ROOT_PATH', './');
    include_once PROJECT_ROOT_PATH . '/header/contentHead.php';
    include_once PROJECT_ROOT_PATH. "classes/connection.php";

    $user = new User();
    setTitle("Teste Login");

    if(isset($_COOKIE['LoginValidation'])){
        Redirect('registrations/regUser.php', false);
        
    }
    
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['sendLogin'])){
        $dbverify = $user->connection();

        if($dbverify == true){
            $loginValidation = $user->login( $dados['login'], $dados['password'] );
        
            if($loginValidation == true){

                Redirect('registrations/regUser.php', false);
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
            </form>
            
        </div>
        <div class ="error-message">
            <?php getMessage('message')?> 
        </div>
    </div>



</body>

</html>