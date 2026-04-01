<?php
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->category)) {
    $category->category = $data->category;

    if ($category->create()) {
        echo json_encode(["message" => "Category was created successfully"]);
    } else {
        echo json_encode(["message" => "Category Not Created"]);
    }
} else {
    echo json_encode(["message" => "Missing Required Parameters"]);
}
