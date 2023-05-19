<?php 

session_start();
ob_start();

class head{
    public function Redirect($url, $permanent = false)
    {
        if(file_exists('registrations/' . $url)){
            header('Location: ' . $url, true, $permanent ? 301 : 302);
            exit();
        }
        elseif(file_exists('graphs/' . $url)){
            header('Location: ' . $url, true, $permanent ? 301 : 302);
            exit();
        }
        elseif(file_exists('header/' . $url)){
            header('Location: ' . $url, true, $permanent ? 301 : 302);
            exit();
        }
        elseif(file_exists('classes/' . $url)){
            header('Location: ' . $url, true, $permanent ? 301 : 302);
            exit();
        }


        elseif(file_exists('./' . $url)){
            header('Location: ' . $url, true, $permanent ? 301 : 302);
            exit();
        }
        elseif(file_exists('../' . $url)){
            header('Location: ' . $url, true, $permanent ? 301 : 302);
            exit();
        }

        
        elseif(file_exists('../registrations/' . $url)){
            header('Location: ' . $url, true, $permanent ? 301 : 302);
            exit();
        }
        elseif(file_exists('../graphs/' . $url)){
            header('Location: ' . $url, true, $permanent ? 301 : 302);
            exit();
        }
        elseif(file_exists('../header/' . $url)){
            header('Location: ' . $url, true, $permanent ? 301 : 302);
            exit();
        }
        elseif(file_exists('../classes/' . $url)){
            header('Location: ' . $url, true, $permanent ? 301 : 302);
            exit();
        }
        else{
            echo "Mas ein";
        }
        
    }

    function setTitle($title)
    {
        echo "
        <!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' type='text/css' href='../styles.css/'>
            <script src='https://unpkg.com/@phosphor-icons/web'></script>
            <title> $title </title>
        </head>";
    }

    function getMessage($msg){
        if(isset($_SESSION[$msg])){
            echo $_SESSION[$msg];
            unset($_SESSION[$msg]);
        }
    }
    
    // Configuração de cookies quando possível

    // function SetPrivateCookie($name, $value){
    //     // $name = "LoginValidation";
    //     // $value
    //     $domain = "localhost:8000";
    //     $httponly = "true";
    // }

    // colocar os Cookies

    function secure(){
        if(!isset($_COOKIE['LoginValidation'])){
            $_SESSION['message'] = "Necessário realizar o login para acessar";
            $this->Redirect("login.php");
        }
    }
    public function mainMenu()
    {
        echo 
            '<nav>
                <h1>Menu de navegação</h1>
                <div class="menu-dad">
                    <input type="checkbox" name="" id="menu-check" class="no-display">
                    <div class="menu-margin">
                        <label for="menu-check" id="menu-draw" class="pointer" >
                            <i class="ph-bold ph-list" style="color:#cbd0ff; font-size: 2.5rem;"></i>
                            <i class="ph-bold ph-x" style="color:#cbd0ff; font-size: 2.5rem;"></i>
                        </label>
                    </div>

                    <div class="menu-bar">
                        <ul>
                            <div>
                                <ul>
                                    <a href="../index.html"><li class="menu-box">Principal</li></a>
                                </ul>
                            </div>

                            <div class="columns">
                                <input type="radio" name="test" id="drop-btn1" class="drop-btn no-display" checked>
                                <li class="menu-leader">
                                    <label for="drop-btn1" class="pointer">
                                        Lorem
                                    </label> 
                                </li>
                                
                                <ul class="drop-content">
                                    <a href="#Link 1"><li class="menu-box">Principal</li></a>
                                    <a href="#Link 2"><li class="menu-box">Dashboard1</li></a>
                                    <a href="#Link 3"><li class="menu-box">Dashboard2</li></a>
                                    <a href="#Link 4"><li class="menu-box">Dashboard3</li></a>
                                </ul>
                            </div>
                        </ul>
                    </div>
                </div>
            </nav>';
    }
}

    include_once 'classes/user.php';


    $user = new user();
    $head = new head();
    $conn = new connection();

    $head->setTitle("Teste Login");

    if(isset($_COOKIE['LoginValidation'])){
        $head->Redirect('index.php', false);
    }
    
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['sendLogin'])){
        $dbverify = $conn->getConnection();

        if($dbverify == true){
            $loginValidation = $user->login( $dados['login'], $dados['password'] );
        
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