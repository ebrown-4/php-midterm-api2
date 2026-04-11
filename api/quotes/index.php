<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Quotes.php');

$database = new Database();
$db = $database->connect();

$quote = new Quotes($db);

$result = $quote->read();
$num = $result->rowCount();

if ($num > 0) {
    $quotes_arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $quotes_arr[] = [
            'id' => $id,
            'quote' => $quote,
            'author' => $author,
            'category' => $category
        ];
    }

    echo json_encode($quotes_arr);
} else {
    echo json_encode(['message' => 'No Quotes Found']);
}
