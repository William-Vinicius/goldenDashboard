<?php 
    session_start();

    class User
    {


        public $pdo;

        function connection(){
            
            $dbname = 'loginTest';
            $host = 'localhost';
            $port= 3306;
            $dbuser = 'root';
            $dbpassword = 'admin';

            global $pdo;

            try{
                $pdo = new PDO("mysql:dbname$dbname;host=$host;port=$port", $dbuser, $dbpassword);
                
                $useQuery = "USE $dbname";  
                $useDb = $pdo->prepare($useQuery);
                $useDb->execute();
                return true;
        
            }
            catch(PDOException $erro){
                return false;
            }
        }

        function login($username, $password)
        {
            global $pdo;

            $query = "SELECT idUser, passwordUser FROM tbUser WHERE loginUser LIKE :username LIMIT 1;";
            $resultQuery = $pdo->prepare($query);
            $resultQuery->bindParam(':username', $username, PDO::PARAM_STR);
            $resultQuery->execute();

            if($resultQuery->rowCount() > 0){
                $validation = $resultQuery->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password ,$validation['passwordUser'])) {
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
        public function signUp($name, $login, $email, $phone, $password)
        {
            
        }
    }
    






?>