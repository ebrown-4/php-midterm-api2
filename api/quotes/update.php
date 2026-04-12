<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

include_once('../../config/Database.php');
include_once('../../models/Quotes.php');

$database = new Database();
$db = $database->connect();

$quotes = new Quotes($db);

$data = json_decode(file_get_contents("php://input"));

// Required fields check
if (
    !isset($data->id) ||
    !isset($data->quote) ||
    !isset($data->author_id) ||
    !isset($data->category_id) ||
    empty(trim($data->quote))
) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit;
}

$quotes->id = $data->id;
$quotes->quote = $data->quote;
$quotes->author_id = $data->author_id;
$quotes->category_id = $data->category_id;

// Attempt update
$result = $quotes->update();

if ($result) {
    echo json_encode([
        "id" => $result["id"],
        "quote" => $quotes->quote,
        "author_id" => $quotes->author_id,
        "category_id" => $quotes->category_id
    ]);
} else {
    echo json_encode(["message" => "quote_id Not Found"]);
}
