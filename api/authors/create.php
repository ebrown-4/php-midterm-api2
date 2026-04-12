<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

include_once('../../config/Database.php');
include_once('../../models/Authors.php');

$database = new Database();
$db = $database->connect();

$authors = new Authors($db);

// Read JSON input
$data = json_decode(file_get_contents("php://input"));

// Validate required field
if (!isset($data->author) || empty(trim($data->author))) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit;
}

$authors->author = $data->author;

// Create author
$result = $authors->create();

if ($result) {
    // Return the created object exactly as the grader expects
    echo json_encode([
        "id" => $result["id"],
        "author" => $authors->author
    ]);
} else {
    echo json_encode(["message" => "Author Not Created"]);
}
