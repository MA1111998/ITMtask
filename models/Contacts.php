<?php

class Contacts{
    private $conn;
    private $table = "contacts";


    public function __construct($conn){
        $this->conn = $conn;
    }

    public function get(?int $userid=null){
        if (!is_int($userid)) {
            return null;
        }
        else{
            $sql = "SELECT * FROM " . $this->table . 
            " WHERE userid=" . $userid ;
        }
        return $this->conn->query($sql);
    }
    public function post($userid,$contactname,$contacttelephone,$note){
        $sql = "INSERT INTO " . $this->table ."(userid,contactname,contacttelephone,note) " . 
        "VALUES('$userid','$contactname','$contacttelephone','$note')";
        return $this->conn->query($sql);
    }
    public function delete($userid,$contactname){
        $sql = "DELETE FROM " . $this->table . " WHERE userid=" . $userid . " AND contactname=". "'$contactname'";
        return $this->conn->query($sql);
    }


}