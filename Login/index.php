<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>


    <div class="dad">
        <div class="container columns centraliser">
            <header class="centraliser">
                <h1 class="center-text">Bem Vindo</h1>
                <h2 class="center-text dark-font">Faça seu Login de membro</h2>
            </header>
            <form action="test.php" method="POST" class="columns centraliser">
                <input type="text" name="login" class="login-input txInput" placeholder="Usuário" required>
                <input type="password" name="password" class="login-input txInput" placeholder="Senha" required>
                <input type="submit" value="Acessar" class="bt-color switch-button login-btn">
            </form>
        </div>
    </div>
</body>
</html>