<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Exemplo</title>
</head>
<body>
	<h1 class="title"></h1>
	<input type="text" id="filter" onchange="">
	<input type="button" value="No Ideas :/" onclick="api.useApi('2023-05-01 00:00:00' , '2023-05-01 23:59:59', 1)" >
	<input type="date" name="" id="dtInicio">
	<input type="date" name="" id="dtFinal">
	<input type="button" value="Sort Table" onclick="">
	<input type="button" value="Make Table" onclick="dat.formactTable(2)">
	<div id="tabela"></div>
	<script src="ApiInfo.js"></script>
	<script>
		const dat = new DataWorks()
	</script>
</body>
</html>