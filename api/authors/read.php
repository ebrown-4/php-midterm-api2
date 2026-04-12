<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Authors.php');

$database = new Database();
$db = $database->connect();

$authors = new Authors($db);

// GET parameter
$id = $_GET['id'] ?? null;

// Call model
$result = $authors->read($id);

//  If ID is provided → return ONE object or error message
if ($id !== null) {
    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(["message" => "author_id Not Found"]);
    }
    exit;
}

//   Otherwise return full list
$rows = $result->fetchAll(PDO::FETCH_ASSOC);

if (count($rows) > 0) {
    echo json_encode($rows);
} else {
    echo json_encode(["message" => "author_id Not Found"]);
}
