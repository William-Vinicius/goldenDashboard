<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Exemplo</title>
</head>
<body>
	<h1 class="title"></h1>
	<input type="button" value="Me Aperta Poh" onclick="apiInfo.useApi('2023-05-01 00:00:00' , '2023-05-01 23:59:59', 1)" >
	<input type="button" value="Me Aperta Poh" onclick="apiInfo.TableApiData('','')">
	<div id="tabela"></div>
	<script src="ApiInfo.js"></script>
	<script>
		let apiInfo = new ApiInfo();
	</script>
</body>
</html>
