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
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

if (empty($data->id) || empty($data->quote) || empty($data->author_id) || empty($data->category_id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

// Check if quote exists
$existing = $quote->read_single();
if (!$existing) {
    echo json_encode(["message" => "quote_id Not Found"]);
    exit();
}

// Validate author_id exists
if (!$quote->authorExists()) {
    echo json_encode(["message" => "author_id Not Found"]);
    exit();
}

// Validate category_id exists
if (!$quote->categoryExists()) {
    echo json_encode(["message" => "category_id Not Found"]);
    exit();
}

if ($quote->update()) {
    echo json_encode([
        "id" => $quote->id,
        "quote" => $quote->quote,
        "author_id" => $quote->author_id,
        "category_id" => $quote->category_id
    ]);
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}
