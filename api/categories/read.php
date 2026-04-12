<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Categories.php');

$database = new Database();
$db = $database->connect();

$categories = new Categories($db);

// If ID is provided, return a single category
if (isset($_GET['id'])) {
    $categories->id = $_GET['id'];

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

    exit;
}

// Otherwise return all categories
$result = $categories->read();
$num = $result->rowCount();

if ($num > 0) {
    $categories_arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $categories_arr[] = [
            "id" => $row['id'],
            "category" => $row['category']
        ];
    }

    echo json_encode($categories_arr);
} else {
    echo json_encode(["message" => "No Categories Found"]);
}
