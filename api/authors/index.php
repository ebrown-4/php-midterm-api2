<?php
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Authors.php';

$database = new Database();
$db = $database->connect();

$authors = new Authors($db);
$result = $authors->read();

$num = $result->rowCount();

if ($num > 0) {
    $authors_arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $authors_arr[] = [
            'id' => $row['id'],
            'author' => $row['author']
        ];
    }

    echo json_encode($authors_arr);
} else {
    echo json_encode(["message" => "No Authors Found"]);
}
