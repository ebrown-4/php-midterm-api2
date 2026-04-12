<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

include_once('../../config/Database.php');
include_once('../../models/Categories.php');

$database = new Database();
$db = $database->connect();

$categories = new Categories($db);

$data = json_decode(file_get_contents("php://input"));

// Required field check
if (!isset($data->category) || empty(trim($data->category))) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit;
}

$categories->category = $data->category;

// Create category
$result = $categories->create();

if ($result) {
    echo json_encode([
        "id" => $result["id"],
        "category" => $categories->category
    ]);
} else {
    echo json_encode(["message" => "Category Not Created"]);
}
