<?php
// CORS HEADERS — MUST BE FIRST
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// DATABASE + MODEL
include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

$database = new Database();
$db = $database->connect();

$quotes = new Quotes($db);

// ONLY HANDLE GET HERE (your project uses GET for reading)
if ($method === 'GET') {

    // Read query parameters
    $author_id   = isset($_GET['author_id']) ? intval($_GET['author_id']) : null;
    $category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;
    $random      = isset($_GET['random']) && $_GET['random'] === 'true';

    // Fetch results
    $result = $quotes->read($author_id, $category_id, $random);
    $num = $result->rowCount();

    if ($num > 0) {
        $quotes_arr = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $quotes_arr[] = [
                'id'       => $row['id'],
                'quote'    => $row['quote'],
                'author'   => $row['author'],
                'category' => $row['category']
            ];
        }

        echo json_encode($quotes_arr);
    } else {
        echo json_encode(["message" => "No Quotes Found"]);
    }

    exit();
}

// If method is not GET
echo json_encode(["message" => "Invalid Request Method"]);
