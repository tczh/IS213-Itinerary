<?php
    class UserDAO{

        # Retrieve a user with a given username
        # Return null if no such user exists
        public function retrieve($email){
            $conn_manager = new ConnectionManager();
            $pdo = $conn_manager->getConnection();
            
            $sql = "select * from login where email=:email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":email",$email,PDO::PARAM_STR);
            $stmt->execute();
            
            $user = null;
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if($row = $stmt->fetch()){
                $user = new User($row['userid'], $row["email"],$row["password"]);
            }
            
            $stmt = null;
            $pdo = null;
            return $user;
        }

        public function retrieveUserId($userid){
            $conn_manager = new ConnectionManager();
            $pdo = $conn_manager->getConnection();
            
            $sql = "select * from login where userid=:userid";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":userid",$userid,PDO::PARAM_STR);
            $stmt->execute();
            
            $user = null;
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if($row = $stmt->fetch()){
                $user = new User($row['userid'], $row["email"],$row["password"]);
            }
            
            $stmt = null;
            $pdo = null;
            return $user;
        }

        public function register($userid, $email, $hashed_password, $first, $last, $country) {

            // Step 1 - Connect to Database
            $connMgr = new ConnectionManager();
            $pdo = $connMgr->getConnection();

            var_dump($userid, $email, $hashed_password, $first, $last, $country);
    
            // Step 2 - Prepare SQL
            $sql = "INSERT INTO login VALUES (
                        :userid, :email, :first, :last, :hashed_password, 1, :country, '', ''
                    )
            ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':hashed_password', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':first', $first, PDO::PARAM_STR);
            $stmt->bindParam(':last', $last, PDO::PARAM_STR);
            $stmt->bindParam(':country', $country, PDO::PARAM_STR);
            
            // Step 3 - Execute SQL
            $result = $stmt->execute();

            var_dump($result);
            
            // Step 5 - Clear Resources
            $stmt = null;
            $pdo = null;
    
            // Step 6 - Return
            return $result;
        }

        public function generateUserId(){
            $conn_manager = new ConnectionManager();
            $pdo = $conn_manager->getConnection();
            
            $sql = "select count(userid) from login";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            
            $count = null;
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $count = $stmt->fetch();
            
            $stmt = null;
            $pdo = null;
            return $count["count(userid)"] + 1;
        }

        
    }
?>