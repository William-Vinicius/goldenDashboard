<?php
    session_start();
    ob_start();
    class head{
        public function Redirect($url, $permanent = false){
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

        function setTitle($title){
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

        function secure(){
            if(!isset($_COOKIE['LoginValidation'])){
                $_SESSION['message'] = "Necessário realizar o login para acessar";
                $this->Redirect("login.php");
            }
        }
        public function mainMenu(){
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
                                    <ul class="menu-top-ul">
                                        <a href="../index.php"><li class="menu-box">Principal</li></a>
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
                                        <a href="#Link 2"><li class="menu-box">Exemplo1</li></a>
                                        <a href="#Link 3"><li class="menu-box">Exemplo2</li></a>
                                        <a href="#Link 4"><li class="menu-box">Exemplo3</li></a>
                                    </ul>
                                </div>
                            </ul>
                        </div>
                    </div>
                </nav>';
        }
    }