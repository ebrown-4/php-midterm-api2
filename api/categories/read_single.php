<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Categories.php');

$database = new Database();
$db = $database->connect();

$categories = new Categories($db);

// Must have an ID
$categories->id = isset($_GET['id']) ? $_GET['id'] : die();

$result = $categories->read_single();
$row = $result->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode([
        "id" => $row['id'],
        "category" => $row['category']
    ]);
} else {
    echo json_encode(["message" => "category_id Not Found"]);
}
