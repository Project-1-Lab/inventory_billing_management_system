<?php
// api/inventory.php
require_once('config.php');

$db = getDB();

// GET only — inventory is written automatically by purchase/sale APIs
$rows = [];
$res  = $db->query("SELECT * FROM inventory ORDER BY id DESC LIMIT 50");
while ($r = $res->fetch_assoc()) {
    $r['quantity_in']  = (int)$r['quantity_in'];
    $r['quantity_out'] = (int)$r['quantity_out'];
    $rows[] = $r;
}
json($rows);