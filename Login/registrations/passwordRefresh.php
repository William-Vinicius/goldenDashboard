<?php 
    include '../autoload.php';
    $head = new head();
    $user = new user();

    $head->setTitle("Alterar Senha");
    $passwordKey = filter_input(INPUT_GET, 'key', FILTER_DEFAULT);
    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $dbValidation = $user->connection();
    $pgValidation = $user->recoveryCheck($passwordKey);

    if($pgValidation[0] == true){
        if(!empty($data['sendRecovery'])){
            if($dbValidation == true){

                if($data['password'] == $data['confirm']){
                    $recover = $user->recoverPsw($passwordKey, $data['password']);
                    if($recover == true){
                        $_SESSION['message'] = "A nova senha foi redefinida!";
                    }
                    else{
                        $_SESSION['message'] = "Erro ao redefinir a Senha";
                    }
                }
                else{
                    $_SESSION['message'] = "As duas senhas não conferem";
                }
            }
            else{
                $_SESSION['message'] = "Erro de conexão";
            }
        }
    }
    else{
        $_SESSION['message'] = 'Link de recuperação inválido';
        $head->Redirect('login.php', false);
    }
?>

<body>
    <div class="menu-margin">
        <a href='../login.php'><i class="ph ph-caret-double-left" style="font-size: 2.5rem"></i></a>
    </div>

    <div class="dad">
        <div class="container columns">
            <header class="centraliser">
                <h1 class="centraliser">
                    Trocar de Senha
                </h1>
            </header>

            <form action="" method="POST" class="columns">
                <div class="columns half-margin">
                    <label for="pswInput" class="dark-font">Insira a nova Senha: </label>
                    <input type="password" name="password" id="pswInput" class="txInput signup-input" maxlength="16" required>
                </div>
                <div class="columns half-margin">
                    <label for="confirmInput" class="dark-font">Confirmar Senha: </label>
                    <input type="password" name="confirm" id="confirmInput" class="txInput signup-input" maxlength="16" required>
                </div>

                <div class ="error-message centraliser">
                    <p class="center-text">
                        <?php $head->getMessage('message')?> 
                    </p>
                </div>

                <input type="submit" value="Atualisar Senha" name="sendRecovery" class="bt-color switch-button login-btn">
            </form>
        </div>
    </div>
</body>
</html>