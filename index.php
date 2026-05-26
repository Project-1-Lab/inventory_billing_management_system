<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>StockFlow — Inventory & Billing</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#f4f3ef;--surface:#ffffff;--surface2:#f9f8f5;
  --border:#e4e2db;--border2:#d0cec6;
  --text:#1a1916;--text2:#6b6860;--text3:#9c9a95;
  --accent:#2a52e0;--accent-bg:#eef1fd;--accent-text:#1a3abf;
  --green:#1a7a4a;--green-bg:#e8f5ee;
  --red:#c0392b;--red-bg:#fdecea;
  --amber:#a05c00;--amber-bg:#fef3e2;
  --radius:10px;--radius-lg:14px;
  --shadow:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);
  --shadow-md:0 4px 12px rgba(0,0,0,.08),0 2px 4px rgba(0,0,0,.04);
}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);font-size:14px;line-height:1.5}
.app{display:flex;height:100vh;overflow:hidden}
/* sidebar */
.sidebar{width:240px;flex-shrink:0;background:var(--surface);border-right:1px solid var(--border);display:flex;flex-direction:column;overflow-y:auto}
.sidebar-brand{padding:20px 18px 16px;border-bottom:1px solid var(--border)}
.sidebar-brand h1{font-size:17px;font-weight:600;letter-spacing:-.3px}
.sidebar-brand h1 span{color:var(--accent)}
.sidebar-brand p{font-size:11px;color:var(--text3);margin-top:2px;font-family:'DM Mono',monospace}
.sidebar-section{padding:12px 18px 4px;font-size:10px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:var(--text3)}
.nav-link{display:flex;align-items:center;gap:9px;padding:7px 10px;border-radius:var(--radius);margin:1px 8px;color:var(--text2);cursor:pointer;transition:all .15s;font-size:13.5px;font-weight:400;text-decoration:none}
.nav-link:hover{background:var(--surface2);color:var(--text)}
.nav-link.active{background:var(--accent-bg);color:var(--accent-text);font-weight:500}
.nav-link svg{flex-shrink:0;opacity:.7}.nav-link.active svg{opacity:1}
/* main */
.main{flex:1;overflow-y:auto;padding:28px 32px}
/* page header */
.page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px}
.page-header h2{font-size:20px;font-weight:600;letter-spacing:-.3px}
/* buttons */
.btn{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:500;cursor:pointer;border:none;transition:all .15s}
.btn-primary{background:var(--accent);color:#fff}.btn-primary:hover{background:#1e42cc}
.btn-success{background:var(--green);color:#fff}.btn-success:hover{background:#155f3a}
.btn-ghost{background:transparent;color:var(--text2);border:1px solid var(--border)}.btn-ghost:hover{background:var(--surface2)}
.btn-danger{background:var(--red-bg);color:var(--red);border:none}.btn-danger:hover{background:#f9d5d2}
.btn-sm{padding:4px 10px;font-size:12px}
.btn-link{background:none;border:none;color:var(--accent);cursor:pointer;font-family:'DM Sans',sans-serif;font-size:13px;padding:0;text-decoration:underline}
/* cards / tables */
.card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow)}
.card-header{padding:14px 18px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between}
.card-header h3{font-size:13.5px;font-weight:600;color:var(--text)}
table{width:100%;border-collapse:collapse}
th{padding:10px 14px;font-size:11.5px;font-weight:600;letter-spacing:.4px;text-transform:uppercase;color:var(--text3);background:var(--surface2);border-bottom:1px solid var(--border);text-align:left}
td{padding:10px 14px;border-bottom:1px solid var(--border);vertical-align:middle;font-size:13.5px}
tr:last-child td{border-bottom:none}
tbody tr:hover td{background:var(--surface2)}
.empty-row td{text-align:center;color:var(--text3);padding:32px;font-style:italic}
/* make long text wrap nicely */
td:has(.mono), td[class*="phone"] { word-break: break-word; }
td:has(a), td:has(span.badge) { word-break: normal; }
/* stat cards */
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:22px}
.stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-lg);padding:18px 20px;box-shadow:var(--shadow)}
.stat-card .label{font-size:11px;font-weight:600;letter-spacing:.5px;text-transform:uppercase;color:var(--text3);margin-bottom:6px}
.stat-card .value{font-size:26px;font-weight:600;letter-spacing:-1px;font-family:'DM Mono',monospace}
.stat-card.blue .value{color:var(--accent)}.stat-card.green .value{color:var(--green)}
.stat-card.amber .value{color:var(--amber)}.stat-card.red .value{color:var(--red)}
/* badges */
.badge{display:inline-flex;align-items:center;padding:3px 9px;border-radius:999px;font-size:11.5px;font-weight:500}
.badge-green{background:var(--green-bg);color:var(--green)}
.badge-red{background:var(--red-bg);color:var(--red)}
.badge-amber{background:var(--amber-bg);color:var(--amber)}
.badge-blue{background:var(--accent-bg);color:var(--accent-text)}
/* forms */
.form-group{margin-bottom:14px}
.form-group label{display:block;font-size:12px;font-weight:500;color:var(--text2);margin-bottom:5px}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:8px 11px;border:1px solid var(--border2);border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface);transition:border-color .15s}
.form-group input:focus,.form-group select:focus,.form-group textarea:focus{outline:none;border-color:var(--accent);box-shadow:0 0 0 3px rgba(42,82,224,.1)}
.form-row{display:grid;gap:12px}
.form-row.col2{grid-template-columns:1fr 1fr}
.form-row.col3{grid-template-columns:1fr 1fr 1fr}
/* modal */
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);display:flex;align-items:center;justify-content:center;z-index:1000;padding:20px}
.modal-box{background:var(--surface);border-radius:var(--radius-lg);box-shadow:var(--shadow-md);width:100%;max-height:90vh;overflow-y:auto;animation:mIn .18s ease}
@keyframes mIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
.modal-header{display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--border)}
.modal-header h3{font-size:16px;font-weight:600}
.modal-close{background:none;border:none;cursor:pointer;color:var(--text3);font-size:22px;line-height:1;padding:0 4px;border-radius:6px}.modal-close:hover{background:var(--surface2);color:var(--text)}
.modal-body{padding:20px 22px}
.modal-footer{padding:14px 22px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;gap:8px;background:var(--surface2)}
.cart-table th{background:var(--accent-bg)}
.cart-table tbody tr:hover td{background:#f5f7fe}
/* utils */
.mono{font-family:'DM Mono',monospace;font-size:12px}
.text-muted{color:var(--text3)}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.page-fade{animation:fade .2s ease}@keyframes fade{from{opacity:0}to{opacity:1}}
.total-bar{background:var(--accent-bg);border-radius:var(--radius);padding:12px 16px;display:flex;justify-content:space-between;align-items:center;margin-top:14px}
.total-bar .t-label{font-size:12px;font-weight:600;letter-spacing:.3px;color:var(--accent-text)}
.total-bar .t-amount{font-size:18px;font-weight:600;font-family:'DM Mono',monospace;color:var(--accent-text)}
/* product search */
.prod-search-wrap{position:relative}
.prod-search-input{width:100%;padding:8px 11px 8px 32px;border:1px solid var(--border2);border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface);transition:border-color .15s}
.prod-search-input:focus{outline:none;border-color:var(--accent);box-shadow:0 0 0 3px rgba(42,82,224,.1)}
.prod-search-icon{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text3);pointer-events:none}
.prod-dropdown{position:absolute;top:calc(100% + 4px);left:0;right:0;background:var(--surface);border:1px solid var(--border2);border-radius:var(--radius);box-shadow:var(--shadow-md);z-index:200;max-height:220px;overflow-y:auto;display:none}
.prod-dropdown.open{display:block}
.prod-option{padding:9px 12px;cursor:pointer;font-size:13px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:8px}
.prod-option:last-child{border-bottom:none}
.prod-option:hover,.prod-option.active{background:var(--accent-bg)}
.prod-option .p-name{font-weight:500;flex:1}
.prod-option .p-meta{font-size:11.5px;color:var(--text3);font-family:'DM Mono',monospace;white-space:nowrap}
.prod-option .p-stock-low{color:var(--red)}
.prod-selected-id{display:none}
.loading-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;z-index:2000}
.spinner{width:40px;height:40px;border:3px solid var(--surface);border-top-color:var(--accent);border-radius:50%;animation:spin 0.6s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}
</style>
</head>
<body>
<div class="app">

