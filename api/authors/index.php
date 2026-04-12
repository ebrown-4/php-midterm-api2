<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Authors.php');

$database = new Database();
$db = $database->connect();

$authors = new Authors($db);

// If ID is provided, return a single author
if (isset($_GET['id'])) {
    $authors->id = $_GET['id'];

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

    exit;
}

// Otherwise return all authors
$result = $authors->read();
$num = $result->rowCount();

if ($num > 0) {
    $authors_arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $authors_arr[] = [
            "id" => $row['id'],
            "author" => $row['author']
        ];
    }

    echo json_encode($authors_arr);
} else {
    echo json_encode(["message" => "No Authors Found"]);
}
