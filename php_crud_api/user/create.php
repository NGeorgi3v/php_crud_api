<?php
 
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/Database.php';
include_once '../object/User.php';
 
$database = new Db();
$db = $database->getConnection();
 
// initialize object
$user = new User($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input", true));
// set user property values
$user->name = $data->name;
$user->pwd = $data->password;
$user->email = $data->email;
$user->options = $data->options;
 
// create the department
if ($user->create()) {
    echo '{';
    echo '"message": "Department was created."';
    echo '}';
}
 
// if unable to create the department, tell the user
else {
    echo '{';
    echo '"message": "Unable to create department."';
    echo '}';
}