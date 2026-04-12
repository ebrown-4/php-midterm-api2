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

    case 'GET':
        if (isset($_GET['id'])) {
            $authors->id = $_GET['id'];
            $result = $authors->read_single();

            if (!$result) {
                echo json_encode(["message" => "author_id Not Found"]);
                exit();
            }

            echo json_encode($result);
            exit();
        }

        $result = $authors->read();

        if (empty($result)) {
            echo json_encode(["message" => "No Authors Found"]);
            exit();
        }

        echo json_encode($result);
        exit();


    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->author) || empty(trim($data->author))) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            exit();
        }

        $authors->author = $data->author;

        echo json_encode($authors->create());
        exit();


    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id) || !isset($data->author)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            exit();
        }

        $authors->id = $data->id;
        $authors->author = $data->author;

        echo json_encode($authors->update());
        exit();


    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            exit();
        }

        $authors->id = $data->id;

        $result = $authors->delete();

        echo json_encode([
            "id" => $data->id,
            "message" => $result["message"]
        ]);
        exit();
}
