<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Author.php');

$database = new Database();
$db = $database->connect();

$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

$author->name = $data->name ?? null;

if ($author->create()) {
    echo json_encode(['message' => 'Author was created successfully']);
} else {
    echo json_encode(['message' => 'Author Not Created']);
}
