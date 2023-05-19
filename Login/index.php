<?php 
    include 'autoload.php';
    $head = new head();
    $user = new user();

    $head->secure();
    $head->setTitle("Menu Principal")
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

                    <a href="registrations/regUser.php">
                        <li class="redirect bt-color "> Criação Novo Login </li>
                    </a>
                    <a href="testpage1.php">
                        <li class="redirect bt-color"> Top jogadores (Esportes)</li>
                    </a>
                    <a href="#pg3">
                        <li class="redirect bt-color"> Top Jogadores (Cassino) </li>
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