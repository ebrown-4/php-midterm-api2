<?php
// CORS headers — must be first
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Handle preflight (tester requires all methods allowed)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Simple root response for the tester
echo json_encode([
    "message" => "API root working",
    "endpoints" => [
        "/api/authors/read.php",
        "/api/authors/read_single.php?id=1",
        "/api/authors/create.php",
        "/api/authors/update.php",
        "/api/authors/delete.php",

        "/api/categories/read.php",
        "/api/categories/read_single.php?id=1",
        "/api/categories/create.php",
        "/api/categories/update.php",
        "/api/categories/delete.php",

        "/api/quotes/read.php",
        "/api/quotes/read_single.php?id=1",
        "/api/quotes/create.php",
        "/api/quotes/update.php",
        "/api/quotes/delete.php"
    ]
]);
