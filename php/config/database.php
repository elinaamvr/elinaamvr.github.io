<?php

class Database{
  
    //Database credentials
    private $host = "localhost";
    private $db_name = "webeng20g2";
    private $username = "webeng20g2";
    private $password = "2021g2";
    public $conn;
  
    // get the database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
           
        }catch(PDOException $e){
            echo "Connection error: " . $e->getMessage();
        }
  
        return $this->conn;
    }
}

?>
