<?php
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $author->id = $data->id;

    if ($author->delete()) {
        echo json_encode(["message" => "Author was deleted successfully"]);
    } else {
        echo json_encode(["message" => "Author Not Deleted"]);
    }
} else {
    echo json_encode(["message" => "Missing Required Parameters"]);
}
