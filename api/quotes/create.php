<?php
// CORS HEADERS — MUST BE FIRST
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

if ($method !== 'POST') {
    echo json_encode(["message" => "Invalid Request Method"]);
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

// Read JSON body
$data = json_decode(file_get_contents("php://input"));

if (empty($data->quote) || empty($data->author_id) || empty($data->category_id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

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

// Create quote
if ($quote->create()) {
    echo json_encode([
        "id" => $quote->id,
        "quote" => $quote->quote,
        "author_id" => $quote->author_id,
        "category_id" => $quote->category_id
    ]);
} else {
    echo json_encode(["message" => "Quote Not Created"]);
}
