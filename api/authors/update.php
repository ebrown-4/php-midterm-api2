<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Author.php');

$database = new Database();
$db = $database->connect();

$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

$author->id = $data->id ?? null;
$author->name = $data->name ?? null;

if ($author->update()) {
    echo json_encode(['message' => 'Author was updated successfully']);
} else {
    echo json_encode(['message' => 'Author Not Updated']);
}
