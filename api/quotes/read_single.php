<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Quotes.php');

$database = new Database();
$db = $database->connect();

$quote = new Quotes($db);

$quote->id = isset($_GET['id']) ? $_GET['id'] : die(json_encode(['message' => 'Missing ID']));

$row = $quote->read_single();

if ($row) {
    echo json_encode([
        'id' => $row['id'],
        'quote' => $row['quote'],
        'author' => $row['author'],
        'category' => $row['category']
    ]);
} else {
    echo json_encode(['message' => 'Quote Not Found']);
}
