<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Quotes.php');

$database = new Database();
$db = $database->connect();

$quote = new Quotes($db);

$data = json_decode(file_get_contents("php://input"));

$quote->quote = $data->quote ?? null;
$quote->author_id = $data->author_id ?? null;
$quote->category_id = $data->category_id ?? null;

if ($quote->create()) {
    echo json_encode(['message' => 'Quote was created successfully']);
} else {
    echo json_encode(['message' => 'Quote Not Created']);
}
