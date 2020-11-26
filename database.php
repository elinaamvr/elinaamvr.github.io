<?php

class Database{
  
    //Database credentials
    private $host = "nireas.it.teithe.gr:3306";
    private $db_name = "webeng20g2";
    private $username = "webeng20g2";
    private $password = "2021g2";
    public $conn;
  
    // Database connection
      public function getConnection(){
  
         try{
            $conn = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name,$this->username,$this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e){
            echo "1Connection error ".$e->getMessage(); 
            exit;
        }
          
    }
}
 
?>
