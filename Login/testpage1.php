<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="src/img/favcon.png">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <title>Dashboard1</title>
</head>
<body>
    <!-- Como eu uso esse menu em outras páginass pohaaaaaaaaaa -->
    <nav>
        <h1>Menu Principal</h1>
        <div class="menu-dad">
            <input type="checkbox" name="" id="menu-check">
            <div class="menu-margin">
                <label for="menu-check" id="menu-draw">
                    
                    <i class="ph-bold ph-list" style="color:#cbd0ff; font-size: 2.5rem;"></i>
                    <i class="ph-bold ph-x" style="color:#cbd0ff; font-size: 2.5rem;"></i>

                </label>
            </div>

            <div class="menu-bar">
                <ul>
                    <a href="#"><li class="menu-box">Principal</li></a>
                    <a href="#"><li class="menu-box">Dashboard1</li></a>
                    <a href="#"><li class="menu-box">Dashboard2</li></a>
                    <a href="#"><li class="menu-box">Dashboard3</li></a>
                </ul>
            </div>
        </div>
    </nav> 
    <!-- Final do menu -->

    <div class="dad">
        <div class="container">

            <header>
                <h1>Dashboard1</h1>
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



                        <div class="rows">
                            <input type="date" name="dt-search-beginning" id="dtInicio"class="dt-input">
                            <spam class="lil-margin"> - </spam>
                            <input type="date" name="dt-search-end" id="dtFinal" class="dt-input">
                        </div>
                    </div>
                        
                    <input type="button" value="Pesquisar" onclick="dat.formactTable(1)" class="bt-color src-button">

                    <div class="rows space-down">
                            <input type="search" name="txFilter" id="txFilter" class="txInput" maxlength="16" placeholder="Filtrar">
                            <label for="btFilter">
                                
                                <i class="ph-bold ph-magnifying-glass" style="color:#282a49; font-size: 1.5rem; cursor: pointer;"></i>
                               
                            </label>
                            <input type="button" value="filtrar" id="btFilter" onclick="" class="no-display">
                    </div>

                </div>
            </div>
            <div id="tabela" class = "txInput"></div>
        </div>
    </div>


    <script src="classes/ApiInfo.js"></script>
	<script>
		const dat = new DataWorks()
	</script>
</body>
</html>