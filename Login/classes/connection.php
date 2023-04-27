<?php 
    
    include_once PROJECT_ROOT_PATH . '/header/contentHead.php';

    class User
    {

        private $pdo;
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

            $query = "SELECT idUser, passwordUser, nameUser FROM tbUser WHERE loginUser LIKE :username LIMIT 1;";
            $resultQuery = $pdo->prepare($query);
            $resultQuery->bindParam(':username', $username, PDO::PARAM_STR);
            $resultQuery->execute();

            if($resultQuery->rowCount() > 0){
                $validation = $resultQuery->fetch(PDO::FETCH_ASSOC);
                var_dump($validation);

                if (password_verify($password ,$validation['passwordUser'])) {
                    $nameCookie = "LoginValidation";
                    // setcookie($nameCookie, $validation['nameUser'],time()+60 * 60 * 1);
                    setcookie($nameCookie, $validation['nameUser'],  time()+10);
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
        public function registerUser($name, $login, $email, $phone, $password)
        {
            global $pdo;

            $query = "SELECT idUser FROM tbUser WHERE loginUser LIKE :username LIMIT 1;";
            $resultQuery = $pdo->prepare($query);
            $resultQuery->bindParam(':username', $login, PDO::PARAM_STR);
            $resultQuery->execute();

            if($resultQuery->rowCount() > 0){
                return false;
            }
            else{
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
    }
    






?>