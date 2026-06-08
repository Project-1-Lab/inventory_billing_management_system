<?php
// api/suppliers.php
require_once('config.php');

$db     = getDB();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $rows = [];
    $res  = $db->query("SELECT * FROM supplier ORDER BY id");
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    json($rows);
}

if ($method === 'POST') {
    $b     = body();
    $name  = trim($b['name']  ?? '');
    $phone = trim($b['phone'] ?? '');
    if (!$name || !$phone) json(['error' => 'Name and phone are required.'], 400);

    $phone_opt = trim($b['phone_opt'] ?? '');
    $email     = trim($b['email']     ?? '');
    $address   = trim($b['address']   ?? '');

    $id   = nextId('SUP');
    $stmt = $db->prepare("INSERT INTO supplier VALUES (?,?,?,?,?,?)");
    $stmt->bind_param('ssssss', $id, $name, $phone, $phone_opt, $email, $address);
    $stmt->execute();
    json(compact('id','name','phone','phone_opt','email','address'), 201);
}

if ($method === 'PUT') {
    $b  = body();
    $id = trim($b['id'] ?? '');
    if (!$id) json(['error' => 'id required'], 400);

    $name      = trim($b['name']      ?? '');
    $phone     = trim($b['phone']     ?? '');
    $phone_opt = trim($b['phone_opt'] ?? '');
    $email     = trim($b['email']     ?? '');
    $address   = trim($b['address']   ?? '');

    $stmt = $db->prepare("UPDATE supplier SET name=?,phone=?,phone_opt=?,email=?,address=? WHERE id=?");
    $stmt->bind_param('ssssss', $name, $phone, $phone_opt, $email, $address, $id);
    $stmt->execute();
    json(['success' => true]);
}

if ($method === 'DELETE') {
    $id = trim($_GET['id'] ?? '');
    if (!$id) json(['error' => 'id required'], 400);
    $stmt = $db->prepare("DELETE FROM supplier WHERE id=?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    json(['success' => true]);
}
