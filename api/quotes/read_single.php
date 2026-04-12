<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Quotes.php');

$database = new Database();
$db = $database->connect();

$quotes = new Quotes($db);

$quotes->id = isset($_GET['id']) ? $_GET['id'] : die();

$result = $quotes->read_single();
$row = $result->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode([
        "id" => $row['id'],
        "quote" => $row['quote'],
        "author" => $row['author'],
        "category" => $row['category']
    ]);
} else {
    echo json_encode(["message" => "No Quote Found"]);
}
