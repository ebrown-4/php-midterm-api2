<?php
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

$database = new Database();
$db = $database->connect();

$categories = new Categories($db);
$result = $categories->read();

$num = $result->rowCount();

if ($num > 0) {
    $categories_arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $categories_arr[] = [
            'id' => $row['id'],
            'category' => $row['category']
        ];
    }

    echo json_encode($categories_arr);
} else {
    echo json_encode(["message" => "No Categories Found"]);
}
