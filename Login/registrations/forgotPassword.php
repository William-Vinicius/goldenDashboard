<?php 

    define('PROJECT_ROOT_PATH', '../');

    include_once PROJECT_ROOT_PATH . '/header/contentHead.php';
    include_once PROJECT_ROOT_PATH. "classes/connection.php";

    setTitle("Alterar Senha");
    $user = new User();

    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
    if(!empty($data['sendLink'])){
        $dbValidation = $user->connection();

        if($dbValidation == true){
            $login = $user->recoverPswLink($data['login']);

            if($login == true){
                echo "Tudo certo";
            }
            else{
                $_SESSION['message'] = 'Usuário não encontrado';
            }
        }
        else{
            $_SESSION['message'] = 'Erro de conexão';
        }
    }
   ?>
<body>
    <div class="menu-margin">
        <a href=<?php echo PROJECT_ROOT_PATH . 'login.php' ?>><i class="ph ph-caret-double-left" style="font-size: 2.5rem"></i></a>
    </div>
    <div class="dad columns">
        <div class="container columns">
            <header>
                <h1 class="centraliser">
                    Esquceu a senha?
                </h1>
            </header>

            <form action="" method="POST" class="columns">
                <div class="columns half-margin">
                    <label for="loginInput" class="dark-font">Insira seu usuário: </label>
                    <input type="text" name="login" id="loginInput" class="txInput signup-input" maxlength="16" required>
                </div>

                <div class="columns half-margin">
                    <h2 class="dark-font bold">
                        Como você deseja recuperar<br/>sua senha?
                    </h2>
                </div>
                
                <div class="columns space-down half-margin-left">
                    <div class="rows">
                        <input type="radio" name="recoveryChannel" value="phone" id=""> 
                        <label for="phone" class="dark-font"> Telefone </label>
                    </div>
                </div>

                <div class="columns half-margin">
                     <div class="rows">
                        <input type="radio" name="recoveryChannel" value="email" id=""> 
                        <label for="email" class="dark-font"> E-mail </label>
                    </div>             
                </div>
                <div class=" columns centraliser">
                    <input type="submit" value="Recuperar" name="sendLink" class="bt-color switch-button login-btn">
                </div>
            </form>
        </div>

        <div class ="error-message centraliser">
            <p class="center-text">
                <?php getMessage('message')?> 
            </p>
        </div>

    </div>
</body>