<aside class="sidebar">
  <div class="sidebar-brand">
    <h1>Stock<span>Flow</span></h1>
    <p>Inventory · Billing · POS</p>
  </div>
  <div style="padding:8px 0 10px">
    <div class="sidebar-section">Overview</div>
    <a class="nav-link" data-page="dashboard" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      Dashboard
    </a>
    <div class="sidebar-section">People</div>
    <a class="nav-link" data-page="admins" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
      Admins
    </a>
    <a class="nav-link" data-page="customers" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="9" cy="8" r="3.5"/><path d="M2 20c0-3.5 3.1-6 7-6"/><circle cx="17" cy="9" r="3"/><path d="M13 20c0-3 2.7-5 6-5"/></svg>
      Customers
    </a>
    <a class="nav-link" data-page="suppliers" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v4h-7V8z"/><circle cx="5.5" cy="18.5" r="2"/><circle cx="18.5" cy="18.5" r="2"/></svg>
      Suppliers
    </a>
    <div class="sidebar-section">Catalogue</div>
    <a class="nav-link" data-page="categories" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 7h5v5H3zm0 9h5v5H3zm9-9h9M12 12h9M12 16h9"/></svg>
      Categories
    </a>
    <a class="nav-link" data-page="products" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 16V8l-9-4-9 4v8l9 4 9-4z"/><path d="M3.27 6.96 12 12.01l8.73-5.05M12 22.08V12"/></svg>
      Products
    </a>
    <a class="nav-link" data-page="sup_products" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10 3H3v7h7V3zM21 3h-7v7h7V3zM21 14h-7v7h7v-7zM10 14H3v7h7v-7z"/></svg>
      Supplier Products
    </a>
    <div class="sidebar-section">Transactions</div>
    <a class="nav-link" data-page="purchases" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
      Purchases
    </a>
    <a class="nav-link" data-page="sales" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      Sales
    </a>
    <div class="sidebar-section">Warehouse</div>
    <a class="nav-link" data-page="inventory" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="1"/><path d="M16 7V5a2 2 0 00-4 0v2M8 7V5a2 2 0 00-4 0v2"/><line x1="2" y1="11" x2="22" y2="11"/></svg>
      Inventory Log
    </a>
  </div>
</aside>

<main class="main" id="main">
  <div class="page-fade" id="pageContent"></div>
</main>
</div>

<script>
// ============================================================
//  BACKEND API CONNECTION
// ============================================================
const API_BASE = '/inventory_system/';

// Global data store
let db = {
  admins: [], customers: [], suppliers: [], categories: [], products: [],
  supplier_products: [], purchases: [], purchase_items: [], sales: [], sale_items: [], inventory: []
};

let purCart = [];
let saleCart = [];
let activePage = 'dashboard';
let isLoading = false;

// Helper Functions
const find = (arr, id) => arr.find(x => x.id === id);
const catName = id => find(db.categories, id)?.name || '—';
const supName = id => find(db.suppliers, id)?.name || '—';
const custName = id => find(db.customers, id)?.name || '—';
const admName = id => find(db.admins, id)?.name || '—';
const prodName = id => find(db.products, id)?.name || id;
const fmt$ = n => '$' + (+(n||0)).toFixed(2);
const today = () => new Date().toISOString().slice(0,10);
const esc = v => String(v||'').replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;');
const val = id => { const el=document.getElementById(id); return el?el.value.trim():''; };
const numVal = id => parseFloat(document.getElementById(id)?.value)||0;

function showLoading() { if(isLoading) return; isLoading=true; const d=document.createElement('div'); d.id='loadingOverlay'; d.className='loading-overlay'; d.innerHTML='<div class="spinner"></div>'; document.body.appendChild(d); }
function hideLoading() { isLoading=false; document.getElementById('loadingOverlay')?.remove(); }

async function apiRequest(url, method, data = null) {
  try {
    const options = { method, headers: { 'Content-Type': 'application/json' } };
    if (data && (method === 'POST' || method === 'PUT')) options.body = JSON.stringify(data);
    const response = await fetch(API_BASE + url, options);
    const text = await response.text();
    try { return JSON.parse(text); } catch(e) { console.error('Invalid JSON:', text.substring(0,200)); throw new Error('Server returned invalid response.'); }
  } catch (error) { console.error(`API Error (${url}):`, error); throw error; }
}

async function loadAllData() {
  showLoading();
  try {
    const [admins, customers, suppliers, categories, products, supplier_products, purchases, sales, inventory] = await Promise.all([
      apiRequest('admin.php', 'GET').catch(()=>[]), apiRequest('customers.php', 'GET').catch(()=>[]),
      apiRequest('suppliers.php', 'GET').catch(()=>[]), apiRequest('categories.php', 'GET').catch(()=>[]),
      apiRequest('products.php', 'GET').catch(()=>[]), apiRequest('supplier_products.php', 'GET').catch(()=>[]),
      apiRequest('purchases.php', 'GET').catch(()=>[]), apiRequest('sales.php', 'GET').catch(()=>[]),
      apiRequest('inventory.php', 'GET').catch(()=>[])
    ]);
    db = { admins, customers, suppliers, categories, products, supplier_products, purchases, purchase_items: [], sales, sale_items: [], inventory };
    for(let p of db.purchases) { try { let full = await apiRequest(`purchases.php?id=${p.id}`,'GET'); p.items = full.items||[]; p.VAT = p.vat; } catch(e){ p.items=[]; } }
    for(let s of db.sales) { try { let full = await apiRequest(`sales.php?id=${s.id}`,'GET'); s.items = full.items||[]; s.VAT = s.vat; } catch(e){ s.items=[]; } }
    renderPage(activePage);
  } catch(err) { console.error(err); alert('Failed to load data. Check backend.'); } finally { hideLoading(); }
}

function buildModal({ id, title, size='480px', body, footer }){
  document.getElementById(id)?.remove();
  const w=document.createElement('div'); w.id=id; w.className='modal-overlay';
  w.innerHTML=`<div class="modal-box" style="max-width:${size}"><div class="modal-header"><h3>${title}</h3><button class="modal-close" onclick="document.getElementById('${id}').remove()">&times;</button></div><div class="modal-body">${body}</div><div class="modal-footer">${footer}</div></div>`;
  document.body.appendChild(w);
}
function closeModal(id){ document.getElementById(id)?.remove(); }
window.closeModal = closeModal;

