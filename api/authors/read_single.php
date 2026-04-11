<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Authors.php');

$database = new Database();
$db = $database->connect();

$author = new Authors($db);

$author->id = isset($_GET['id']) ? $_GET['id'] : die();

$author->read_single();

if ($author->author) {
    echo json_encode([
        'id' => $author->id,
        'author' => $author->author
    ]);
} else {
    echo json_encode(['message' => 'Author Not Found']);
}
