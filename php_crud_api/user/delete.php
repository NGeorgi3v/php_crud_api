<?php
 
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
// include database and object files
include_once '../config/Database.php';
include_once '../object/User.php';
 
$database = new Db();
$db = $database->getConnection();
 
// initialize object
$user = new User($db);
 
// set ID property of user to be deleted
$user->id = filter_input(INPUT_GET, 'id');
 
// delete the user
if ($user->delete()) {
    echo '{';
    echo '"message": "user was deleted."';
    echo '}';
}
 
// if unable to delete the user
else {
    echo '{';
    echo '"message": "Unable to delete user."';
    echo '}';
}
?>