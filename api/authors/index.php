<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Authors.php');

$database = new Database();
$db = $database->connect();

$author = new Authors($db);

$result = $author->read();
$num = $result->rowCount();

if ($num > 0) {
    $authors_arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $authors_arr[] = [
            'id' => $id,
            'author' => $author
        ];
    }

    echo json_encode($authors_arr);
} else {
    echo json_encode(['message' => 'No Authors Found']);
}
