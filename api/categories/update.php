<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

include_once('../../config/Database.php');
include_once('../../models/Categories.php');

$database = new Database();
$db = $database->connect();

$categories = new Categories($db);

$data = json_decode(file_get_contents("php://input"));

// Required fields check
if (!isset($data->id) || !isset($data->category) || empty(trim($data->category))) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit;
}

$categories->id = $data->id;
$categories->category = $data->category;

// Attempt update
if ($categories->update()) {
    echo json_encode([
        "id" => $categories->id,
        "category" => $categories->category
    ]);
} else {
    echo json_encode(["message" => "category_id Not Found"]);
}
