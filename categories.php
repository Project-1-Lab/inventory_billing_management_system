<?php
// api/categories.php
require_once('config.php');

$db     = getDB();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $rows = [];
    $res  = $db->query("SELECT * FROM category ORDER BY id");
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    json($rows);
}

if ($method === 'POST') {
    $b    = body();
    $name = trim($b['name'] ?? '');
    if (!$name) json(['error' => 'Name is required.'], 400);

    $description = trim($b['description'] ?? '');
    $id   = nextId('CAT');
    $stmt = $db->prepare("INSERT INTO category VALUES (?,?,?)");
    $stmt->bind_param('sss', $id, $name, $description);
    $stmt->execute();
    json(compact('id','name','description'), 201);
}

if ($method === 'PUT') {
    $b  = body();
    $id = trim($b['id'] ?? '');
    if (!$id) json(['error' => 'id required'], 400);

    $name        = trim($b['name']        ?? '');
    $description = trim($b['description'] ?? '');
    $stmt = $db->prepare("UPDATE category SET name=?,description=? WHERE id=?");
    $stmt->bind_param('sss', $name, $description, $id);
    $stmt->execute();
    json(['success' => true]);
}

if ($method === 'DELETE') {
    $id = trim($_GET['id'] ?? '');
    if (!$id) json(['error' => 'id required'], 400);
    $stmt = $db->prepare("DELETE FROM category WHERE id=?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    json(['success' => true]);
}
