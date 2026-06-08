<?php
// api/admins.php
require_once('config.php');

$db     = getDB();
$method = $_SERVER['REQUEST_METHOD'];

// GET — list all
if ($method === 'GET') {
    $rows = [];
    $res  = $db->query("SELECT * FROM admin ORDER BY id");
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    json($rows);
}

// POST — create
if ($method === 'POST') {
    $b = body();
    $name  = trim($b['name']  ?? '');
    $email = trim($b['email'] ?? '');
    $phone = trim($b['phone'] ?? '');
    if (!$name || !$email) json(['error' => 'Name and email are required.'], 400);

    $id = nextId('ADM');
    $stmt = $db->prepare("INSERT INTO admin VALUES (?,?,?,?)");
    $stmt->bind_param('ssss', $id, $name, $email, $phone);
    $stmt->execute();
    json(['id' => $id, 'name' => $name, 'email' => $email, 'phone' => $phone], 201);
}

// PUT — update
if ($method === 'PUT') {
    $b = body();
    $id    = trim($b['id']    ?? '');
    $name  = trim($b['name']  ?? '');
    $email = trim($b['email'] ?? '');
    $phone = trim($b['phone'] ?? '');
    if (!$id || !$name || !$email) json(['error' => 'id, name and email are required.'], 400);

    $stmt = $db->prepare("UPDATE admin SET name=?, email=?, phone=? WHERE id=?");
    $stmt->bind_param('ssss', $name, $email, $phone, $id);
    $stmt->execute();
    json(['success' => true]);
}

// DELETE — remove
if ($method === 'DELETE') {
    $id = trim($_GET['id'] ?? '');
    if (!$id) json(['error' => 'id required'], 400);
    $stmt = $db->prepare("DELETE FROM admin WHERE id=?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    json(['success' => true]);
}