// ========== CRUD Functions (keeping exactly your original logic) ==========
window.openAdminModal = function(id=null){
  const a = id ? find(db.admins,id) : {};
  buildModal({ id:'m-admin', title: id?'Edit Admin':'New Admin',
    body:`<div class="form-group"><label>Full Name *</label><input id="a-name" value="${esc(a.name)}"></div><div class="form-group"><label>Email *</label><input id="a-email" type="email" value="${esc(a.email)}"></div>`,
    footer:`<button class="btn btn-ghost" onclick="closeModal('m-admin')">Cancel</button><button class="btn btn-primary" onclick="saveAdmin('${id||''}')">Save</button>`
  });
};
window.saveAdmin = async function(id){
  const n=val('a-name'), e=val('a-email'); if(!n||!e) return alert('Name and email required.');
  try { if(id) await apiRequest('admin.php','PUT',{id,name:n,email:e}); else await apiRequest('admin.php','POST',{name:n,email:e}); closeModal('m-admin'); await loadAllData(); } catch(err){ alert('Error: '+err.message); }
};
window.deleteAdmin = async function(id){ if(!confirm('Delete admin?')) return; try { await apiRequest(`admin.php?id=${id}`,'DELETE'); await loadAllData(); } catch(err){ alert('Delete failed: '+err.message); } };

window.openCustomerModal = function(id=null){
  const c = id ? find(db.customers,id) : {};
  buildModal({ id:'m-cust', title: id?'Edit Customer':'New Customer', size:'520px',
    body:`<div class="form-group"><label>Full Name *</label><input id="cu-name" value="${esc(c.name)}"></div><div class="form-row col2"><div class="form-group"><label>Phone</label><input id="cu-phone" value="${esc(c.phone)}"></div><div class="form-group"><label>Alt. Phone</label><input id="cu-phopt" value="${esc(c.phone_opt)}"></div></div><div class="form-group"><label>Email</label><input id="cu-email" type="email" value="${esc(c.email)}"></div><div class="form-group"><label>Address</label><textarea id="cu-addr" rows="2">${esc(c.address)}</textarea></div>`,
    footer:`<button class="btn btn-ghost" onclick="closeModal('m-cust')">Cancel</button><button class="btn btn-primary" onclick="saveCustomer('${id||''}')">Save</button>`
  });
};
window.saveCustomer = async function(id){
  const n=val('cu-name'); if(!n) return alert('Name required.');
  const obj={name:n,phone:val('cu-phone'),phone_opt:val('cu-phopt'),email:val('cu-email'),address:val('cu-addr')};
  try { if(id) await apiRequest('customers.php','PUT',{id,...obj}); else await apiRequest('customers.php','POST',obj); closeModal('m-cust'); await loadAllData(); } catch(err){ alert('Error: '+err.message); }
};
window.deleteCustomer = async function(id){ if(!confirm('Delete customer?')) return; try { await apiRequest(`customers.php?id=${id}`,'DELETE'); await loadAllData(); } catch(err){ alert('Delete failed: '+err.message); } };

window.openSupplierModal = function(id=null){
  const s = id ? find(db.suppliers,id) : {};
  buildModal({ id:'m-sup', title: id?'Edit Supplier':'New Supplier', size:'520px',
    body:`<div class="form-group"><label>Supplier Name *</label><input id="s-name" value="${esc(s.name)}"></div><div class="form-row col2"><div class="form-group"><label>Phone *</label><input id="s-phone" value="${esc(s.phone)}"></div><div class="form-group"><label>Alt. Phone</label><input id="s-phopt" value="${esc(s.phone_opt)}"></div></div><div class="form-group"><label>Email</label><input id="s-email" type="email" value="${esc(s.email)}"></div><div class="form-group"><label>Address</label><textarea id="s-addr" rows="2">${esc(s.address)}</textarea></div>`,
    footer:`<button class="btn btn-ghost" onclick="closeModal('m-sup')">Cancel</button><button class="btn btn-primary" onclick="saveSupplier('${id||''}')">Save</button>`
  });
};
window.saveSupplier = async function(id){
  const n=val('s-name'), p=val('s-phone'); if(!n||!p) return alert('Name and phone required.');
  const obj={name:n,phone:p,phone_opt:val('s-phopt'),email:val('s-email'),address:val('s-addr')};
  try { if(id) await apiRequest('suppliers.php','PUT',{id,...obj}); else await apiRequest('suppliers.php','POST',obj); closeModal('m-sup'); await loadAllData(); } catch(err){ alert('Error: '+err.message); }
};
window.deleteSupplier = async function(id){ if(!confirm('Delete supplier?')) return; try { await apiRequest(`suppliers.php?id=${id}`,'DELETE'); await loadAllData(); } catch(err){ alert('Delete failed: '+err.message); } };

window.openCategoryModal = function(id=null){
  const c = id ? find(db.categories,id) : {};
  buildModal({ id:'m-cat', title: id?'Edit Category':'New Category',
    body:`<div class="form-group"><label>Name *</label><input id="cat-name" value="${esc(c.name)}"></div><div class="form-group"><label>Description</label><textarea id="cat-desc" rows="2">${esc(c.description)}</textarea></div>`,
    footer:`<button class="btn btn-ghost" onclick="closeModal('m-cat')">Cancel</button><button class="btn btn-primary" onclick="saveCategory('${id||''}')">Save</button>`
  });
};
window.saveCategory = async function(id){
  const n=val('cat-name'); if(!n) return alert('Name required.');
  const obj={name:n,description:val('cat-desc')};
  try { if(id) await apiRequest('categories.php','PUT',{id,...obj}); else await apiRequest('categories.php','POST',obj); closeModal('m-cat'); await loadAllData(); } catch(err){ alert('Error: '+err.message); }
};
window.deleteCategory = async function(id){ if(!confirm('Delete category?')) return; try { await apiRequest(`categories.php?id=${id}`,'DELETE'); await loadAllData(); } catch(err){ alert('Delete failed: '+err.message); } };

function catOpts(sel){ return db.categories.map(c=>`<option value="${c.id}"${c.id===sel?' selected':''}>${esc(c.name)}</option>`).join(''); }
window.openProductModal = function(id=null){
  const p = id ? find(db.products,id) : {};
  buildModal({ id:'m-prod', title: id?'Edit Product':'New Product', size:'580px',
    body:`<div class="form-group"><label>Product Name *</label><input id="p-name" value="${esc(p.name)}"></div><div class="form-group"><label>Description</label><textarea id="p-desc" rows="2">${esc(p.description)}</textarea></div><div class="form-row col2"><div class="form-group"><label>Category *</label><select id="p-cat">${catOpts(p.category_id)}</select></div><div class="form-group"><label>Unit</label><input id="p-unit" value="${esc(p.unit||'pcs')}"></div></div><div class="form-row col3"><div class="form-group"><label>Purchase Price *</label><input id="p-buy" type="number" min="0" step="0.01" value="${p.purchase_price||0}"></div><div class="form-group"><label>Selling Price *</label><input id="p-sell" type="number" min="0" step="0.01" value="${p.selling_price||0}"></div><div class="form-group"><label>Stock Quantity</label><input id="p-stock" type="number" min="0" value="${p.stock_quantity||0}"></div></div>`,
    footer:`<button class="btn btn-ghost" onclick="closeModal('m-prod')">Cancel</button><button class="btn btn-primary" onclick="saveProduct('${id||''}')">Save</button>`
  });
};
window.saveProduct = async function(id){
  const n=val('p-name'), c=val('p-cat'); if(!n||!c) return alert('Name and category required.');
  const pp=numVal('p-buy'), sp=numVal('p-sell'); if(sp<pp && !confirm('Selling price below purchase price. Continue?')) return;
  const obj={name:n,description:val('p-desc'),category_id:c,unit:val('p-unit')||'pcs',purchase_price:pp,selling_price:sp,stock_quantity:numVal('p-stock')};
  try { if(id) await apiRequest('products.php','PUT',{id,...obj}); else await apiRequest('products.php','POST',obj); closeModal('m-prod'); await loadAllData(); } catch(err){ alert('Error: '+err.message); }
};
window.deleteProduct = async function(id){ if(!confirm('Delete product? This may affect related records.')) return; try { await apiRequest(`products.php?id=${id}`,'DELETE'); await loadAllData(); } catch(err){ alert('Delete failed: '+err.message); } };

