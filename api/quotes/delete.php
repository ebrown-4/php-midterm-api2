<?php
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $quote->id = $data->id;

    if ($quote->delete()) {
        echo json_encode(["message" => "Quote was deleted successfully"]);
    } else {
        echo json_encode(["message" => "Quote Not Deleted"]);
    }
} else {
    echo json_encode(["message" => "Missing Required Parameters"]);
}
