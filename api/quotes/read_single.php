<?php
// CORS HEADERS — MUST BE FIRST
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

// Validate parameter
if (!isset($_GET['id'])) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$quote->id = $_GET['id'];

// Fetch single quote
$result = $quote->read_single();

if ($result) {
    echo json_encode([
        "id" => $result['id'],
        "quote" => $result['quote'],
        "author" => $result['author'],
        "category" => $result['category']
    ]);
} else {
    echo json_encode(["message" => "quote_id Not Found"]);
}
