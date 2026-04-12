<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Authors.php';

$database = new Database();
$db = $database->connect();
$authors = new Authors($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // -------------------------
    // GET REQUESTS
    // -------------------------
    case 'GET':

        // GET /api/authors/?id=5
        if (isset($_GET['id'])) {
            $authors->id = $_GET['id'];
            $result = $authors->read_single();

            if (!$result) {
                echo json_encode(["message" => "Author Not Found"]);
            } else {
                echo json_encode($result);
            }
            break;
        }

        // GET /api/authors/
        $result = $authors->read();

        if (empty($result)) {
            echo json_encode(["message" => "No Authors Found"]);
        } else {
            echo json_encode($result);
        }
        break;


    // -------------------------
    // POST REQUESTS
    // -------------------------
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->author) || empty(trim($data->author))) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            break;
        }

        $authors->author = $data->author;

        echo json_encode($authors->create());
        break;


    // -------------------------
    // PUT REQUESTS
    // -------------------------
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id) || !isset($data->author)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            break;
        }

        $authors->id = $data->id;
        $authors->author = $data->author;

        echo json_encode($authors->update());
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

        $authors->id = $data->id;

        echo json_encode($authors->delete());
        break;
}
