<?php
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $category->id = $data->id;

    if ($category->delete()) {
        echo json_encode(["message" => "Category was deleted successfully"]);
    } else {
        echo json_encode(["message" => "Category Not Deleted"]);
    }
} else {
    echo json_encode(["message" => "Missing Required Parameters"]);
}
