<?php 
    include '../autoload.php';
    $head = new head();
    $user = new user();

    $head->setTitle('GráficoTeste')

?>
<div class="dad">
    <div class="container">
        <header>
            <h1>
                NOME MUITO TEMPORARIO
            </h1>
        </header>
        <div class="rows">
            <div class="columns padding-sides flex1-box">
                <div class="columns ">
                    <h3>
                        Período
                    </h3>
                    <select id="months" name="months" class="txInput space-up">
                        <option>Selecione</option>

                        <option onclick = "setPeriod(3)">3 Meses</option>
                        <option onclick = "setPeriod(6)">6 Meses</option>
                        <option onclick = "setPeriod(9)">9 Meses</option>
                        <option onclick = "setPeriod(12)">1 Ano</option>
                        <option onclick = "setPeriod(3*12)">3 Anos</option>
                        <option onclick = "setPeriod(5*12)">5 Anos</option>

                    </select>
                </div>
                <div class="invisible columns half-margin">
                    <div class="rows">
                        <input type="radio" name="rdShow" id="month">
                        <label for="month"> Mensal </label>
                    </div>
                    <div class="rows">
                        <input type="radio" name="rdShow" id="year">
                        <label for="year"> Anual </label>
                    </div>
                </div>
            </div>
            
            <div class="columns padding-sides flex1-box">
                <div class="space-up">
                    <div class="drawSearch src-button">
                        Metas
                        <i class="ph ph-caret-down"></i>
                    </div>
                </div>

                <div class="columns">
                    <div class="rows space-up">
                        <h3>Tipo de Tabela: </h3>
                    </div>

                    <div class="rows">
                        <input type="radio" name="tableChoice" id="cols">
                        <label for="cols"> Colunas </label>
                    </div>
                    <div class="rows">
                        <input type="radio" name="tableChoice" id="lines">
                        <label for="lines"> Linhas </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="rows stretch-test" >

        </div>
    </div>
</div>