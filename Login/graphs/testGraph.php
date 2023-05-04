<?php 
    include '../autoload.php';
    $head = new head();
    $user = new user();

    $head->setTitle('GráficoTeste')

?>
<div class="dad">
    <div class="container">
        <header>
            <!-- alhsgdlsaih -->
        </header>
        <div class="rows">
            <div class="columns">
                <div>
                    <select id="months" name="months" class="txInput space-up">
                        <option>Selecione um Período</option>

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
            
            <div class="columns">
                <div>
                    <div class="drawSearch src-button">
                        Metas
                        <i class="ph ph-caret-down"></i>
                    </div>
                </div>

                <div>

                </div>
            </div>
        </div>
        <div class="rows">

        </div>
    </div>
</div>