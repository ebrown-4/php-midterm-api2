<?php
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$category->id = isset($_GET['id']) ? $_GET['id'] : die(json_encode(["message" => "Missing Required Parameters"]));

$result = $category->read_single();
$row = $result->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode([
        "id" => $row['id'],
        "category" => $row['category']
    ]);
} else {
    echo json_encode(["message" => "Category Not Found"]);
}
