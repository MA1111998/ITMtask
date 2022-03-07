<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../config.php";
include_once "../models/Contacts.php";

$db = (new Database())->connect();
$contacts = new Contacts($db);

function get($userid){
    global $contacts;
    $result = $contacts->get($userid);
    $rtn = [];
    foreach($result as $row){
        $rtn[] = $row;  
    }
    echo json_encode($rtn);
}


function post($userid,$contactname,$contacttelephone,$note){
    global $contacts;
    $result = $contacts->post($userid,$contactname,$contacttelephone,$note);
    if ($result) {
        echo json_encode("Successfuly added");
    } else {
        echo json_encode("Sth went wrong");
    }
    
}

function delete($userid,$contactname){
    global $contacts;
    $result = $contacts->delete($userid,$contactname);
    if ($result) {
        echo json_encode("Successfuly deleted");
    } else {
        echo json_encode("Sth went wrong");
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = file_get_contents("php://input");
    $data = json_decode($raw);
    $userid = $data->userid;
    $contactname = $data->contactname;
    $contacttelephone = $data->contacttelephone;
    $note = $data->note;
    post($userid,$contactname,$contacttelephone,$note);
}
elseif($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_GET['userid'])){
        $userid = $_GET['userid'];
        get($userid);
    }
    else{
        echo json_encode("please privide user id that u want contacts for");
    }
}
elseif($_SERVER['REQUEST_METHOD'] === "DELETE"){
    if(isset($_GET['userid']) && isset($_GET['contactname'])){
        $userid = $_GET['userid'];
        $contactname = $_GET['contactname'];
        delete($userid,$contactname);
    }
    else{
        echo json_encode("please send the user id and name of contact you want to delete");
    }
}
else{
    echo json_encode("Not Allowed Method");
}