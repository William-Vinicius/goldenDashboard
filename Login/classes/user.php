<?php
// include '../autoload.php';
class connection{

    private $dbname = 'loginTest';
    private $host = 'localhost';
    private $port= 3306;
    private $dbuser = 'root';
    private $dbpassword = 'admin';
    private $pdo;


    public function getConnection(){
        
        global $dbname;
        global $host;
        global $port;
        global $dbuser;
        global $dbpassword;
        global $pdo;

        try{
            $pdo = new PDO("mysql:dbname$dbname;host=$host;port=$port", $dbuser, $dbpassword);
            
            $useQuery = "USE :dbname";  
            $useDb = $pdo->prepare($useQuery);
            $useDb->bindParam(':dbname', $dbname);
            $useDb->execute();
            return true;
    
        }
        catch(PDOException $erro){
            return $erro;
        }
    }   

    /*Get the value of pdo*/ 
    public function getPdo(){
        if($this->getConnection()){
            return $this->pdo;
        }
        else{
            return false;
        }
    }
    
    /*Set the value of dbpassword*/
    public function setDbpassword($dbpassword){
        $this->dbpassword = $dbpassword;
        return $this;
    }
    /*Set the value of port*/ 
    public function setPort($port){
        $this->port = $port;
        return $this;
    }
    /*Set the value of dbuser*/ 
    public function setDbuser($dbuser){
        $this->dbuser = $dbuser;
        return $this;
    }
    /*Set the value of host*/ 
    public function setHost($host){
        $this->host = $host;
        return $this;
    }
    /*Set the value of dbname*/ 
    public function setDbname($dbname){
        $this->dbname = $dbname;
        return $this;
    }
}

$connection = new connection();
class user
{
    public function login($username, $password){
        $query = "SELECT idUser, passwordUser, nameUser FROM tbUser WHERE loginUser LIKE :username LIMIT 1;";
        $result = $this->rowCount($query, $username, "");

        if($result[0] == true){
            $validation = $result[1]->fetch(PDO::FETCH_ASSOC);
            // var_dump($validation);

            if (password_verify($password ,$validation['passwordUser'])) {
                $nameCookie = "LoginValidation"; // Tornar função getCookieName
                // setcookie($nameCookie, $validation['nameUser'],time()+60 * 60 * 1);
                setcookie($nameCookie, $validation['nameUser'],  time()+100);
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public function registerUser($name, $login, $email, $phone, $password){
        $result = $this->rowCount("", $login, "");

        if($result[0]){
            return false;
        }
        else{
            global $connection;
            $pdo = $connection->getPdo();

            $password = password_hash($password, PASSWORD_DEFAULT);

            $query = "insert into tbUser (nameUser, loginUser, emailUser, phoneUser, passwordUser)
            VALUES (:name, :login, :email, :phone, :password );";
            $resultQuery = $pdo->prepare($query);

            $resultQuery->bindParam(':name', $name, PDO::PARAM_STR);
            $resultQuery->bindParam(':login', $login, PDO::PARAM_STR);
            $resultQuery->bindParam(':email', $email, PDO::PARAM_STR);
            $resultQuery->bindParam(':phone', $phone, PDO::PARAM_STR);
            $resultQuery->bindParam(':password', $password, PDO::PARAM_STR);
            $resultQuery->execute();
            
            return true;
        }
    }

    public function recoverPswLink($login){
        $resultQuery = $this->rowCount("", $login, "");

        if($resultQuery[0] == true){
            global $connection;
            $pdo = $connection->getPdo();

            $validation = $resultQuery[1]->fetch(PDO::FETCH_ASSOC);
            $recoveryKey = password_hash($validation['idUser'],  PASSWORD_DEFAULT);

            $query = "UPDATE tbUser SET recoveryCode = :recoveryKey where idUser = :id LIMIT 1";
            $result = $pdo->prepare($query);
            
            $result->bindParam(':recoveryKey', $recoveryKey, PDO::PARAM_STR);
            $result->bindParam(':id', $validation['idUser'], PDO::PARAM_STR);
            $result->execute();
            $_SESSION['message'] = "localhost:8000/registrations/passwordRefresh.php?key=" . $recoveryKey;
            return true;
        }
        else{
            return false;
        }
    }
    
    public function recoveryCheck($passwordKey){
        if($passwordKey == null){
            return [false, false];
        }
        else{
            $query = "SELECT idUser FROM tbUser WHERE RecoveryCode LIKE :passwordKey LIMIT 1;";
            $resultQuery = $this->rowCount($query, $passwordKey, ":passwordKey");
            
            return $resultQuery;
        }
    }

    public function recoverPsw($passwordKey, $newPassword){
        $resultQuery = $this->recoveryCheck($passwordKey);

        if($resultQuery[0] == true){
            global $connection;
            $pdo = $connection->getPdo();
            
            $validation = $resultQuery[1]->fetch(PDO::FETCH_ASSOC);
            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $query = "UPDATE tbUser SET passwordUser = :newPassword where idUser = :id LIMIT 1";
            $resultQuery = $pdo->prepare($query);
            $resultQuery->bindParam(':newPassword', $newPassword, PDO::PARAM_STR);
            $resultQuery->bindParam(':id', $validation['idUser'], PDO::PARAM_STR);
            $resultQuery->execute();
            
            $query = "UPDATE tbUser SET RecoveryCode = null WHERE idUser = :id LIMIT 1";
            $resultQuery = $pdo->prepare($query);
            $resultQuery->bindParam(':id', $validation['idUser'], PDO::PARAM_STR);
            $resultQuery->execute();

            return true;
        }
        else{
            return false;
        }
    }

    private function rowCount(string $query, $key, string $param){

        if($query == ""){
            $query = "SELECT idUser FROM tbUser WHERE loginUser LIKE :username LIMIT 1;";
        }
        if($param == ""){
            $param = ":username";
        }

        global $connection;
        $pdo = $connection->getPdo();

        $resultQuery = $pdo->prepare($query);
        $resultQuery->bindParam($param, $key, PDO::PARAM_STR);
        $resultQuery->execute();
        
        if ($resultQuery->rowCount() > 0){
            return [true, $resultQuery]; // Maior que 0 
        }
        else{
            return [false, $resultQuery];
        }
    }


    //Separar isso em uma classe

    private string $order;
    
    public function getUsers($maxValues = 50){

        global $connection;
        $pdo = $connection->getPdo();

        $connection->getConnection();
        
        // if($id != ''){
        $query = "SELECT idUser, nameUser, loginUser FROM tbUser ". $this->getOrder() ." LIMIT :limitKey";
        $resultQuery = $pdo->prepare($query);
        $resultQuery->bindParam(':limitKey', $maxValues, PDO::PARAM_INT);
        $resultQuery->execute();
        $arrUser = $resultQuery->fetchAll();

        // Tabulando o Conteúdo 

        $cont = 0;
        echo "<table>";
        foreach($arrUser as &$userCol){
            echo "<tr>";
            foreach($userCol as &$userLine){
                if($cont >= 1){
                    $cont = 0;
                }
                else{
                    echo "<td>";
                    echo $userLine;
                    $cont++;
                }
            }
        }
        // }
    }

    public function getOrder(){
        if(isset($order) && $order != ""){
            return $this->order;
        }

    }
    public function setOrder($order){
        $this->order = "ORDER BY $order";
        return $this;
    }
}