window.openSupProdModal = function(supId=null, prodId=null){
  const ex = supId&&prodId ? db.supplier_products.find(x=>x.supplier_id===supId&&x.product_id===prodId) : null;
  const isEdit = !!ex;
  const sOpts = db.suppliers.map(s=>`<option value="${s.id}"${s.id===supId?' selected':''}>${esc(s.name)}</option>`).join('');
  const pOpts = db.products.map(p=>`<option value="${p.id}"${p.id===prodId?' selected':''}>${esc(p.name)}</option>`).join('');
  buildModal({ id:'m-sp', title: isEdit?'Edit Supplier–Product Link':'Link Supplier to Product', size:'460px',
    body:`<div class="form-group"><label>Supplier *</label><select id="sp-sup"${isEdit?' disabled':''}>${sOpts}</select></div><div class="form-group"><label>Product *</label><select id="sp-prod"${isEdit?' disabled':''}>${pOpts}</select></div><div class="form-group"><label>Cost Price *</label><input id="sp-cost" type="number" min="0" step="0.01" value="${ex?ex.cost_price:0}"></div>${isEdit?`<input type="hidden" id="sp-sup-h" value="${supId}"><input type="hidden" id="sp-prod-h" value="${prodId}">`:''}`,
    footer:`<button class="btn btn-ghost" onclick="closeModal('m-sp')">Cancel</button><button class="btn btn-primary" onclick="saveSupProd(${isEdit})">Save</button>`
  });
};
window.saveSupProd = async function(isEdit){
  const cost=numVal('sp-cost'); if(cost<=0) return alert('Cost price >0 required.');
  if(isEdit){ const sid=val('sp-sup-h'), pid=val('sp-prod-h'); try { await apiRequest('supplier_products.php','PUT',{supplier_id:sid,product_id:pid,cost_price:cost}); closeModal('m-sp'); await loadAllData(); } catch(err){ alert('Error: '+err.message); } }
  else { const sid=val('sp-sup'), pid=val('sp-prod'); if(!sid||!pid) return alert('Select supplier and product.'); if(db.supplier_products.find(x=>x.supplier_id===sid&&x.product_id===pid)) return alert('Link exists.'); try { await apiRequest('supplier_products.php','POST',{supplier_id:sid,product_id:pid,cost_price:cost}); closeModal('m-sp'); await loadAllData(); } catch(err){ alert('Error: '+err.message); } }
};
window.deleteSupProd = async function(sid,pid){ if(!confirm('Remove link?')) return; try { await apiRequest(`supplier_products.php?supplier_id=${sid}&product_id=${pid}`,'DELETE'); await loadAllData(); } catch(err){ alert('Error: '+err.message); } };

