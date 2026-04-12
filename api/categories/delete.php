<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

include_once('../../config/Database.php');
include_once('../../models/Categories.php');

$database = new Database();
$db = $database->connect();

$categories = new Categories($db);

$data = json_decode(file_get_contents("php://input"));

// Required field check
if (!isset($data->id) || empty($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit;
}

$categories->id = $data->id;

// Attempt delete
$result = $categories->delete();

if ($result) {
    echo json_encode(["id" => $result["id"]]);
} else {
    echo json_encode(["message" => "category_id Not Found"]);
}
