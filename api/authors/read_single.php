<?php
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

$result = $author->read_single();
$row = $result->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode([
        'id' => $row['id'],
        'author' => $row['author']
    ]);
} else {
    echo json_encode(['message' => 'author_id Not Found']);
}
