<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

include_once('../../config/Database.php');
include_once('../../models/Authors.php');

$database = new Database();
$db = $database->connect();

$authors = new Authors($db);

$data = json_decode(file_get_contents("php://input"));

// Required field check
if (!isset($data->author) || empty(trim($data->author))) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit;
}

$authors->author = $data->author;

// Create author
$result = $authors->create();

echo json_encode($result);
