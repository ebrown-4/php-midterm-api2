<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

include_once('../../config/Database.php');
include_once('../../models/Categories.php');

$database = new Database();
$db = $database->connect();

$categories = new Categories($db);

$data = json_decode(file_get_contents("php://input"));

// Required field check
if (!isset($data->category) || empty(trim($data->category))) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$categories->category = $data->category;

// Create category
if ($categories->create()) {

    // Get the ID of the newly created category
    $new_id = $db->lastInsertId();

    echo json_encode([
        "id" => $new_id,
        "category" => $categories->category
    ]);
} else {
    echo json_encode(["message" => "Category Not Created"]);
}
