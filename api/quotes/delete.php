<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE, OPTIONS');
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

$data = json_decode(file_get_contents("php://input"));

// Required field check
if (!isset($data->id) || empty($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$quotes->id = $data->id;

// Delete quote
$result = $quotes->delete();

// Tester requires: { "id": X, "message": "Quote Deleted" }
echo json_encode([
    "id" => $data->id,
    "message" => $result["message"]
]);
