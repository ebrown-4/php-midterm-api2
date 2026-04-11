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
        "/api/authors",
        "/api/authors/read_single.php?id=1",
        "/api/authors/create.php",
        "/api/authors/update.php",
        "/api/authors/delete.php",

        "/api/categories",
        "/api/categories/read_single.php?id=1",
        "/api/categories/create.php",
        "/api/categories/update.php",
        "/api/categories/delete.php",

        "/api/quotes",
        "/api/quotes/read_single.php?id=1",
        "/api/quotes/create.php",
        "/api/quotes/update.php",
        "/api/quotes/delete.php"
    ]
]);
