<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

include_once('../../config/Database.php');
include_once('../../models/Quotes.php');

$database = new Database();
$db = $database->connect();

$quotes = new Quotes($db);

$data = json_decode(file_get_contents("php://input"));

// Required field check
if (!isset($data->id) || empty($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit;
}

$quotes->id = $data->id;

// Attempt delete
$result = $quotes->delete();

if ($result) {
    echo json_encode(["id" => $result["id"]]);
} else {
    echo json_encode(["message" => "quote_id Not Found"]);
}
