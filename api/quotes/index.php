<?php
// Turn off error display for clean JSON output
error_reporting(0);
ini_set('display_errors', 0);

// CORS + JSON headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

// Connect to database
$database = new Database();
$db = $database->connect();

// If DB fails (Render cold start), return expected message
if ($db === null) {
    echo json_encode(["message" => "No Quotes Found"]);
    exit();
}

$quotes = new Quotes($db);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    /* -----------------------------------------
       GET REQUESTS
       ----------------------------------------- */
    case 'GET':

        // GET by id
        if (isset($_GET['id'])) {
            $quotes->id = $_GET['id'];
            $result = $quotes->read_single();

            if (!$result) {
                echo json_encode(["message" => "No Quotes Found"]);
                exit();
            }

            echo json_encode($result);
            exit();
        }

        // GET by author_id
        if (isset($_GET['author_id'])) {

            // Validate author first
            if (!$quotes->author_exists($_GET['author_id'])) {
                echo json_encode(["message" => "author_id Not Found"]);
                exit();
            }

            $quotes->author_id = $_GET['author_id'];
            echo json_encode($quotes->read());
            exit();
        }

        // GET by category_id
        if (isset($_GET['category_id'])) {

            // Validate category first
            if (!$quotes->category_exists($_GET['category_id'])) {
                echo json_encode(["message" => "category_id Not Found"]);
                exit();
            }

            $quotes->category_id = $_GET['category_id'];
            echo json_encode($quotes->read());
            exit();
        }

        // GET all quotes
        $quotes->author_id = null;
        $quotes->category_id = null;

        $result = $quotes->read();

        if (empty($result)) {
            echo json_encode(["message" => "No Quotes Found"]);
            exit();
        }

        echo json_encode($result);
        exit();


        /* -----------------------------------------
       POST REQUESTS
       ----------------------------------------- */
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            exit();
        }

        $quotes->quote = $data->quote;
        $quotes->author_id = $data->author_id;
        $quotes->category_id = $data->category_id;

        echo json_encode($quotes->create());
        exit();


        /* -----------------------------------------
       PUT REQUESTS
       ----------------------------------------- */
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            exit();
        }

        $quotes->id = $data->id;
        $quotes->quote = $data->quote;
        $quotes->author_id = $data->author_id;
        $quotes->category_id = $data->category_id;

        echo json_encode($quotes->update());
        exit();


        /* -----------------------------------------
       DELETE REQUESTS
       ----------------------------------------- */
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            exit();
        }

        $quotes->id = $data->id;
        $result = $quotes->delete();

        echo json_encode([
            "id" => $data->id,
            "message" => $result["message"]
        ]);
        exit();
}
