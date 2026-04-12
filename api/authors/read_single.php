<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, OPTIONS');
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

// Require ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit;
}

$authors->id = $_GET['id'];

// Get single author
$result = $authors->read_single();

if ($result) {
    echo json_encode($result);
} else {
    echo json_encode(["message" => "Author Not Found"]);
}
