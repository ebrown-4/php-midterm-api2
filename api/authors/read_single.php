<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Authors.php');

$database = new Database();
$db = $database->connect();

$authors = new Authors($db);

$authors->id = isset($_GET['id']) ? $_GET['id'] : die();

$result = $authors->read_single();
$row = $result->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode([
        "id" => $row['id'],
        "author" => $row['author']
    ]);
} else {
    echo json_encode(["message" => "author_id Not Found"]);
}
