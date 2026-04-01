<?php
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

$database = new Database();
$db = $database->connect();

$quotes = new Quotes($db);

// Read query parameters
$author_id = isset($_GET['author_id']) ? intval($_GET['author_id']) : null;
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;
$random = isset($_GET['random']) && $_GET['random'] === 'true';

// Fetch results
$result = $quotes->read($author_id, $category_id, $random);
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
    echo json_encode(["message" => "No Quotes Found"]);
}
