<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Author.php');

$database = new Database();
$db = $database->connect();

$author = new Author($db);

$author->id = isset($_GET['id']) ? $_GET['id'] : die();

$author->read_single();

if ($author->name) {
    echo json_encode([
        'id' => $author->id,
        'name' => $author->name
    ]);
} else {
    echo json_encode(['message' => 'Author Not Found']);
}
