<?php

class Database {
    //Database Connection
    private $db_server = "mysql:dbname=books; host=localhost; port=3308;";
    private $user_name = "root";
    private $password  = "";
    private $port  = "3308";
    protected $connection;
        
    public function __construct() {
        try {
            $this->connection = new PDO($this->db_server, $this->user_name, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // echo "Connected Successfully";
        } catch (PDOException $e) {
            echo "Error Message: " . $e->getMessage();
        }
    }
}