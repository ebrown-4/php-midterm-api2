<?php
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->category)) {
    $category->id = $data->id;
    $category->category = $data->category;

    if ($category->update()) {
        echo json_encode(["message" => "Category was updated successfully"]);
    } else {
        echo json_encode(["message" => "Category Not Updated"]);
    }
} else {
    echo json_encode(["message" => "Missing Required Parameters"]);
}
