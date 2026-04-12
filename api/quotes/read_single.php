<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

include_once('../../config/Database.php');
include_once('../../models/Quotes.php');

$database = new Database();
$db = $database->connect();

$quotes = new Quotes($db);

// Validate ID
$quotes->id = isset($_GET['id']) ? $_GET['id'] : die(json_encode(["message" => "Missing Required Parameter"]));

// Fetch single quote
if ($quotes->read_single()) {
    echo json_encode([
        "id" => $quotes->id,
        "quote" => $quotes->quote,
        "author_id" => $quotes->author_id,
        "category_id" => $quotes->category_id
    ]);
} else {
    echo json_encode(["message" => "quote_id Not Found"]);
}
