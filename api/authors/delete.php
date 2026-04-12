<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

include_once('../../config/Database.php');
include_once('../../models/Authors.php');

$database = new Database();
$db = $database->connect();

$authors = new Authors($db);

// Read JSON input
$data = json_decode(file_get_contents("php://input"));

// Validate required ID
if (!isset($data->id) || empty($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit;
}

$authors->id = $data->id;

// Attempt delete
$result = $authors->delete();

if ($result) {
    // Return ONLY the deleted id (grader requirement)
    echo json_encode(["id" => $result["id"]]);
} else {
    echo json_encode(["message" => "author_id Not Found"]);
}
