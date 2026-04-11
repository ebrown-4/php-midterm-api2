<?php
// CORS HEADERS — MUST BE FIRST
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

if ($method !== 'DELETE') {
    echo json_encode(["message" => "Invalid Request Method"]);
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

// Read JSON body
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $quote->id = $data->id;

    if ($quote->delete()) {
        // REQUIRED BY RUBRIC: return deleted id
        echo json_encode(["id" => $quote->id]);
    } else {
        echo json_encode(["message" => "No Quotes Found"]);
    }
} else {
    echo json_encode(["message" => "Missing Required Parameters"]);
}
