<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

$database = new Database();
$db = $database->connect();
$quotes = new Quotes($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // -------------------------
    // GET REQUESTS
    // -------------------------
    case 'GET':

        // GET /api/quotes/?id=10
        if (isset($_GET['id'])) {
            $quotes->id = $_GET['id'];
            $result = $quotes->read_single();

            if (!$result) {
                echo json_encode(["message" => "No Quotes Found"]);
            } else {
                echo json_encode($result);
            }
            break;
        }

        // GET /api/quotes/?author_id=5 or category_id=4
        if (isset($_GET['author_id'])) {
            $quotes->author_id = $_GET['author_id'];
        }
        if (isset($_GET['category_id'])) {
            $quotes->category_id = $_GET['category_id'];
        }

        $result = $quotes->read();

        if (empty($result)) {
            echo json_encode(["message" => "No Quotes Found"]);
        } else {
            echo json_encode($result);
        }
        break;


    // -------------------------
    // POST REQUESTS
    // -------------------------
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            break;
        }

        $quotes->quote = $data->quote;
        $quotes->author_id = $data->author_id;
        $quotes->category_id = $data->category_id;

        echo json_encode($quotes->create());
        break;


    // -------------------------
    // PUT REQUESTS
    // -------------------------
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            break;
        }

        $quotes->id = $data->id;
        $quotes->quote = $data->quote;
        $quotes->author_id = $data->author_id;
        $quotes->category_id = $data->category_id;

        echo json_encode($quotes->update());
        break;


    // -------------------------
    // DELETE REQUESTS
    // -------------------------
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            break;
        }

        $quotes->id = $data->id;
        echo json_encode($quotes->delete());
        break;
}
