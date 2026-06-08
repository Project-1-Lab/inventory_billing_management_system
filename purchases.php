<?php
// api/purchases.php
require_once('config.php');

$db     = getDB();
$method = $_SERVER['REQUEST_METHOD'];

// GET — list purchases (with items if ?id=X)
if ($method === 'GET') {
    if (!empty($_GET['id'])) {
        $pid  = $db->real_escape_string($_GET['id']);
        $pur  = $db->query("SELECT * FROM purchase WHERE id='$pid'")->fetch_assoc();
        if (!$pur) json(['error' => 'Not found'], 404);
        $pur['subtotal']        = (float)$pur['subtotal'];
        $pur['discount_amount'] = (float)$pur['discount_amount'];
        $pur['shipping_charge'] = (float)$pur['shipping_charge'];
        $pur['vat']             = (float)$pur['vat'];
        $pur['total']           = (float)$pur['total'];

        $items = [];
        $res   = $db->query("SELECT * FROM purchase_item WHERE purchase_id='$pid'");
        while ($r = $res->fetch_assoc()) {
            $r['quantity'] = (int)$r['quantity'];
            $r['price']    = (float)$r['price'];
            $r['total']    = (float)$r['total'];
            $items[]       = $r;
        }
        $pur['items'] = $items;
        json($pur);
    }

    $rows = [];
    $res  = $db->query("SELECT * FROM purchase ORDER BY date DESC, id DESC");
    while ($r = $res->fetch_assoc()) {
        $r['subtotal']        = (float)$r['subtotal'];
        $r['discount_amount'] = (float)$r['discount_amount'];
        $r['shipping_charge'] = (float)$r['shipping_charge'];
        $r['vat']             = (float)$r['vat'];
        $r['total']           = (float)$r['total'];
        // rename vat → VAT for frontend compatibility
        $r['VAT'] = $r['vat'];
        $rows[] = $r;
    }
    json($rows);
}

// POST — create purchase + items + update stock + log inventory
if ($method === 'POST') {
    $b     = body();
    $items = $b['items'] ?? [];
    if (empty($items)) json(['error' => 'No items provided.'], 400);

    $supplier_id     = trim($b['supplier_id']     ?? '');
    $admin_id        = trim($b['admin_id']         ?? '');
    $date            = trim($b['date']             ?? '');
    $subtotal        = (float)($b['subtotal']        ?? 0);
    $discount_type   = trim($b['discount_type']    ?? 'fixed');
    $discount_amount = (float)($b['discount_amount'] ?? 0);
    $shipping_charge = (float)($b['shipping_charge'] ?? 0);
    $vat             = (float)($b['vat']             ?? 0);
    $total           = (float)($b['total']           ?? 0);

    if (!$supplier_id || !$admin_id || !$date) json(['error' => 'supplier_id, admin_id and date required.'], 400);

    $db->begin_transaction();
    try {
        $pid  = nextId('PUR');
        $stmt = $db->prepare("INSERT INTO purchase (id,supplier_id,admin_id,date,subtotal,discount_type,discount_amount,shipping_charge,vat,total) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssdsdddd', $pid, $supplier_id, $admin_id, $date, $subtotal, $discount_type, $discount_amount, $shipping_charge, $vat, $total);
        $stmt->execute();

      foreach ($items as $it) {
    $prod_id  = trim($it['product_id'] ?? '');
    $qty      = (int)($it['quantity']  ?? 0);
    $price    = (float)($it['price']   ?? 0);
    $line     = (float)($it['total']   ?? $qty * $price);
    $unit     = trim($it['unit']       ?? 'pcs');

    // insert purchase_item
    $stmt2 = $db->prepare("INSERT INTO purchase_item (purchase_id,product_id,quantity,unit,price,total) VALUES (?,?,?,?,?,?)");
    $stmt2->bind_param('ssissd', $pid, $prod_id, $qty, $unit, $price, $line);
    $stmt2->execute();

    // update stock + purchase_price
    $stmt3 = $db->prepare("UPDATE product SET stock_quantity = stock_quantity + ?, purchase_price = ? WHERE id = ?");
    $stmt3->bind_param('ids', $qty, $price, $prod_id);
    $stmt3->execute();

    // ✅ NEW: update product unit
    $stmtUnit = $db->prepare("UPDATE product SET unit = ? WHERE id = ?");
    $stmtUnit->bind_param('ss', $unit, $prod_id);
    $stmtUnit->execute();

    // inventory log
    $stmt4 = $db->prepare("INSERT INTO inventory (product_id,quantity_in,quantity_out,last_updated) VALUES (?,?,0,?)");
    $stmt4->bind_param('sis', $prod_id, $qty, $date);
    $stmt4->execute();
}

        $db->commit();
        json(['id' => $pid, 'success' => true], 201);
    } catch (Exception $e) {
        $db->rollback();
        json(['error' => $e->getMessage()], 500);
    }
}
