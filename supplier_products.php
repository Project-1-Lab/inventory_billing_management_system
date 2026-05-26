<?php
// api/supplier_products.php
require_once('config.php');

$db     = getDB();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $rows = [];
    $res  = $db->query("SELECT * FROM supplier_product ORDER BY supplier_id, product_id");
    while ($r = $res->fetch_assoc()) {
        $r['cost_price'] = (float)$r['cost_price'];
        $rows[] = $r;
    }
    json($rows);
}

if ($method === 'POST') {
    $b          = body();
    $supplier_id = trim($b['supplier_id'] ?? '');
    $product_id  = trim($b['product_id']  ?? '');
    $cost_price  = (float)($b['cost_price'] ?? 0);
    if (!$supplier_id || !$product_id) json(['error' => 'supplier_id and product_id required.'], 400);
    if ($cost_price <= 0) json(['error' => 'cost_price must be > 0.'], 400);

    // check duplicate
    $stmt = $db->prepare("SELECT 1 FROM supplier_product WHERE supplier_id=? AND product_id=?");
    $stmt->bind_param('ss', $supplier_id, $product_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) json(['error' => 'Link already exists.'], 409);

    $stmt = $db->prepare("INSERT INTO supplier_product VALUES (?,?,?)");
    $stmt->bind_param('ssd', $supplier_id, $product_id, $cost_price);
    $stmt->execute();
    json(compact('supplier_id','product_id','cost_price'), 201);
}

if ($method === 'PUT') {
    $b          = body();
    $supplier_id = trim($b['supplier_id'] ?? '');
    $product_id  = trim($b['product_id']  ?? '');
    $cost_price  = (float)($b['cost_price'] ?? 0);
    if (!$supplier_id || !$product_id) json(['error' => 'supplier_id and product_id required.'], 400);
    if ($cost_price <= 0) json(['error' => 'cost_price must be > 0.'], 400);

    $stmt = $db->prepare("UPDATE supplier_product SET cost_price=? WHERE supplier_id=? AND product_id=?");
    $stmt->bind_param('dss', $cost_price, $supplier_id, $product_id);
    $stmt->execute();
    json(['success' => true]);
}

if ($method === 'DELETE') {
    $sid = trim($_GET['supplier_id'] ?? '');
    $pid = trim($_GET['product_id']  ?? '');
    if (!$sid || !$pid) json(['error' => 'supplier_id and product_id required'], 400);
    $stmt = $db->prepare("DELETE FROM supplier_product WHERE supplier_id=? AND product_id=?");
    $stmt->bind_param('ss', $sid, $pid);
    $stmt->execute();
    json(['success' => true]);
}