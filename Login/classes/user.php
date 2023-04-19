<?php 
class User{

    private $pdo;
    public $errorMessage = "";

    public function connect($dbName, $host, $user, $password){
        global $pdo;
        global $errorMessage;
        
        try {
            $pdo = new PDO("mysql:bdname=".$dbName.";host=".$host, $user, $password);
        }
        catch (PDOException $e) {
           $errorMessage = $e->getMessage();
        }
    }
    public function login($user, $password){
        global $pdo;

        $sql = $pdo->prepare("SELECT idUser FROM usuarios WHERE loginUser = :user");
        $sql->bindValue(":user", $user);
        $sql->execute();

        if($sql->rowCount() < 0){
            return false;
        }
    }

    public function signIn($user, $password, $name, $email, $phone){
        global $pdo;

        $sql = $pdo->prepare("SELECT idUser FROM usuarios WHERE loginUser = :user");
        $sql->bindValue(":user", $user);
        $sql->execute();
        
        if ($sql->rowCount > 0) {
            return false;
        }
        else{
            $sql = $pdo->prepare("
            INSERT INTO tbUser(nameUser, loginUser, emailUser, phoneUser, passwordUser) 
            VALUES (':name',':user',':email',':phone',':password')
            ");

            $sql->bindValue(":name", $name);
            $sql->bindValue(":user", $user);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":phone", $phone);
            $sql->bindValue(":password", $password);

            $sql->execute();
            return true;
       }
    }

}

?>