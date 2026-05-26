<?php
// api/products.php
require_once('config.php');

$db     = getDB();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $rows = [];
    $res  = $db->query("SELECT * FROM product ORDER BY id");
    while ($r = $res->fetch_assoc()) {
        $r['purchase_price'] = (float)$r['purchase_price'];
        $r['selling_price']  = (float)$r['selling_price'];
        $r['stock_quantity'] = (int)$r['stock_quantity'];
        $rows[] = $r;
    }
    json($rows);
}

if ($method === 'POST') {
    $b    = body();
    $name = trim($b['name'] ?? '');
    $cat  = trim($b['category_id'] ?? '');
    if (!$name || !$cat) json(['error' => 'Name and category are required.'], 400);

    $description    = trim($b['description']    ?? '');
    $unit           = trim($b['unit']           ?? 'pcs');
    $purchase_price = (float)($b['purchase_price'] ?? 0);
    $selling_price  = (float)($b['selling_price']  ?? 0);
    $stock_quantity = (int)($b['stock_quantity']    ?? 0);

    $id   = nextId('P');
    $stmt = $db->prepare("INSERT INTO product VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param('ssssddis', $id, $name, $description, $cat, $unit, $purchase_price, $selling_price, $stock_quantity);
    $stmt->execute();
    json(['id'=>$id,'name'=>$name,'description'=>$description,'category_id'=>$cat,
          'unit'=>$unit,'purchase_price'=>$purchase_price,'selling_price'=>$selling_price,
          'stock_quantity'=>$stock_quantity], 201);
}

if ($method === 'PUT') {
    $b  = body();
    $id = trim($b['id'] ?? '');
    if (!$id) json(['error' => 'id required'], 400);

    $name           = trim($b['name']        ?? '');
    $description    = trim($b['description'] ?? '');
    $category_id    = trim($b['category_id'] ?? '');
    $unit           = trim($b['unit']        ?? 'pcs');
    $purchase_price = (float)($b['purchase_price'] ?? 0);
    $selling_price  = (float)($b['selling_price']  ?? 0);
    $stock_quantity = (int)($b['stock_quantity']    ?? 0);

    $stmt = $db->prepare("UPDATE product SET name=?,description=?,category_id=?,unit=?,purchase_price=?,selling_price=?,stock_quantity=? WHERE id=?");
    $stmt->bind_param('ssssddis', $name, $description, $category_id, $unit, $purchase_price, $selling_price, $stock_quantity, $id);
    $stmt->execute();
    json(['success' => true]);
}

if ($method === 'DELETE') {
    $id = trim($_GET['id'] ?? '');
    if (!$id) json(['error' => 'id required'], 400);
    $stmt = $db->prepare("DELETE FROM product WHERE id=?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    json(['success' => true]);
}