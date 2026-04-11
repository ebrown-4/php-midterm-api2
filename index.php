<?php
// CORS headers — always first
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Simple root response
echo json_encode([
    "message" => "API root working",
    "endpoints" => [
        "/authors",
        "/authors/read_single?id=1",
        "/authors/create",
        "/authors/update",
        "/authors/delete",

        "/categories",
        "/categories/read_single?id=1",
        "/categories/create",
        "/categories/update",
        "/categories/delete",

        "/quotes",
        "/quotes/read_single?id=1",
        "/quotes/create",
        "/quotes/update",
        "/quotes/delete"
    ]
]);
