<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Categories.php');

$database = new Database();
$db = $database->connect();

$category = new Categories($db);

$data = json_decode(file_get_contents("php://input"));

$category->category = $data->category ?? null;

if ($category->create()) {
    echo json_encode(['message' => 'Category was created successfully']);
} else {
    echo json_encode(['message' => 'Category Not Created']);
}
