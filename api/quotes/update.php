<?php
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->quote) && !empty($data->author_id) && !empty($data->category_id)) {
    $quote->id = $data->id;
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    if ($quote->update()) {
        echo json_encode(["message" => "Quote was updated successfully"]);
    } else {
        echo json_encode(["message" => "Quote Not Updated"]);
    }
} else {
    echo json_encode(["message" => "Missing Required Parameters"]);
}
