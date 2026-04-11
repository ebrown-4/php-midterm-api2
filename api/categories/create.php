<?php
// CORS HEADERS — MUST BE FIRST
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

if ($method !== 'POST') {
    echo json_encode(["message" => "Invalid Request Method"]);
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

// Read JSON body
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->category)) {

    $category->category = $data->category;

    if ($category->create()) {
        // Return created category (REQUIRED BY RUBRIC)
        echo json_encode([
            "id" => $category->id,
            "category" => $category->category
        ]);
    } else {
        echo json_encode(["message" => "Category Not Created"]);
    }
} else {
    echo json_encode(["message" => "Missing Required Parameters"]);
}
