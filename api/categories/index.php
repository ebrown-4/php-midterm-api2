<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

$database = new Database();
$db = $database->connect();
$categories = new Categories($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':
        if (isset($_GET['id'])) {
            $categories->id = $_GET['id'];
            $result = $categories->read_single();

            if (!$result) {
                echo json_encode(["message" => "category_id Not Found"]);
                exit();
            }

            echo json_encode($result);
            exit();
        }

        $result = $categories->read();

        if (empty($result)) {
            echo json_encode(["message" => "No Categories Found"]);
            exit();
        }

        echo json_encode($result);
        exit();


    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->category) || empty(trim($data->category))) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            exit();
        }

        $categories->category = $data->category;

        echo json_encode($categories->create());
        exit();


    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id) || !isset($data->category)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            exit();
        }

        $categories->id = $data->id;
        $categories->category = $data->category;

        echo json_encode($categories->update());
        exit();


    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            exit();
        }

        $categories->id = $data->id;

        $result = $categories->delete();

        echo json_encode([
            "id" => $data->id,
            "message" => $result["message"]
        ]);
        exit();
}
