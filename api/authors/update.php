<?php
// CORS HEADERS — MUST BE FIRST
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

if ($method !== 'PUT') {
    echo json_encode(["message" => "Invalid Request Method"]);
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

if (empty($data->id) || empty($data->author)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$author->id = $data->id;
$author->author = $data->author;

// Check if author exists
$existing = $author->read_single();
if (!$existing) {
    echo json_encode(["message" => "author_id Not Found"]);
    exit();
}

if ($author->update()) {
    echo json_encode([
        "id" => $author->id,
        "author" => $author->author
    ]);
} else {
    echo json_encode(["message" => "No Authors Found"]);
}
