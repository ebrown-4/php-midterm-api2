<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Categories.php');

$database = new Database();
$db = $database->connect();

$category = new Categories($db);

$category->id = isset($_GET['id']) ? $_GET['id'] : die();

$category->read_single();

if ($category->category) {
    echo json_encode([
        'id' => $category->id,
        'category' => $category->category
    ]);
} else {
    echo json_encode(['message' => 'Category Not Found']);
}
