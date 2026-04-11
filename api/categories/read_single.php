<?php
// CORS HEADERS — MUST BE FIRST
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

// Validate parameter
if (!isset($_GET['id'])) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$category->id = $_GET['id'];

// Fetch single category
$result = $category->read_single();

if ($result) {
    echo json_encode([
        "id" => $result['id'],
        "category" => $result['category']
    ]);
} else {
    echo json_encode(["message" => "category_id Not Found"]);
}
