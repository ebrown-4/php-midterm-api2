<?php
// CORS HEADERS — MUST BE FIRST
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

if ($method !== 'PUT') {
    echo json_encode(["message" => "Invalid Request Method"]);
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if (empty($data->id) || empty($data->category)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$category->id = $data->id;
$category->category = $data->category;

// Check if category exists
$existing = $category->read_single();
if (!$existing) {
    echo json_encode(["message" => "category_id Not Found"]);
    exit();
}

if ($category->update()) {
    echo json_encode([
        "id" => $category->id,
        "category" => $category->category
    ]);
} else {
    echo json_encode(["message" => "No Categories Found"]);
}
