<?php 
    include '../autoload.php';

    $user = new user();
    $head = new head();
    $conn = new connection();

    $head->setTitle("Melhores Apostadores");
    $head->mainMenu();
    $head->secure();
?>

    <div class="dad">
        <div class="container">

            <header>
                <h1>Top Apostadores</h1>
            </header>

            <div class="flex1-box rows">   

                <div class="content-box flex1-box columns">
                    <ul>
                        <a href="#VisãoGrafico">
                            <li class="switch-button bt-color">Gráfico</li>
                        </a>
                        <li class="switch-button bt-color" onclick="addUser(Dashboad1)">Novo</li>
                    </ul>

                </div>

                <div class="content-box columns flex2-box">
                    
                    <select id="months" name="months" class="txInput space-up">
                        <option>Selecione um mês</option>
                        <option onclick= "setmonth('jan')">Janeiro</option>
                        <option onclick= "setmonth('feb')">Fevereiro</option>
                        <option onclick= "setmonth('mar')">Março</option>
                        <option onclick= "setmonth('apr')">Abril</option>
                        <option onclick= "setmonth('may')">Maio</option>
                        <option onclick= "setmonth('jun')">Junho</option>
                        <option onclick= "setmonth('jul')">Julho</option>
                        <option onclick= "setmonth('aug')">Agosto</option>
                        <option onclick= "setmonth('sep')">Setembro</option>
                        <option onclick= "setmonth('oct')">Outubro</option>
                        <option onclick= "setmonth('nov')">Novembro</option>
                        <option onclick= "setmonth('dec')">Dezembro</option>
                    </select>
                    <div>

                        <form action="../src/php/database.php" method="get">

                            <div class="rows">
                                <input type="date" name="dt-search-beginning" class="dt-input">
                                <spam class="lil-margin"> - </spam>
                                <input type="date" name="dt-search-end" class="dt-input">
                            </div>
                    </div>
                    <!-- PARTE QUE ESTÁ SENDO MUDADA COMPARADA AO 1 -->
                    <div class="rows centraliser">
                        <div class="columns">
                            <div class="rows">
                                <input type="radio" name="TransactionChice" id="trans-dep" checked> <label for="trans-dep" class="dark-font">Depósitos </label>
                            </div>
                            <div class="rows">
                                <input type="radio" name="TransactionChice" id="trans-saq"> <label for="trans-saq" class="dark-font">Saques</label>
                            </div>
                        </div>
                        <input type="button" value="Pesquisar" class="bt-color src-button">

                    </div>

                    <!-- FIM DA PARTE ÚNICA -->
                        
                    

                    </form>
                    <div class="rows space-down">
                        <form action="FILTRAR POR PALAVRAS AQUI" method="get">
                            <input type="search" name="txFilter" id="txFilter" class="txInput" maxlength="16" placeholder="Filtrar">
                            <label for="btFilter">
                                
                                <i class="ph-bold ph-magnifying-glass" style="color:#282a49; font-size: 1.3rem; cursor: pointer;"></i>
                               
                            </label>
                            <input type="button" value="filtrar" id="btFilter" class="no-display">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>