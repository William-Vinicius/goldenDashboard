<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Exemplo</title>
</head>
<style> 
table {
    border-collapse: collapse;
    border-color: #353a77;

}
tr:first-child td:first-child {
    background-color: gray;
}
</style>
<body>
	<h1 class="title"></h1>
	<input type="button" value="Me Aperta Poh" onclick="api.useApi('2023-05-01 00:00:00' , '2023-05-01 23:59:59', 1)" >
	<input type="date" name="" id="dtInicio">
	<input type="date" name="" id="dtFinal">
	<input type="button" value="Table" onclick="api.drawDataTable('','')">
	<input type="button" value="Test" onclick="dat.formactTable(1)">
	<div id="tabela"></div>
	<script src="ApiInfo.js"></script>
	<script>
		const dat = new DataWorks()
	</script>
</body>
</html>