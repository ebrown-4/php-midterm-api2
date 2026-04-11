<?php
// CORS HEADERS — MUST BE FIRST
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);

if (!isset($_GET['id'])) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$author->id = $_GET['id'];

$result = $author->read_single();

if ($result) {
    echo json_encode([
        'id' => $result['id'],
        'author' => $result['author']
    ]);
} else {
    echo json_encode(["message" => "author_id Not Found"]);
}
