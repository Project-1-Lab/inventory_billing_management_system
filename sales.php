<?php
// api/sales.php
require_once('config.php');

$db     = getDB();
$method = $_SERVER['REQUEST_METHOD'];

// GET — list sales (with items if ?id=X)
if ($method === 'GET') {
    if (!empty($_GET['id'])) {
        $sid  = $db->real_escape_string($_GET['id']);
        $sale = $db->query("SELECT * FROM sale WHERE id='$sid'")->fetch_assoc();
        if (!$sale) json(['error' => 'Not found'], 404);
        $sale['subtotal']        = (float)$sale['subtotal'];
        $sale['discount_amount'] = (float)$sale['discount_amount'];
        $sale['vat']             = (float)$sale['vat'];
        $sale['total']           = (float)$sale['total'];
        $sale['VAT']             = $sale['vat'];

        $items = [];
        $res   = $db->query("SELECT * FROM sale_item WHERE sale_id='$sid'");
        while ($r = $res->fetch_assoc()) {
            $r['quantity'] = (int)$r['quantity'];
            $r['price']    = (float)$r['price'];
            $r['total']    = (float)$r['total'];
            $items[]       = $r;
        }
        $sale['items'] = $items;
        json($sale);
    }

    $rows = [];
    $res  = $db->query("SELECT * FROM sale ORDER BY date DESC, id DESC");
    while ($r = $res->fetch_assoc()) {
        $r['subtotal']        = (float)$r['subtotal'];
        $r['discount_amount'] = (float)$r['discount_amount'];
        $r['vat']             = (float)$r['vat'];
        $r['total']           = (float)$r['total'];
        $r['VAT']             = $r['vat'];
        $rows[] = $r;
    }
    json($rows);
}

// POST — create sale + items + deduct stock + log inventory
if ($method === 'POST') {
    $b     = body();
    $items = $b['items'] ?? [];
    if (empty($items)) json(['error' => 'No items provided.'], 400);

    $customer_id     = trim($b['customer_id']     ?? '');
    $admin_id        = trim($b['admin_id']         ?? '');
    $date            = trim($b['date']             ?? '');
    $subtotal        = (float)($b['subtotal']        ?? 0);
    $discount_type   = trim($b['discount_type']    ?? 'fixed');
    $discount_amount = (float)($b['discount_amount'] ?? 0);
    $vat             = (float)($b['vat']             ?? 0);
    $total           = (float)($b['total']           ?? 0);

    if (!$customer_id || !$admin_id || !$date) json(['error' => 'customer_id, admin_id and date required.'], 400);

    // Stock check first
    foreach ($items as $it) {
        $prod_id = trim($it['product_id'] ?? '');
        $qty     = (int)($it['quantity']  ?? 0);
        $row     = $db->query("SELECT stock_quantity FROM product WHERE id='" . $db->real_escape_string($prod_id) . "'")->fetch_assoc();
        if (!$row || $row['stock_quantity'] < $qty) {
            json(['error' => "Insufficient stock for product $prod_id (available: " . ($row['stock_quantity'] ?? 0) . ")"], 400);
        }
    }

    $db->begin_transaction();
    try {
        $sid  = nextId('SALE');
        $stmt = $db->prepare("INSERT INTO sale (id,customer_id,admin_id,date,subtotal,discount_type,discount_amount,vat,total) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssdsddd', $sid, $customer_id, $admin_id, $date, $subtotal, $discount_type, $discount_amount, $vat, $total);
        $stmt->execute();

        foreach ($items as $it) {
            $prod_id = trim($it['product_id'] ?? '');
            $qty     = (int)($it['quantity']  ?? 0);
            $price   = (float)($it['price']   ?? 0);
            $line    = (float)($it['total']   ?? $qty * $price);

            $stmt2 = $db->prepare("INSERT INTO sale_item (sale_id,product_id,quantity,price,total) VALUES (?,?,?,?,?)");
            $stmt2->bind_param('ssidd', $sid, $prod_id, $qty, $price, $line);
            $stmt2->execute();

            // deduct stock
            $stmt3 = $db->prepare("UPDATE product SET stock_quantity = stock_quantity - ? WHERE id=?");
            $stmt3->bind_param('is', $qty, $prod_id);
            $stmt3->execute();

            // inventory log
            $stmt4 = $db->prepare("INSERT INTO inventory (product_id,quantity_in,quantity_out,last_updated) VALUES (?,0,?,?)");
            $stmt4->bind_param('sis', $prod_id, $qty, $date);
            $stmt4->execute();
        }

        $db->commit();
        json(['id' => $sid, 'success' => true], 201);
    } catch (Exception $e) {
        $db->rollback();
        json(['error' => $e->getMessage()], 500);
    }
}