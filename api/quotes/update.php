<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Quote.php');

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

$quote->id = $data->id ?? null;

if ($quote->delete()) {
    echo json_encode(['message' => 'Quote was deleted successfully']);
} else {
    echo json_encode(['message' => 'Quote Not Deleted']);
}
