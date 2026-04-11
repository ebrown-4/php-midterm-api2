<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Quote.php');

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

$quote->read_single();

if ($quote->quote) {
    echo json_encode([
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author' => $quote->author,
        'category' => $quote->category
    ]);
} else {
    echo json_encode(['message' => 'Quote Not Found']);
}
