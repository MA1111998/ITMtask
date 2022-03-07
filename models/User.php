<?php

class User{
    private $conn;
    private $table = "user";


    public function __construct($conn){
        $this->conn = $conn;
    }

    public function get(?int $id=null){
        if (!is_int($id)) {
            $sql = "SELECT * FROM " . $this->table;
        }
        else{
            $sql = "SELECT * FROM " . $this->table . ' ' .
            "WHERE id=" . $id ;
        }
        return $this->conn->query($sql);
    }
    public function post($firstname,$lastname,$email,$telephone,$pass){
        $sql = "INSERT INTO " . $this->table ."(firstname,lastname,email,telephone,pass) " . 
        "VALUES('$firstname','$lastname','$email','$telephone','$pass')";
        return $this->conn->query($sql);
    }
    public function delete($id){
        $sql = "DELETE FROM " . $this->table . " WHERE id=" . $id;
        return $this->conn->query($sql);
    }


}