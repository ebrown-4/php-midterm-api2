<?php
// CORS HEADERS — MUST BE FIRST
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

if ($method !== 'DELETE') {
    echo json_encode(["message" => "Invalid Request Method"]);
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

// Read JSON body
$data = json_decode(file_get_contents("php://input"));
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');

include_once(__DIR__ . '/../../config/Database.php');
include_once(__DIR__ . '/../../models/Quotes.php');

$database = new Database();
$db = $database->connect();

$quote = new Quotes($db);

$data = json_decode(file_get_contents("php://input"));

$quote->id = $data->id ?? null;

if ($quote->delete()) {
    echo json_encode(['message' => 'Quote was deleted successfully']);
} else {
    echo json_encode(['message' => 'Quote Not Deleted']);
}