// ========== PURCHASE MODULE (full original logic, no changes) ==========
window.openPurchaseModal = function(){
  purCart = [];
  const sOpts = db.suppliers.map(s=>`<option value="${s.id}">${esc(s.name)}</option>`).join('');
  const aOpts = db.admins.map(a=>`<option value="${a.id}">${esc(a.name)}</option>`).join('');
  buildModal({ id:'m-pur', title:'New Purchase Order', size:'800px',
    body:`<div class="form-row col3" style="margin-bottom:14px"><div class="form-group"><label>Supplier *</label><select id="pur-sup" onchange="purAutoFill()">${sOpts}</select></div><div class="form-group"><label>Admin *</label><select id="pur-adm">${aOpts}</select></div><div class="form-group"><label>Date *</label><input type="date" id="pur-date" value="${today()}"></div></div>
      <div style="background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);padding:14px;margin-bottom:14px"><div style="font-size:11.5px;font-weight:600;margin-bottom:10px">Add Product to Order</div><div class="form-row" style="grid-template-columns:2fr 1fr 1.2fr auto;align-items:end;gap:10px"><div class="form-group" style="margin:0"><label>Product</label><div class="prod-search-wrap" id="pur-prod-wrap"><svg class="prod-search-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg><input type="text" class="prod-search-input" id="pur-prod-search" placeholder="Search product…" autocomplete="off" oninput="filterPurProds()" onfocus="openPurDrop()" onblur="setTimeout(()=>closePurDrop(),180)"><input type="hidden" id="pur-prod"><div class="prod-dropdown" id="pur-prod-drop"></div></div></div><div class="form-group" style="margin:0"><label>Quantity *</label><input type="number" id="pur-qty" min="1" placeholder="0"></div><div class="form-group" style="margin:0"><label>Unit Price *</label><input type="number" id="pur-price" min="0" step="0.01" placeholder="0.00"></div><div style="padding-bottom:14px"><button class="btn btn-primary" onclick="addPurItem()">+ Add</button></div></div><div id="pur-hint" style="font-size:11.5px;color:var(--text3);margin-top:4px"></div></div>
      <table class="cart-table"><thead><tr><th>Product</th><th>Qty</th><th>Unit</th><th>Unit Price</th><th>Line Total</th><th></th></tr></thead><tbody id="pur-cart"></tbody></table>
      <div class="form-row col2" style="margin-top:16px"><div class="form-group"><label>Discount Type</label><select id="pur-disc-t" onchange="calcPur()"><option value="fixed">Fixed ($)</option><option value="percent">Percent (%)</option></select></div><div class="form-group"><label>Discount Amount</label><input type="number" id="pur-disc-a" value="0" min="0" oninput="calcPur()"></div><div class="form-group"><label>Shipping Charge ($)</label><input type="number" id="pur-ship" value="0" min="0" oninput="calcPur()"></div><div class="form-group"><label>VAT (%)</label><input type="number" id="pur-vat" value="10" min="0" oninput="calcPur()"></div></div>
      <div class="total-bar" id="pur-total-bar"><span class="t-label">ORDER TOTAL</span><span class="t-amount">$0.00</span></div>`,
    footer:`<button class="btn btn-ghost" onclick="closeModal('m-pur')">Cancel</button><button class="btn btn-success" onclick="submitPurchase()">✓ Confirm Purchase</button>`
  });
  initPurDrop();
};
window.initPurDrop = function(){ renderPurDrop(''); if(db.products.length) selectPurProd(db.products[0].id, db.products[0].name); };
window.renderPurDrop = function(q){ const drop=document.getElementById('pur-prod-drop'); if(!drop) return; const filtered=db.products.filter(p=>p.name.toLowerCase().includes(q.toLowerCase())||p.id.toLowerCase().includes(q.toLowerCase())); if(!filtered.length){ drop.innerHTML='<div class="prod-option" style="color:var(--text3);font-style:italic">No products found</div>'; return; } drop.innerHTML=filtered.map(p=>`<div class="prod-option" onclick="selectPurProd('${p.id}','${esc(p.name)}')"><span class="p-name">${esc(p.name)}</span><span class="p-meta ${p.stock_quantity<10?'p-stock-low':''}">stock: ${p.stock_quantity} · ${p.id}</span></div>`).join(''); };
window.filterPurProds = function(){ renderPurDrop(document.getElementById('pur-prod-search')?.value||''); openPurDrop(); };
window.openPurDrop = function(){ document.getElementById('pur-prod-drop')?.classList.add('open'); };
window.closePurDrop = function(){ document.getElementById('pur-prod-drop')?.classList.remove('open'); };
window.selectPurProd = function(id,name){ document.getElementById('pur-prod').value=id; document.getElementById('pur-prod-search').value=name; closePurDrop(); purAutoFill(); };
window.purAutoFill = function(){ const sid=val('pur-sup'), pid=val('pur-prod'); const sp=db.supplier_products.find(x=>x.supplier_id===sid&&x.product_id===pid); const hint=document.getElementById('pur-hint'); const priceEl=document.getElementById('pur-price'); if(sp){ if(priceEl) priceEl.value=sp.cost_price.toFixed(2); if(hint) hint.textContent=`Auto-filled from Supplier Products: ${fmt$(sp.cost_price)}`; } else { const p=find(db.products,pid); if(priceEl&&p) priceEl.value=p.purchase_price.toFixed(2); if(hint) hint.textContent='No Supplier–Product link — using product purchase price.'; } };
window.addPurItem = function(){ const pid=val('pur-prod'), qty=numVal('pur-qty'), price=numVal('pur-price'); if(qty<=0||price<=0) return alert('Quantity and price required.'); const prod=find(db.products,pid); const ex=purCart.find(x=>x.product_id===pid); if(ex){ ex.quantity+=qty; ex.total=ex.quantity*ex.price; } else purCart.push({product_id:pid,name:prod.name,unit:prod.unit,quantity:qty,price,total:qty*price}); document.getElementById('pur-qty').value=''; renderPurCart(); calcPur(); };
function renderPurCart(){ const tb=document.getElementById('pur-cart'); if(!tb) return; if(!purCart.length){ tb.innerHTML='<tr class="empty-row"><td colspan="6">No items added yet<\/td><\/tr>'; return; } tb.innerHTML=purCart.map((it,i)=>`<tr><td>${it.name}<\/td><td>${it.quantity}<\/td><td>${it.unit}<\/td><td class="mono">${fmt$(it.price)}<\/td><td class="mono">${fmt$(it.total)}<\/td><td><button class="btn btn-danger btn-sm" onclick="rmPurItem(${i})">✕<\/button><\/td><\/tr>`).join(''); }
window.rmPurItem = function(i){ purCart.splice(i,1); renderPurCart(); calcPur(); };
function calcPur(){ const sub=purCart.reduce((s,x)=>s+x.total,0); const dt=val('pur-disc-t')||'fixed', da=numVal('pur-disc-a'), sh=numVal('pur-ship'), vt=numVal('pur-vat'); const dv=dt==='percent'?sub*da/100:da; const af=sub-dv+sh; const total=Math.max(0,af+af*vt/100); const el=document.querySelector('#pur-total-bar .t-amount'); if(el) el.textContent=fmt$(total); return {sub,dt,da,sh,vt,total}; }
window.submitPurchase = async function(){ if(!purCart.length) return alert('Add at least one product.'); const sid=val('pur-sup'), aid=val('pur-adm'), date=val('pur-date'); if(!date) return alert('Select a date.'); const {sub,dt,da,sh,vt,total}=calcPur(); const purchaseData={ supplier_id:sid, admin_id:aid, date, subtotal:+sub.toFixed(2), vat:vt, discount_type:dt, discount_amount:da, shipping_charge:sh, total:+total.toFixed(2), items:purCart.map(it=>({ product_id:it.product_id, quantity:it.quantity, unit:it.unit, price:it.price, total:it.total })) }; try { await apiRequest('purchases.php','POST',purchaseData); closeModal('m-pur'); await loadAllData(); alert('Purchase saved! Stock updated.'); } catch(err){ alert('Error saving purchase: '+err.message); } };
window.viewPurchaseItems = function(pid){ const pur = db.purchases.find(p=>p.id===pid); if(!pur) return; const items=pur.items||[]; buildModal({ id:'m-pur-items', title:`Purchase Items — ${pid}`, size:'560px', body:`<table><thead><tr><th>Product</th><th>Qty</th><th>Unit</th><th>Price</th><th>Total</th></tr></thead><tbody>${items.map(it=>`<tr><td>${prodName(it.product_id)}<\/td><td>${it.quantity}<\/td><td>${it.unit}<\/td><td class="mono">${fmt$(it.price)}<\/td><td class="mono">${fmt$(it.total)}<\/td><\/tr>`).join('')}</tbody><\/table><div style="margin-top:12px;text-align:right">Supplier: <strong>${supName(pur.supplier_id)}</strong> · Admin: ${admName(pur.admin_id)} · Date: ${pur.date}<br>Subtotal: ${fmt$(pur.subtotal)} · Discount: ${pur.discount_type==='percent'?pur.discount_amount+'%':fmt$(pur.discount_amount)} · Shipping: ${fmt$(pur.shipping_charge)} · VAT: ${pur.vat}% · <strong>Total: ${fmt$(pur.total)}</strong></div>`, footer:`<button class="btn btn-primary" onclick="closeModal('m-pur-items')">Close</button>` }); };

