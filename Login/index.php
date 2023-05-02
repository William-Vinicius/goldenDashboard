<?php 
    define('PROJECT_ROOT_PATH', './');
    include_once PROJECT_ROOT_PATH . '/header/contentHead.php';
    include_once PROJECT_ROOT_PATH. "classes/connection.php";
    secure();
    setTitle("Menu Principal")
?>
<body>    

    <div class="menu-margin">
        <a href="exit.php"><i class="ph ph-sign-out" style="font-size: 2rem; color:#e2c051"></i></a>
    </div>

    <div class="dad">
        <div class="menu-dad">

        </div>
        <div class="container main-index">
            <header>
                <h1>Selecione o Dashboard desejado</h1>
            </header>
            <nav class="rows">
                <ul class="pages">

                    <a href="#pg1">
                        <li class="redirect bt-color "> Extrato dos afiliados </li>
                    </a>
                    <a href="#pg2">
                        <li class="redirect bt-color"> Depósitos & Saques </li>
                    </a>
                    <a href="#pg3">
                        <li class="redirect bt-color"> Popularidade dos Cassinos </li>
                    </a>
                </ul>
                <ul class="pages">

                    <a href="TestPage.html">
                        <li class="redirect bt-color "> Teste de Menu </li>
                    </a>
                </ul>
            </nav>
        </div>
    </div>
</body>
</html>