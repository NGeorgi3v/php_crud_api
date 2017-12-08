<?php
 
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
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

// set ID property of department to be updated
$user->id = $data->id;
// set department property value
$user->name = $data->name;
$user->email = $data->email;
$user->pwd = $data->pwd;
$user->options = $data->options;
// update the user
if ($user->update()) {
    echo '{';
    echo '"message": "User was updated."';
    echo '}';
}
 
// if unable to update the user, tell the user
else {
	echo $user->update();
    echo '{';
    echo '"message": "Unable to update user."';
    echo '}';
}