// ========== SALE MODULE (POS) – full original, unchanged ==========
window.openSaleModal = function(){
  saleCart = [];
  const cOpts=db.customers.map(c=>`<option value="${c.id}">${esc(c.name)}</option>`).join('');
  const aOpts=db.admins.map(a=>`<option value="${a.id}">${esc(a.name)}</option>`).join('');
  buildModal({ id:'m-sale', title:'Point of Sale — New Sale', size:'820px',
    body:`<div class="form-row col3" style="margin-bottom:14px"><div class="form-group"><label>Customer *</label><select id="sal-cust">${cOpts}</select></div><div class="form-group"><label>Admin *</label><select id="sal-adm">${aOpts}</select></div><div class="form-group"><label>Date *</label><input type="date" id="sal-date" value="${today()}"></div></div>
      <div style="background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);padding:14px;margin-bottom:14px"><div style="font-size:11.5px;font-weight:600;margin-bottom:10px">Add to Cart</div><div class="form-row" style="grid-template-columns:2fr 1fr auto;align-items:end;gap:10px"><div class="form-group" style="margin:0"><label>Product</label><div class="prod-search-wrap" id="sal-prod-wrap"><svg class="prod-search-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg><input type="text" class="prod-search-input" id="sal-prod-search" placeholder="Search product…" autocomplete="off" oninput="filterSaleProds()" onfocus="openSaleDrop()" onblur="setTimeout(()=>closeSaleDrop(),180)"><input type="hidden" id="sal-prod"><div class="prod-dropdown" id="sal-prod-drop"></div></div></div><div class="form-group" style="margin:0"><label>Quantity *</label><input type="number" id="sal-qty" min="1" placeholder="1"></div><div style="padding-bottom:14px"><button class="btn btn-primary" onclick="addSaleItem()">+ Add to Cart</button></div></div><div id="sal-hint" style="font-size:11.5px;color:var(--text3);margin-top:4px"></div></div>
      <table class="cart-table"><thead><tr><th>Product</th><th>Qty</th><th>Selling Price</th><th>Line Total</th><th></th></tr></thead><tbody id="sal-cart"></tbody></table>
      <div class="form-row col3" style="margin-top:16px"><div class="form-group"><label>Discount Type</label><select id="sal-disc-t" onchange="calcSale()"><option value="fixed">Fixed ($)</option><option value="percent">Percent (%)</option></select></div><div class="form-group"><label>Discount Amount</label><input type="number" id="sal-disc-a" value="0" min="0" oninput="calcSale()"></div><div class="form-group"><label>VAT (%)</label><input type="number" id="sal-vat" value="10" min="0" oninput="calcSale()"></div></div>
      <div class="total-bar" id="sal-total-bar"><span class="t-label">SALE TOTAL</span><span class="t-amount">$0.00</span></div>`,
    footer:`<button class="btn btn-ghost" onclick="closeModal('m-sale')">Cancel</button><button class="btn btn-success" onclick="submitSale()">✓ Complete Sale</button>`
  });
  initSaleDrop();
};
window.initSaleDrop = function(){ renderSaleDrop(''); if(db.products.length) selectSaleProd(db.products[0].id, db.products[0].name); };
window.renderSaleDrop = function(q){ const drop=document.getElementById('sal-prod-drop'); if(!drop) return; const filtered=db.products.filter(p=>p.name.toLowerCase().includes(q.toLowerCase())||p.id.toLowerCase().includes(q.toLowerCase())); if(!filtered.length){ drop.innerHTML='<div class="prod-option" style="color:var(--text3);font-style:italic">No products found</div>'; return; } drop.innerHTML=filtered.map(p=>`<div class="prod-option" onclick="selectSaleProd('${p.id}','${esc(p.name)}')"><span class="p-name">${esc(p.name)}</span><span class="p-meta ${p.stock_quantity<10?'p-stock-low':''}">$${p.selling_price.toFixed(2)} · stock: ${p.stock_quantity}</span></div>`).join(''); };
window.filterSaleProds = function(){ renderSaleDrop(document.getElementById('sal-prod-search')?.value||''); openSaleDrop(); };
window.openSaleDrop = function(){ document.getElementById('sal-prod-drop')?.classList.add('open'); };
window.closeSaleDrop = function(){ document.getElementById('sal-prod-drop')?.classList.remove('open'); };
window.selectSaleProd = function(id,name){ document.getElementById('sal-prod').value=id; document.getElementById('sal-prod-search').value=name; closeSaleDrop(); saleHint(); };
window.saleHint = function(){ const p=find(db.products,val('sal-prod')); const h=document.getElementById('sal-hint'); if(p&&h) h.textContent=`Selling price: ${fmt$(p.selling_price)} · Available stock: ${p.stock_quantity} ${p.unit}`; };
window.addSaleItem = function(){ const pid=val('sal-prod'), qty=numVal('sal-qty'); if(qty<=0) return alert('Enter quantity.'); const prod=find(db.products,pid); const inCart=saleCart.find(x=>x.product_id===pid); const taken=inCart?inCart.quantity:0; if(prod.stock_quantity<taken+qty) return alert(`Only ${prod.stock_quantity-taken} available.`); if(inCart){ inCart.quantity+=qty; inCart.total=inCart.quantity*inCart.price; } else saleCart.push({product_id:pid,name:prod.name,quantity:qty,price:prod.selling_price,total:qty*prod.selling_price}); document.getElementById('sal-qty').value=''; renderSaleCart(); calcSale(); };
function renderSaleCart(){ const tb=document.getElementById('sal-cart'); if(!tb) return; if(!saleCart.length){ tb.innerHTML='<tr class="empty-row"><td colspan="5">Cart is empty<\/td><\/tr>'; return; } tb.innerHTML=saleCart.map((it,i)=>`<tr><td>${it.name}<\/td><td>${it.quantity}<\/td><td class="mono">${fmt$(it.price)}<\/td><td class="mono">${fmt$(it.total)}<\/td><td><button class="btn btn-danger btn-sm" onclick="rmSaleItem(${i})">✕<\/button><\/td><\/tr>`).join(''); }
window.rmSaleItem = function(i){ saleCart.splice(i,1); renderSaleCart(); calcSale(); };
function calcSale(){ const sub=saleCart.reduce((s,x)=>s+x.total,0); const dt=val('sal-disc-t')||'fixed', da=numVal('sal-disc-a'), vt=numVal('sal-vat'); const dv=dt==='percent'?sub*da/100:da; const af=sub-dv; const total=Math.max(0,af+af*vt/100); const el=document.querySelector('#sal-total-bar .t-amount'); if(el) el.textContent=fmt$(total); return {sub,dt,da,vt,total}; }
window.submitSale = async function(){ if(!saleCart.length) return alert('Cart empty.'); const cid=val('sal-cust'), aid=val('sal-adm'), date=val('sal-date'); if(!date) return alert('Select date.'); const {sub,dt,da,vt,total}=calcSale(); const saleData={ customer_id:cid, admin_id:aid, date, subtotal:+sub.toFixed(2), vat:vt, discount_type:dt, discount_amount:da, total:+total.toFixed(2), items:saleCart.map(it=>({ product_id:it.product_id, quantity:it.quantity, price:it.price, total:it.total })) }; try { await apiRequest('sales.php','POST',saleData); closeModal('m-sale'); await loadAllData(); alert(`Sale complete! Total: ${fmt$(total)}`); } catch(err){ alert('Error saving sale: '+err.message); } };
window.viewSaleItems = function(sid){ const sale = db.sales.find(s=>s.id===sid); if(!sale) return; const items=sale.items||[]; buildModal({ id:'m-sale-items', title:`Sale Items — ${sid}`, size:'520px', body:`<table><thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead><tbody>${items.map(it=>`<tr><td>${prodName(it.product_id)}<\/td><td>${it.quantity}<\/td><td class="mono">${fmt$(it.price)}<\/td><td class="mono">${fmt$(it.total)}<\/td><\/tr>`).join('')}</tbody><\/table><div style="margin-top:12px;text-align:right">Customer: <strong>${custName(sale.customer_id)}</strong> · Admin: ${admName(sale.admin_id)} · Date: ${sale.date}<br>Subtotal: ${fmt$(sale.subtotal)} · Discount: ${sale.discount_type==='percent'?sale.discount_amount+'%':fmt$(sale.discount_amount)} · VAT: ${sale.vat}% · <strong>Total: ${fmt$(sale.total)}</strong></div>`, footer:`<button class="btn btn-primary" onclick="closeModal('m-sale-items')">Close</button>` }); };

window.showSupplierProducts = function(supplierId){
  const supplier = find(db.suppliers, supplierId);
  const linked = db.supplier_products.filter(sp => sp.supplier_id === supplierId);
  if(linked.length === 0){ alert(`No products linked to ${supplier.name}.`); return; }
  let itemsHtml = '';
  for(let sp of linked){
    const prod = find(db.products, sp.product_id);
    if(prod){
      itemsHtml += `<tr><td><strong>${esc(prod.name)}</strong></td><td>${esc(prod.description || '—')}</td><td class="mono">${fmt$(sp.cost_price)}</td><td class="mono">${fmt$(prod.purchase_price)}</td><td><span class="badge badge-blue">${catName(prod.category_id)}</span></td><td>${prod.unit}</td></tr>`;
    }
  }
  buildModal({ id: 'm-supplier-prods', title: `Products supplied by ${supplier.name}`, size: '800px', body: `<table class="cart-table"><thead><tr><th>Product</th><th>Description</th><th>Supplier Cost Price</th><th>Our Purchase Price</th><th>Category</th><th>Unit</th></tr></thead><tbody>${itemsHtml}</tbody></table><div class="text-muted" style="margin-top:12px">💡 These cost prices are auto-filled when creating a new Purchase Order.</div>`, footer: `<button class="btn btn-primary" onclick="closeModal('m-supplier-prods')">Close</button>` });
};

