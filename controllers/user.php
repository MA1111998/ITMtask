<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../config.php";
include_once "../models/User.php";

$db = (new Database())->connect();
$user = new User($db);

function getAll(){
    global $user;
    $result = $user->get();
    $rtn = [];
    foreach($result as $row){
        $rtn[] = $row;  
    }
    echo json_encode($rtn);
    return $rtn;
}

function get($id){
    global $user;
    $result = $user->get($id);
    if($result->num_rows !== 1)
        echo json_encode("no such user");
    else
        echo json_encode($result->fetch_assoc());
}

function post($firstname,$lastname,$email,$telephone,$pass){
    global $user;
    $result = $user->post($firstname,$lastname,$email,$telephone,$pass);
    if ($result) {
        echo json_encode("Successfuly added");
    } else {
        echo json_encode("Sth went wrong");
    }
    
}

function delete($id){
    global $user;
    $result = $user->delete($id);
    if ($result) {
        echo json_encode("Successfuly deleted");
    } else {
        echo json_encode("Sth went wrong");
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = file_get_contents("php://input");
    $data = json_decode($raw);
    $firstname = $data->firstname;
    $lastname = $data->lastname;
    $email = $data->email;
    $telephone = $data->telephone;
    $pass = $data->pass;
    post($firstname,$lastname,$email,$telephone,$pass);
}
elseif($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        get($id);
    }
    else{
        getAll();
    }
}
elseif($_SERVER['REQUEST_METHOD'] === "DELETE"){
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        delete($id);
    }
    else{
        echo json_encode("id is required");
    }
}
else{
    echo json_encode("Not Allowed Method");
}