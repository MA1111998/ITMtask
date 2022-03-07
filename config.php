<?php

class Database{
    private $server = "localhost";
    private $username = "username";
    private $password = "password";
    private $databaseName = "taskDB";
    private $conn = null;

    public function __construct(){
        $this->conn = new mysqli($this->server,$this->username,$this->password);
        $this->conn->select_db($this->databaseName);
        $this->initialize();
    }

    public function connect(){
        return $this->conn;
    }

    private function initialize(){
        $sql = "CREATE TABLE IF NOT EXISTS user(
        id INT AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(50) NOT NULL,
        lastname VARCHAR(50) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        telephone VARCHAR(11) UNIQUE NOT NULL,
        pass VARCHAR(40) NOT NULL
        )";
        $this->conn->query($sql);
        $sql = "CREATE TABLE IF NOT EXISTS contacts(
        userid INT,
        contactname VARCHAR(50) NOT NULL,
        contacttelephone VARCHAR(50) NOT NULL,
        note varchar(100),
        PRIMARY KEY (userid, contactname)
        )";
        $this->conn->query($sql);
    }
}
