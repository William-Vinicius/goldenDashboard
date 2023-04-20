<?php 
class User{

    private $pdo;
    private $answer;
    public $errorMessage = "";

    public function connect($dbName, $host, $user, $password){
        global $pdo;
        global $errorMessage;
        
        try {
            $pdo = new PDO("mysql:host=".$host.";"."bdname=".$dbName, $user, $password);
            echo "Teste 1 Sucesso";
        }
        catch (PDOException $e) {
           $errorMessage = $e->getMessage();
           echo "Deu ruim meu confrade";
           echo $errorMessage;
        }
    }
    // public function login($user, $password){
    public function login(){
        global $pdo;
        global $answer;

        //buscar Login
        //$sql = $pdo->prepare("SELECT loginUser FROM tbUser WHERE loginUser LIKE 'TERA';");
        //$sql->bindValue(":user", $user);

        $sql = $pdo->prepare("SELECT * FROM tbUser");
        $sql->execute();
        echo " foi!";

        // if($sql->rowCount() <= 0){
        //     return false;
        //     echo "Usuário não encontrado"; // Apaga ou comenta essa linha dps
        // }
        // else{

        //     $sql = $pdo->prepare("SELECT idUser FROM usuarios WHERE loginUser LIKE :user");
        //     $sql->bindValue(":user", $user);
        //     $answer = $sql->execute();

        //     echo "Tentativa: ".$answer;

        //     if($answer == $password){
        //         return true;
        //     }
        // }
    }

    public function signIn($user, $password, $name, $email, $phone){
        global $pdo;

        //Boscar Login

        $sql = $pdo->prepare("SELECT idUser FROM usuarios WHERE loginUser LIKE :user");
        $sql->bindValue(":user", $user);
        $sql->execute();
        
        if ($sql->rowCount > 0) {
            return false;
        }
        else{
            //Inserindo nova conta usando parametros

            $sql = $pdo->prepare("
            INSERT INTO tbUser(nameUser, loginUser, emailUser, phoneUser, passwordUser) 
            VALUES (':name',':user',':email',':phone',':password')
            ");

            $sql->bindValue(":name", $name);
            $sql->bindValue(":user", $user);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":phone", $phone);
            $sql->bindValue(":password", md5($password));

            $sql->execute();
            return true;
       }
    }

}

?>