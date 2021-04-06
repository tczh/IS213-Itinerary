<?php
class ConnectionManager {
    public function getConnection() {        
        $dsn  = "mysql:host=localhost;dbname=wadproject";
        return new PDO($dsn, "root", "");  
    }
}
?>