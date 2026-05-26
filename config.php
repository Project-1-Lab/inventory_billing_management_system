<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// ============================================================
//  config.php  —  Database connection + shared helpers
// ============================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // default XAMPP user
define('DB_PASS', '');           // default XAMPP password (empty)
define('DB_NAME', 'stockflow');

function getDB(): mysqli {
    static $conn = null;
    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            http_response_code(500);
            die(json_encode(['error' => 'DB connection failed: ' . $conn->connect_error]));
        }
        $conn->set_charset('utf8mb4');
    }
    return $conn;
}

// Generate the next ID for a given prefix  e.g. "P" → "P6"
function nextId(string $prefix): string {
    $db  = getDB();
    $p   = $db->real_escape_string($prefix);
    $db->query("UPDATE id_sequence SET nextval = nextval + 1 WHERE prefix = '$p'");
    $row = $db->query("SELECT nextval FROM id_sequence WHERE prefix = '$p'")->fetch_assoc();
    return $prefix . $row['nextval'];
}

// Send a JSON response and exit
function json(mixed $data, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Read the raw JSON request body as an associative array
function body(): array {
    return json_decode(file_get_contents('php://input'), true) ?? [];
}

// CORS + JSON headers for every API response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }