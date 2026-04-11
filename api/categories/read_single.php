<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Category.php');

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$category->id = isset($_GET['id']) ? $_GET['id'] : die();

$category->read_single();

if ($category->name) {
    echo json_encode([
        'id' => $category->id,
        'name' => $category->name
    ]);
} else {
    echo json_encode(['message' => 'Category Not Found']);
}