// ========== PAGE RENDERERS – exactly your original style, only cleaned phone/address wrapping ==========
const pages = {
dashboard(){ 
  const totalStock=db.products.reduce((s,p)=>s+p.stock_quantity,0);
  const stockVal=db.products.reduce((s,p)=>s+p.stock_quantity*p.purchase_price,0);
  const salesRev=db.sales.reduce((s,x)=>s+x.total,0);
  const lowProds=db.products.filter(p=>p.stock_quantity<10);
  const recentSales=[...db.sales].reverse().slice(0,6);
  const recentPur=[...db.purchases].reverse().slice(0,4);
  return `<div class="page-header"><h2>Dashboard</h2><span class="mono text-muted">${today()}</span></div>
    <div class="stats-grid"><div class="stat-card blue"><div class="label">Products</div><div class="value">${db.products.length}</div></div><div class="stat-card green"><div class="label">Units in Stock</div><div class="value">${totalStock}</div></div><div class="stat-card amber"><div class="label">Stock Value</div><div class="value">${fmt$(stockVal)}</div></div><div class="stat-card"><div class="label">Sales Revenue</div><div class="value" style="color:var(--green)">${fmt$(salesRev)}</div></div></div>
    <div class="grid2"><div><div class="card"><div class="card-header"><h3>Recent Sales</h3><button class="btn btn-ghost btn-sm" onclick="renderPage('sales')">View all</button></div><table><thead><tr><th>Customer</th><th>Admin</th><th>Date</th><th>Total</th></tr></thead><tbody>${!recentSales.length?'<tr class="empty-row"><td colspan="4">No sales yet</td></tr>':recentSales.map(s=>`<tr><td>${custName(s.customer_id)}</td><td class="text-muted">${admName(s.admin_id)}</td><td class="mono">${s.date}</td><td><span class="badge badge-green">${fmt$(s.total)}</span></td></tr>`).join('')}</tbody></table></div><div class="card" style="margin-top:18px"><div class="card-header"><h3>Recent Purchases</h3><button class="btn btn-ghost btn-sm" onclick="renderPage('purchases')">View all</button></div><table><thead><tr><th>Supplier</th><th>Date</th><th>Total</th></tr></thead><tbody>${!recentPur.length?'<tr class="empty-row"><td colspan="3">No purchases yet</td></tr>':recentPur.map(p=>`<tr><td>${supName(p.supplier_id)}</td><td class="mono">${p.date}</td><td><span class="badge badge-amber">${fmt$(p.total)}</span></td></tr>`).join('')}</tbody></table></div></div><div><div class="card"><div class="card-header"><h3>Low Stock Alert <span style="color:var(--red)">(below 10 units)</span></h3></div><table><thead><tr><th>Product</th><th>Stock</th><th>Unit</th></tr></thead><tbody>${!lowProds.length?'<tr class="empty-row"><td colspan="3">All products sufficiently stocked ✓</td></tr>':lowProds.map(p=>`<tr><td>${p.name}</td><td><span class="badge badge-red">${p.stock_quantity}</span></td><td class="text-muted">${p.unit}</td></tr>`).join('')}</tbody></table></div><div class="card" style="margin-top:18px"><div class="card-header"><h3>Quick Actions</h3></div><div style="padding:16px;display:flex;flex-direction:column;gap:8px"><button class="btn btn-success" onclick="openSaleModal()" style="justify-content:center">🛒 New Sale (POS)</button><button class="btn btn-primary" onclick="openPurchaseModal()" style="justify-content:center">📦 New Purchase Order</button><button class="btn btn-ghost" onclick="renderPage('inventory')" style="justify-content:center">📊 View Inventory Log</button></div></div></div></div>`;
},
admins(){ return `<div class="page-header"><h2>Admins</h2><button class="btn btn-primary" onclick="openAdminModal()">+ New Admin</button></div><div class="card"><table><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr></thead><tbody>${!db.admins.length?'<tr class="empty-row"><td colspan="4">No admins</td></tr>':db.admins.map(a=>`<tr><td class="mono text-muted">${a.id}</td><td style="font-weight:500">${a.name}</td><td>${a.email}</td><td><button class="btn btn-ghost btn-sm" onclick="openAdminModal('${a.id}')">Edit</button><button class="btn btn-danger btn-sm" style="margin-left:4px" onclick="deleteAdmin('${a.id}')">Delete</button></td></tr>`).join('')}</tbody></table></div>`; },
customers(){ return `<div class="page-header"><h2>Customers</h2><button class="btn btn-primary" onclick="openCustomerModal()">+ New Customer</button></div><div class="card"><table><thead><tr><th>ID</th><th>Name</th><th>Phone</th><th>Alt. Phone</th><th>Email</th><th>Address</th><th>Actions</th></tr></thead><tbody>${!db.customers.length?'<tr class="empty-row"><td colspan="7">No customers yet</td></tr>':db.customers.map(c=>`<tr><td class="mono text-muted">${c.id}</td><td style="font-weight:500">${esc(c.name)}</td><td class="mono" style="word-break:break-word">${c.phone?esc(c.phone):'—'}</td><td class="mono" style="word-break:break-word">${c.phone_opt?esc(c.phone_opt):'—'}</td><td style="word-break:break-word">${c.email?`<a href="mailto:${esc(c.email)}" style="color:var(--accent)">${esc(c.email)}</a>`:'—'}</td><td style="word-break:break-word; max-width:200px">${c.address?esc(c.address):'—'}</td><td style="white-space:nowrap"><button class="btn btn-ghost btn-sm" onclick="openCustomerModal('${c.id}')">Edit</button><button class="btn btn-danger btn-sm" style="margin-left:4px" onclick="deleteCustomer('${c.id}')">Delete</button></td></tr>`).join('')}</tbody></table></div>`; },
suppliers(){ return `<div class="page-header"><h2>Suppliers</h2><button class="btn btn-primary" onclick="openSupplierModal()">+ New Supplier</button></div><div class="card"><table><thead><tr><th>ID</th><th>Name</th><th>Phone</th><th>Alt. Phone</th><th>Email</th><th>Address</th><th>Actions</th></tr></thead><tbody>${!db.suppliers.length?'<tr class="empty-row"><td colspan="7">No suppliers</td></tr>':db.suppliers.map(s=>`<tr><td class="mono text-muted">${s.id}</td><td style="font-weight:500">${s.name}</td><td class="mono">${s.phone||'—'}</td><td class="mono">${s.phone_opt||'—'}</td><td style="word-break:break-word">${s.email||'—'}</td><td style="word-break:break-word; max-width:200px">${s.address||'—'}</td><td><button class="btn btn-ghost btn-sm" onclick="openSupplierModal('${s.id}')">Edit</button><button class="btn btn-ghost btn-sm" style="margin-left:4px" onclick="showSupplierProducts('${s.id}')">📦 View Products</button><button class="btn btn-danger btn-sm" style="margin-left:4px" onclick="deleteSupplier('${s.id}')">Delete</button></td></tr>`).join('')}</tbody></table></div>`; },
categories(){ return `<div class="page-header"><h2>Categories</h2><button class="btn btn-primary" onclick="openCategoryModal()">+ New Category</button></div><div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px">${!db.categories.length?'<p class="text-muted">No categories yet.</p>':db.categories.map(c=>`<div class="card"><div style="padding:16px 18px"><div style="font-weight:600;font-size:15px;margin-bottom:4px">${c.name}</div><div class="text-muted" style="font-size:13px;margin-bottom:10px">${c.description||'No description'}</div><div class="text-muted" style="font-size:11px;margin-bottom:12px">${db.products.filter(p=>p.category_id===c.id).length} product(s)</div><div><button class="btn btn-ghost btn-sm" onclick="openCategoryModal('${c.id}')">Edit</button><button class="btn btn-danger btn-sm" style="margin-left:4px" onclick="deleteCategory('${c.id}')">Delete</button></div></div></div>`).join('')}</div>`; },
products(){ return `<div class="page-header"><h2>Products</h2><button class="btn btn-primary" onclick="openProductModal()">+ New Product</button></div><div class="card"><table><thead><tr><th>Product ID</th><th>Name</th><th>Category</th><th>Unit</th><th>Purchase Price</th><th>Selling Price</th><th>Stock Qty</th><th>Actions</th></tr></thead><tbody>${!db.products.length?'<tr class="empty-row"><td colspan="8">No products</td></tr>':db.products.map(p=>`<tr><td><span class="badge badge-blue mono">${p.id}</span></td><td><div style="font-weight:500">${p.name}</div><div class="text-muted" style="font-size:11.5px">${p.description||''}</div></td><td><span class="badge badge-blue">${catName(p.category_id)}</span></td><td class="text-muted">${p.unit}</td><td class="mono">${fmt$(p.purchase_price)}</td><td class="mono">${fmt$(p.selling_price)}</td><td>${p.stock_quantity<10?`<span class="badge badge-red">${p.stock_quantity} ⚠</span>`:`<span class="badge badge-green">${p.stock_quantity}</span>`}</td><td><button class="btn btn-ghost btn-sm" onclick="openProductModal('${p.id}')">Edit</button><button class="btn btn-danger btn-sm" style="margin-left:4px" onclick="deleteProduct('${p.id}')">Delete</button></td></tr>`).join('')}</tbody></table></div>`; },
sup_products(){ return `<div class="page-header"><h2>Supplier–Product Links</h2><button class="btn btn-primary" onclick="openSupProdModal()">+ Link Supplier to Product</button></div><p class="text-muted" style="margin-bottom:14px">Maps supplier to product with cost price. Auto-fills in Purchase Orders.</p><div class="card"><table><thead><tr><th>Supplier ID</th><th>Supplier</th><th>Product ID</th><th>Product</th><th>Category</th><th>Cost Price</th><th>Product Purchase Price</th><th>Actions</th></tr></thead><tbody>${!db.supplier_products.length?'<tr class="empty-row"><td colspan="8">No links yet</td></tr>':db.supplier_products.map(sp=>{ const p=find(db.products,sp.product_id); return `<tr><td><span class="badge badge-amber mono">${sp.supplier_id}</span></td><td style="font-weight:500">${supName(sp.supplier_id)}</td><td><span class="badge badge-blue mono">${sp.product_id}</span></td><td>${prodName(sp.product_id)}</td><td>${p?`<span class="badge badge-blue">${catName(p.category_id)}</span>`:'—'}</td><td class="mono">${fmt$(sp.cost_price)}</td><td class="mono text-muted">${p?fmt$(p.purchase_price):'—'}</td><td><button class="btn btn-ghost btn-sm" onclick="openSupProdModal('${sp.supplier_id}','${sp.product_id}')">Edit</button><button class="btn btn-danger btn-sm" style="margin-left:4px" onclick="deleteSupProd('${sp.supplier_id}','${sp.product_id}')">Remove</button></td></tr>` }).join('')}</tbody></table></div>`; },
purchases(){ return `<div class="page-header"><h2>Purchase Orders</h2><button class="btn btn-success" onclick="openPurchaseModal()">+ New Purchase</button></div><div class="card"><table><thead><tr><th>ID</th><th>Supplier</th><th>Admin</th><th>Date</th><th>Subtotal</th><th>Discount</th><th>Shipping</th><th>VAT</th><th>Total</th><th>Items</th></tr></thead><tbody>${!db.purchases.length?'<tr class="empty-row"><td colspan="10">No purchases yet</td></tr>':[...db.purchases].reverse().map(p=>`<tr><td class="mono text-muted">${p.id}</td><td>${supName(p.supplier_id)}</td><td class="text-muted">${admName(p.admin_id)}</td><td class="mono">${p.date}</td><td class="mono">${fmt$(p.subtotal)}</td><td class="text-muted">${p.discount_type==='percent'?p.discount_amount+'%':fmt$(p.discount_amount)}</td><td class="mono">${fmt$(p.shipping_charge)}</td><td class="text-muted">${p.vat}%</td><td><span class="badge badge-amber">${fmt$(p.total)}</span></td><td><button class="btn-link" onclick="viewPurchaseItems('${p.id}')">View</button></td></tr>`).join('')}</tbody></table></div>`; },
sales(){ return `<div class="page-header"><h2>Sales</h2><button class="btn btn-success" onclick="openSaleModal()">+ New Sale (POS)</button></div><div class="card"><table><thead><tr><th>ID</th><th>Customer</th><th>Admin</th><th>Date</th><th>Subtotal</th><th>Discount</th><th>VAT</th><th>Total</th><th>Items</th></tr></thead><tbody>${!db.sales.length?'<tr class="empty-row"><td colspan="9">No sales yet</td></tr>':[...db.sales].reverse().map(s=>`<tr><td class="mono text-muted">${s.id}</td><td>${custName(s.customer_id)}</td><td class="text-muted">${admName(s.admin_id)}</td><td class="mono">${s.date}</td><td class="mono">${fmt$(s.subtotal)}</td><td class="text-muted">${s.discount_type==='percent'?s.discount_amount+'%':fmt$(s.discount_amount)}</td><td class="text-muted">${s.vat}%</td><td><span class="badge badge-green">${fmt$(s.total)}</span></td><td><button class="btn-link" onclick="viewSaleItems('${s.id}')">View</button></td></tr>`).join('')}</tbody></table></div>`; },
inventory(){ const logs=[...db.inventory].reverse().slice(0,50); return `<div class="page-header"><h2>Inventory Log</h2><span class="text-muted">Log-only · current stock stored in Product.stock_quantity</span></div><div class="card" style="margin-bottom:22px"><div class="card-header"><h3>Current Stock Levels (from Product table)</h3></div><table><thead><tr><th>Product</th><th>Description</th><th>Category</th><th>Unit</th><th>Purchase Price</th><th>Selling Price</th><th>Stock Quantity</th></tr></thead><tbody>${db.products.map(p=>`<tr><td style="font-weight:500">${p.name}</td><td class="text-muted" style="font-size:12px">${p.description||'—'}</td><td><span class="badge badge-blue">${catName(p.category_id)}</span></td><td class="text-muted">${p.unit}</td><td class="mono">${fmt$(p.purchase_price)}</td><td class="mono">${fmt$(p.selling_price)}</td><td>${p.stock_quantity<10?`<span class="badge badge-red">${p.stock_quantity} ⚠</span>`:`<span class="badge badge-green">${p.stock_quantity}</span>`}</td></tr>`).join('')}</tbody></table></div><div class="card"><div class="card-header"><h3>Movement Log (Inventory table — last 50 entries)</h3></div><table><thead><tr><th>Log ID</th><th>Product</th><th>Quantity In</th><th>Quantity Out</th><th>Last Updated</th></tr></thead><tbody>${!logs.length?'<tr class="empty-row"><td colspan="5">No log entries yet</td></tr>':logs.map(l=>`<tr><td class="mono text-muted">${l.id}</td><td>${prodName(l.product_id)}</td><td>${l.quantity_in>0?`<span class="badge badge-green">+${l.quantity_in}</span>`:'—'}</td><td>${l.quantity_out>0?`<span class="badge badge-red">−${l.quantity_out}</span>`:'—'}</td><td class="mono">${l.last_updated}</td></tr>`).join('')}</tbody></table></div>`; }
};

function renderPage(page){ activePage = page; const pc = document.getElementById('pageContent'); pc.innerHTML = (pages[page] || pages.dashboard)(); document.querySelectorAll('.nav-link').forEach(l => { l.classList.toggle('active', l.dataset.page === page); }); }
document.querySelectorAll('.nav-link').forEach(l => { l.addEventListener('click', e => { e.preventDefault(); renderPage(l.dataset.page); }); });
renderPage('dashboard');
loadAllData();
</script>
</body>
</html>