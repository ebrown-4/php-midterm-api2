<?php
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$quote->id = isset($_GET['id']) ? $_GET['id'] : die(json_encode(["message" => "Missing Required Parameters"]));

$result = $quote->read_single();
$row = $result->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode([
        "id" => $row['id'],
        "quote" => $row['quote'],
        "author" => $row['author'],
        "category" => $row['category']
    ]);
} else {
    echo json_encode(["message" => "Quote Not Found"]);
}
