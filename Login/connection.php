<?php 

    $dbname = "loginTest";
    $host = "localhost";
    $port= 3306;
    $dbuser = "root";
    $password = "admin";

    try{
        $pdo = new PDO("mysql:dbname$dbname;host=$host;port=$port", $dbuser, $password);
        
        $query = "USE $dbname";  
        $useDb = $pdo->prepare($query);
        $useDb->execute();

        echo "Conexão realizada com sucesso, meu confrade";
    }
    catch(PDOException $erro){
        echo "Deu ruim meu camarada". $erro->getMessage();
    }




?>