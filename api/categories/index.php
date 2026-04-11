<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Category.php');

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$result = $category->read();
$num = $result->rowCount();

if ($num > 0) {
    $categories_arr = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $categories_arr[] = [
            'id' => $id,
            'name' => $name
        ];
    }
    echo json_encode($categories_arr);
} else {
    echo json_encode(['message' => 'No Categories Found']);
}
