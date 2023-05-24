<?php 

class connection{

    private $dbname = 'loginTest';
    private $host = 'localhost';
    private $port= 3306;
    private $dbuser = 'root';
    private $dbpassword = 'admin';

    private $pdo;


    public function getConnection(){
        
        $dbname = $this->dbname;
        $host = $this->host;
        $port = $this->port;
        $dbuser = $this->dbuser;
        $dbpassword = $this->dbpassword;
        $pdo = $this->pdo;

        try{
            $pdo = new PDO("mysql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpassword);
            
            $useQuery = "USE $dbname;";  
            $useDb = $pdo->prepare($useQuery);
            $useDb->execute();
            $this->pdo = $pdo;
            
            return true;
    
        }
        catch(PDOException $erro){

            error_log($erro); 
            return false;
        }
    }   

    /*Get the value of pdo*/ 
    public function getPdo(){
        if($this->getConnection()){
            echo "teste2";
            var_dump($this->pdo);
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