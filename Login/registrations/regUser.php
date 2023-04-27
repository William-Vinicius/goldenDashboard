<?php 
    define('PROJECT_ROOT_PATH', '../');
    include_once PROJECT_ROOT_PATH . '/header/contentHead.php';
    include_once PROJECT_ROOT_PATH . '/classes/connection.php';
    secure();

    $user = new User();
    
    setTitle("Novo Usuário");

    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if(!empty($data['sendSignUp'])){
        $dbValidation = $user->connection();

        if($dbValidation == true){
            if($data['confirmPsw'] === $data['password']){
                $signUp = $user->registerUser($data['name'], $data['username'], $data['email'], $data['phone'], $data['password']);
                
                if($signUp == true){
                    $_SESSION['message'] = "Usuário cadastrado com sucesso";
                }
                else{
                    $_SESSION['message'] = "Usuário indisponível";
                }
            }
            else{
                $_SESSION['message'] = "Os campos Senha e Confirmar Senha estão diferentes!";
            }
        }
        else{
            $_SESSION['message'] = "Erro ao conectar com o banco de dados";
        }
    }
?>

<body>
    <div class="menu-margin">
        <a href="../exit.php"><i class="ph ph-caret-double-left" style="font-size: 2.5rem"></i></a>
    </div>

    <div class="dad">
        <div class="container columns">
            <header>
                <h1 class="center-text">NOME MUITO DAHORA</h1>
                <h2 class="dark-font center-text">Insira seus dados</h2>
            </header>

            <form action="" method="POST" class="columns">
                <div class="rows">
                    <div class="columns half-margin">
                        <label class="dark-font" for="">Nome:</label>
                        <input type="text" name="name" id="" required class="txInput signup-input mid-input" maxlength="32">
                    </div>

                    <div class="columns half-margin">
                        <label class="dark-font" for="">Nome de usuário:</label>
                        <input type="text" name="username" id="" required class="txInput signup-input" maxlength="16">
                    </div>
                </div>

                <div class="columns half-margin ">
                    <label class="dark-font" for="">E-mail:</label>
                    <input type="text" name="email" id="" class="txInput signup-input long-input" maxlength="32">
                </div>

                <div class="columns half-margin">
                    <label class="dark-font" for="">Número:</label>
                    <input type="text" name="phone" id="" class="txInput signup-input" maxlength="16">
                </div>

                <div class="rows">
                    <div class="columns half-margin">
                        <label class="dark-font" for="">Senha:</label>
                        <input type="password" name="password" id="" required class="txInput signup-input" maxlength="16" >
                    </div>

                    <div class="columns half-margin">
                        <label class="dark-font" for="">Confirmar Senha:</label>
                        <input type="password" name="confirmPsw" id="" required class="txInput signup-input" maxlength="16">
                    </div>
                </div>

                    <!-- msg de erro  -->
                    <div class ="error-message centraliser">
                        <p class="center-text">
                            <?php getMessage('message')?> 
                        </p>
                    </div>

                <div class="space-down columns centraliser">
                    <input type="submit" value="Acessar" name="sendSignUp" class="bt-color switch-button login-btn">
                </div>
            </form>
        </div>
    </div>
</body>
</html>