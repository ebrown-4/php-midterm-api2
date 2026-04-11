<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Category.php');

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

$category->id = $data->id ?? null;
$category->name = $data->name ?? null;

if ($category->update()) {
    echo json_encode(['message' => 'Category was updated successfully']);
} else {
    echo json_encode(['message' => 'Category Not Updated']);
}
