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
include_once '../../models/Authors.php';

$database = new Database();
$db = $database->connect();

$authors = new Authors($db);

// ROUTING BASED ON METHOD
if ($method === 'GET') {

    // If ?id= is provided → return single author
    if (isset($_GET['id'])) {
        $authors->id = $_GET['id'];
        $result = $authors->read_single();

        if ($result) {
            echo json_encode([
                'id' => $result['id'],
                'author' => $result['author']
            ]);
        } else {
            echo json_encode(["message" => "author_id Not Found"]);
        }
        exit();
    }

    // Otherwise → return all authors
    $result = $authors->read();
    $num = $result->rowCount();

    if ($num > 0) {
        $authors_arr = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $authors_arr[] = [
                'id' => $row['id'],
                'author' => $row['author']
            ];
        }

        echo json_encode($authors_arr);
    } else {
        echo json_encode(["message" => "No Authors Found"]);
    }

    exit();
}

// If method is not GET
echo json_encode(["message" => "Invalid Request Method"]);
