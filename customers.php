<?php
// api/customers.php
require_once('config.php');

$db     = getDB();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $rows = [];
    $res  = $db->query("SELECT * FROM customer ORDER BY id");
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    json($rows);
}

if ($method === 'POST') {
    $b    = body();
    $name = trim($b['name'] ?? '');
    if (!$name) json(['error' => 'Name is required.'], 400);

    $phone     = trim($b['phone']     ?? '');
    $phone_opt = trim($b['phone_opt'] ?? '');
    $email     = trim($b['email']     ?? '');
    $address   = trim($b['address']   ?? '');

    $id   = nextId('C');
    $stmt = $db->prepare("INSERT INTO customer VALUES (?,?,?,?,?,?)");
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

    $stmt = $db->prepare("UPDATE customer SET name=?,phone=?,phone_opt=?,email=?,address=? WHERE id=?");
    $stmt->bind_param('ssssss', $name, $phone, $phone_opt, $email, $address, $id);
    $stmt->execute();
    json(['success' => true]);
}

if ($method === 'DELETE') {
    $id = trim($_GET['id'] ?? '');
    if (!$id) json(['error' => 'id required'], 400);
    
    try {
        $stmt = $db->prepare("DELETE FROM admin WHERE id=?");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        json(['success' => true]);
    } catch (mysqli_sql_exception $e) {
        if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
            json(['error' => 'Cannot delete this record because it is linked to sales or other transactions. Delete those first.'], 400);
        } else {
            json(['error' => $e->getMessage()], 500);
        }
    }
}