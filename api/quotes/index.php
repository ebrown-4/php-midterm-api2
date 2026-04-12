<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Quotes.php');

$database = new Database();
$db = $database->connect();

$quotes = new Quotes($db);

// If ID is provided, return a single quote
if (isset($_GET['id'])) {
    $quotes->id = $_GET['id'];

    $result = $quotes->read_single();
    $row = $result->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo json_encode([
            "id" => $row['id'],
            "quote" => $row['quote'],
            "author" => $row['author'],
            "category" => $row['category']
        ]);
    } else {
        echo json_encode(["message" => "quote_id Not Found"]);
    }

    exit;
}

// Otherwise return all quotes
$result = $quotes->read();
$num = $result->rowCount();

if ($num > 0) {
    $quotes_arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $quotes_arr[] = [
            "id" => $row['id'],
            "quote" => $row['quote'],
            "author" => $row['author'],
            "category" => $row['category']
        ];
    }

    echo json_encode($quotes_arr);
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}
