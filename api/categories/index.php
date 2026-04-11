<?php
// CORS HEADERS — MUST BE FIRST
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// DATABASE + MODEL
include_once '../../config/Database.php';
include_once '../../models/Categories.php';

$database = new Database();
$db = $database->connect();

$categories = new Categories($db);

// ONLY HANDLE GET HERE
if ($method === 'GET') {

    // If ?id= is provided → return single category
    if (isset($_GET['id'])) {
        $categories->id = $_GET['id'];
        $result = $categories->read_single();

        if ($result) {
            echo json_encode([
                'id' => $result['id'],
                'category' => $result['category']
            ]);
        } else {
            echo json_encode(["message" => "category_id Not Found"]);
        }
        exit();
    }

    // Otherwise → return all categories
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

    exit();
}

// If method is not GET
echo json_encode(["message" => "Invalid Request Method"]);
