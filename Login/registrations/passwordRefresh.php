<?php 
    define('PROJECT_ROOT_PATH', '../');

    include_once PROJECT_ROOT_PATH . '/header/contentHead.php';
    include_once PROJECT_ROOT_PATH. "classes/connection.php";

    setTitle("Alterar Senha");
    $user = new User();

    $passwordKey = filter_input(INPUT_GET, 'key', FILTER_DEFAULT);
    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    // $pgValidation = $user->recoveryCheck($passwordKey);

    // if($pgValidation[0] == true){
        if(!empty($data['sendRecovery'])){
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
    // }
    // else{
    //     $_SESSION['message'] = 'Link de recuperação inválido';
    //     Redirect(PROJECT_ROOT_PATH . 'login.php', false);
    // }
?>

<body>
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
                        <?php getMessage('message')?> 
                    </p>
                </div>

                <input type="submit" value="Atualisar Senha" name="sendRecovery" class="bt-color switch-button login-btn">
            </form>
        </div>
    </div>
</body>
</html>