<?php
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

$database = new Database();
$db = $database->connect();

$quotes = new Quotes($db);
$result = $quotes->read();

$num = $result->rowCount();

if ($num > 0) {
    $quotes_arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $quotes_arr[] = [
            "id" => $row['id'],
            "quote" => $row['quote'],
            "author_id" => $row['author_id'],
            "category_id" => $row['category_id']
        ];
    }

    echo json_encode($quotes_arr);
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}
