<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

include_once('../../config/Database.php');
include_once('../../models/Authors.php');

$database = new Database();
$db = $database->connect();

$authors = new Authors($db);

$data = json_decode(file_get_contents("php://input"));

// Required fields check
if (!isset($data->id) || !isset($data->author) || empty(trim($data->author))) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit;
}

$authors->id = $data->id;
$authors->author = $data->author;

// Attempt update
$result = $authors->update();

if ($result) {
    echo json_encode([
        "id" => $result["id"],
        "author" => $authors->author
    ]);
} else {
    echo json_encode(["message" => "author_id Not Found"]);
}
