<?php 
    include 'autoload.php';
    $head = new head();
    $user = new user();
    $conn = new connection();

    $head->secure();
    $head->setTitle("Menu Principal");
    $conn->getConnection();
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
                        <li class="redirect bt-color "> Teste de cadastro </li>
                    </a>
                    <a href="tables/topBets.php">
                        <li class="redirect bt-color"> Teste das Tabelas </li>
                    </a>
                    <a href="tests/">
                        <li class="redirect bt-color"> Página de testes JS </li>
                    </a>
                </ul>
                <!-- <ul class="pages">

                    <a href="TestPage.html">
                        <li class="redirect bt-color "> Teste de Menu </li>
                    </a> -->
                </ul>
            </nav>
        </div>
    </div>
</body>
</html>