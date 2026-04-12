<?php
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);
$result = $quote->read();
$num = $result->rowCount();

if ($num > 0) {
    $quotes_arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $quotes_arr[] = [
            'id' => $row['id'],
            'quote' => $row['quote'],
            'author' => $row['author'],
            'category' => $row['category']
        ];
    }

    echo json_encode($quotes_arr);
} else {
    echo json_encode(['message' => 'No Quotes Found']);
}
