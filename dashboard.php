<?php
// api/dashboard.php
require_once('config.php');

$db = getDB();

$stats = [];

$row = $db->query("SELECT COUNT(*) AS cnt FROM product")->fetch_assoc();
$stats['product_count'] = (int)$row['cnt'];

$row = $db->query("SELECT COALESCE(SUM(stock_quantity),0) AS total FROM product")->fetch_assoc();
$stats['total_stock'] = (int)$row['total'];

$row = $db->query("SELECT COALESCE(SUM(stock_quantity * purchase_price),0) AS val FROM product")->fetch_assoc();
$stats['stock_value'] = (float)$row['val'];

$row = $db->query("SELECT COALESCE(SUM(total),0) AS rev FROM sale")->fetch_assoc();
$stats['sales_revenue'] = (float)$row['rev'];

// recent sales (last 6)
$sales = [];
$res = $db->query("SELECT * FROM sale ORDER BY date DESC, id DESC LIMIT 6");
while ($r = $res->fetch_assoc()) {
    $r['total'] = (float)$r['total'];
    $r['VAT']   = (float)$r['vat'];
    $sales[]    = $r;
}
$stats['recent_sales'] = $sales;

// recent purchases (last 4)
$purchases = [];
$res = $db->query("SELECT * FROM purchase ORDER BY date DESC, id DESC LIMIT 4");
while ($r = $res->fetch_assoc()) {
    $r['total'] = (float)$r['total'];
    $r['VAT']   = (float)$r['vat'];
    $purchases[] = $r;
}
$stats['recent_purchases'] = $purchases;

// low stock (below 10)
$low = [];
$res = $db->query("SELECT id,name,stock_quantity,unit FROM product WHERE stock_quantity < 10 ORDER BY stock_quantity ASC");
while ($r = $res->fetch_assoc()) {
    $r['stock_quantity'] = (int)$r['stock_quantity'];
    $low[] = $r;
}
$stats['low_stock'] = $low;

json($stats);