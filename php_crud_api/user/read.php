<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/Database.php';
include_once '../object/User.php';
 
// instantiate database and department object
$database = new Db();
$db = $database->getConnection();
// initialize object
$user = new User($db);
 
// query department
$stmt = $user->read();
$num = $stmt->rowCount();
// check if more than 0 record found
if ($num > 0) {
    // department array
    $user_arr = [];
    $user_arr = [];
 
    // retrieve table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        extract($row);
        $user_item = array(
            "id" => $row['user_id'],
            "name" => $row['user_name'],
            "pwd" => $row['user_pwd'],
            "email" => $row['user_email'],
            "options" => $row['user_options'],
            "created" => $row['user_created']
        );
        array_push($user_arr, $user_item);
    }
    echo json_encode($user_arr, JSON_PRETTY_PRINT);
} else {
    echo json_encode(
            array("message" => "No users found.")
    );
}
?>