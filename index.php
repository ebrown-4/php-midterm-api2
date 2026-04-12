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

// DO NOT OUTPUT ANYTHING HERE
// The tester will break if this file prints JSON

echo json_encode(["message" => "API root working"]);
