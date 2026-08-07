
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>LOCIMMO — Tableau de bord</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<style>
/* ══════════════════════════════════════════
   TOKENS
══════════════════════════════════════════ */
:root {
  --gr:       #16a34a;
  --gr2:      #0d9488;
  --gr-dk:    #15803d;
  --gr-lt:    #f0fdf4;
  --gr-b:     #bbf7d0;
  --gr-glow:  rgba(22,163,74,.18);

  --blue:     #2563eb;
  --blue-lt:  #eff6ff;
  --blue-b:   #bfdbfe;
  --red:      #dc2626;
  --red-lt:   #fff1f2;
  --red-b:    #fecaca;
  --amber:    #d97706;
  --amber-lt: #fffbeb;
  --amber-b:  #fde68a;

  --bg:       #f1f4f9;
  --card:     #ffffff;
  --sb-bg:    #0d1f35;
  --sb-2:     #0f2840;

  --ink:      #0c0e17;
  --ink2:     #2e3244;
  --ink3:     #6b7280;
  --ink4:     #9ca3af;
  --bord:     rgba(14,16,34,.08);
  --bord2:    rgba(14,16,34,.04);

  --sh:       0 1px 3px rgba(0,0,0,.04), 0 4px 12px rgba(0,0,0,.05);
  --sh-md:    0 4px 8px rgba(0,0,0,.05), 0 12px 28px rgba(0,0,0,.09);
  --sh-lg:    0 8px 16px rgba(0,0,0,.06), 0 24px 48px rgba(0,0,0,.12);

  --r:        10px;
  --r-lg:     14px;
  --r-xl:     18px;

  --sb-w:     252px;
  --sb-col:   64px;
  --trans:    .26s cubic-bezier(.4,0,.2,1);
}

*, *::before, *::after { box-sizing: border-box; margin:0; padding:0; }
html { scroll-behavior: smooth; }
body {
  font-family: 'Inter', sans-serif;
  background: var(--bg);
  color: var(--ink);
  -webkit-font-smoothing: antialiased;
  min-height: 100vh;
  overflow-x: hidden;
}

/* ══════════════════════════════════════════
   SIDEBAR
══════════════════════════════════════════ */
.sidebar {
  position: fixed;
  top: 0; left: 0;
  width: var(--sb-w);
  height: 100vh;
  background: var(--sb-bg);
  display: flex;
  flex-direction: column;
  z-index: 900;
  overflow: hidden;
  transition: width var(--trans);
  border-right: 1px solid rgba(255,255,255,.04);
}

/* ligne d'accent verte */
.sidebar::before {
  content:'';
  position: absolute;
  top:0; left:0;
  width: 3px; height: 100%;
  background: linear-gradient(180deg, var(--gr) 0%, var(--gr2) 55%, transparent 100%);
  z-index:1;
}

/* ── Brand / Logo ── */
.sb-brand {
  padding: 18px 16px;
  border-bottom: 1px solid rgba(255,255,255,.06);
  flex-shrink: 0;
  position: relative; z-index: 2;
  display: flex;
  align-items: center;
  min-height: 100px;
}

/* Le logo prend toute la largeur disponible */
.sb-brand a {
  display: flex;
  align-items: center;
  text-decoration: none;
  overflow: hidden;
  width: 100%;
}

.sb-brand img {
  /* Taille fixe — ajuste height selon ton logo */
  height: 80px;
  width: auto;
  max-width: 148px;
  object-fit: contain;
  object-position: left center;
  /* filtre blanc si logo sombre — retire si logo déjà clair */
  /* filter: brightness(0) invert(1); */
  flex-shrink: 0;
  transition: opacity var(--trans), max-width var(--trans);
}

/* Logo réduit en mode collapsed : on garde juste l'icône / initiale */
.sidebar.collapsed .sb-brand img {
  max-width: 32px;
  /* coupe le texte du logo, ne garde que la partie icône gauche */
  object-position: left center;
}

/* ── Nav ── */
.sb-nav {
  flex: 1;
  padding: 10px 8px;
  overflow-y: auto;
  overflow-x: hidden;
  position: relative; z-index: 2;
}
.sb-nav::-webkit-scrollbar { width: 3px; }
.sb-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.08); border-radius:2px; }

.sb-label {
  font-size: .58rem; font-weight: 800;
  text-transform: uppercase; letter-spacing: .14em;
  color: rgba(255,255,255,.2);
  padding: 12px 12px 5px;
  display: block;
  white-space: nowrap; overflow: hidden;
  transition: opacity var(--trans);
}

.sb-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 11px;
    border-radius: var(--r);
    color: rgba(255,255,255,.45);
    text-decoration: none !important;
    font-size: .82rem; font-weight: 500;
    transition: all .18s;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    position: relative;
}
.sb-link i { font-size: 13px; width: 18px; text-align: center; flex-shrink: 0; }
.sb-link .link-text { overflow: hidden; white-space: nowrap; transition: opacity var(--trans), width var(--trans); }

.sb-link:hover { background: rgba(255,255,255,.06); color: rgba(255,255,255,.82); }
.sb-link.active {
  background: linear-gradient(135deg, rgba(22,163,74,.24), rgba(13,148,136,.14));
  color: #4ade80; font-weight: 700;
  border: 1px solid rgba(22,163,74,.2);
}
.sb-link.active i { color: #4ade80; }

/* ── Bottom user ── */
.sb-bottom {
  padding: 10px 8px;
  border-top: 1px solid rgba(255,255,255,.06);
  flex-shrink: 0;
  position: relative; z-index: 2;
}
.sb-user {
  display: flex; align-items: center; gap: 10px;
  padding: 9px 11px;
  background: rgba(255,255,255,.05);
  border: 1px solid rgba(255,255,255,.06);
  border-radius: var(--r);
  overflow: hidden;
}
.sb-avatar {
  width: 32px; height: 32px;
  border-radius: 9px;
  background: linear-gradient(135deg, var(--gr), var(--gr2));
  color: #fff; font-size: 12px; font-weight: 800;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.sb-user-info { overflow: hidden; min-width: 0; transition: opacity var(--trans); }
.sb-user-name { font-size: .78rem; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.sb-user-role { font-size: .62rem; color: rgba(255,255,255,.3); white-space: nowrap; }

/* ── Collapsed ── */
.sidebar.collapsed { width: var(--sb-col); }
.sidebar.collapsed .sb-label { opacity: 0; }
.sidebar.collapsed .link-text { opacity: 0; width: 0; }
.sidebar.collapsed .sb-link { justify-content: center; padding: 10px; }
.sidebar.collapsed .sb-user-info { opacity: 0; width: 0; }
.sidebar.collapsed .sb-brand { justify-content: center; padding: 16px 0; }

/* ══════════════════════════════════════════
   MAIN
══════════════════════════════════════════ */
.main {
  margin-left: var(--sb-w);
  min-height: 100vh;
  transition: margin var(--trans);
  display: flex; flex-direction: column;
}
.main.shifted { margin-left: var(--sb-col); }

/* ══════════════════════════════════════════
   TOPBAR
══════════════════════════════════════════ */
.topbar {
  position: sticky; top: 0; z-index: 800;
  background: rgba(241,244,249,.92);
  backdrop-filter: blur(18px);
  -webkit-backdrop-filter: blur(18px);
  border-bottom: 1px solid var(--bord);
  padding: 11px 24px;
  display: flex; align-items: center;
  justify-content: space-between;
  gap: 12px; flex-wrap: wrap;
}
.topbar-left { display: flex; align-items: center; gap: 12px; }
.topbar-title h1 { font-size: 1.05rem; font-weight: 800; color: var(--ink); letter-spacing: -.03em; }
.topbar-title p  { font-size: .73rem; color: var(--ink3); margin-top: 2px; }
.topbar-right { display: flex; align-items: center; gap: 8px; }

.ic-btn {
  width: 34px; height: 34px;
  border: 1.5px solid var(--bord);
  border-radius: var(--r);
  background: var(--card);
  color: var(--ink3);
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; font-size: 13px;
  transition: all .18s; box-shadow: var(--sh);
}
.ic-btn:hover { border-color: var(--gr); color: var(--gr); background: var(--gr-lt); }

.btn-green {
  background: linear-gradient(135deg, var(--gr), var(--gr2));
  color: #fff !important;
  border: none;
  padding: 8px 16px;
  border-radius: var(--r);
  font-size: .8rem; font-weight: 700;
  display: inline-flex; align-items: center; gap: 7px;
  text-decoration: none !important;
  transition: all .2s;
  box-shadow: 0 4px 12px var(--gr-glow);
  white-space: nowrap; cursor: pointer;
  font-family: 'Inter', sans-serif;
}
.btn-green:hover {
  background: linear-gradient(135deg, var(--gr-dk), var(--gr));
  transform: translateY(-1px);
  box-shadow: 0 6px 18px rgba(22,163,74,.35);
}

.user-btn {
  display: flex; align-items: center; gap: 8px;
  padding: 5px 11px 5px 6px;
  border: 1.5px solid var(--bord);
  border-radius: var(--r);
  background: var(--card);
  cursor: pointer;
  font-size: .8rem; font-weight: 600;
  color: var(--ink); text-decoration: none !important;
  transition: all .18s; box-shadow: var(--sh);
  font-family: 'Inter', sans-serif;
}
.user-btn:hover { border-color: var(--gr); }
.user-btn .mini-av {
  width: 24px; height: 24px; border-radius: 7px;
  background: linear-gradient(135deg, var(--gr), var(--gr2));
  color: #fff; font-size: 10px; font-weight: 800;
  display: flex; align-items: center; justify-content: center;
}

/* ══════════════════════════════════════════
   PAGE BODY
══════════════════════════════════════════ */
.page-body { padding: 20px 24px 48px; flex: 1; }

/* ══════════════════════════════════════════
   STATS
══════════════════════════════════════════ */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(4,1fr);
  gap: 13px;
  margin-bottom: 20px;
}
.stat-card {
  background: var(--card);
  border: 1px solid var(--bord);
  border-radius: var(--r-xl);
  padding: 18px 16px;
  display: flex; align-items: center; gap: 13px;
  box-shadow: var(--sh);
  opacity: 0; transform: translateY(14px);
  animation: fadeUp .44s cubic-bezier(.16,1,.3,1) forwards;
  transition: box-shadow .2s, transform .2s;
  position: relative; overflow: hidden;
}
.stat-card:hover { box-shadow: var(--sh-md); transform: translateY(-3px); }
.stat-card::after {
  content:''; position: absolute;
  bottom: -22px; right: -22px;
  width: 80px; height: 80px;
  border-radius: 50%; opacity:.07;
}
.stat-card:hover::after { opacity:.14; }
.stat-card:nth-child(1) { animation-delay:.04s; border-left: 3px solid var(--gr); }  .stat-card:nth-child(1)::after { background:var(--gr); }
.stat-card:nth-child(2) { animation-delay:.09s; border-left: 3px solid var(--blue); } .stat-card:nth-child(2)::after { background:var(--blue); }
.stat-card:nth-child(3) { animation-delay:.14s; border-left: 3px solid var(--gr2); }  .stat-card:nth-child(3)::after { background:var(--gr2); }
.stat-card:nth-child(4) { animation-delay:.19s; border-left: 3px solid var(--red); }  .stat-card:nth-child(4)::after { background:var(--red); }

.stat-ico {
  width: 46px; height: 46px; border-radius: 13px;
  display: flex; align-items: center; justify-content: center;
  font-size: 17px; flex-shrink: 0;
}
.ico-gr   { background:var(--gr-lt);   color:var(--gr);   border:1.5px solid var(--gr-b); }
.ico-blue { background:var(--blue-lt); color:var(--blue); border:1.5px solid var(--blue-b); }
.ico-teal { background:#f0fdfa;        color:var(--gr2);  border:1.5px solid #99f6e4; }
.ico-red  { background:var(--red-lt);  color:var(--red);  border:1.5px solid var(--red-b); }

.stat-body { flex:1; min-width:0; }
.stat-val {
  font-family: 'JetBrains Mono', monospace;
  font-size: 1.5rem; font-weight: 700;
  letter-spacing: -.04em; line-height: 1;
  color: var(--ink);
}
.stat-lbl { font-size:.7rem; color:var(--ink3); font-weight:500; margin-top:4px; }
.stat-badge {
  display: inline-flex; align-items: center; gap: 4px;
  font-size:.63rem; font-weight:700;
  padding: 2px 8px; border-radius: 20px; margin-top:6px;
}
.badge-up  { background:var(--gr-lt);  color:var(--gr); }
.badge-dn  { background:var(--red-lt); color:var(--red); }
.badge-neu { background:#f1f4f9;       color:var(--ink3); }

/* ══════════════════════════════════════════
   TABLE CARD
══════════════════════════════════════════ */
.table-card {
  background: var(--card);
  border: 1px solid var(--bord);
  border-radius: var(--r-xl);
  box-shadow: var(--sh);
  overflow: hidden;
  opacity: 0;
  animation: fadeUp .5s .26s cubic-bezier(.16,1,.3,1) forwards;
}
.tc-header {
  padding: 15px 20px 12px;
  border-bottom: 1px solid var(--bord2);
  display: flex; align-items: center;
  justify-content: space-between;
  flex-wrap: wrap; gap: 10px;
}
.tc-header-left { display: flex; align-items: center; gap: 9px; }
.tc-header h5 { font-size:.9rem; font-weight:800; color:var(--ink); letter-spacing:-.02em; }
.count-chip {
  background:var(--gr-lt); color:var(--gr);
  font-size:.63rem; font-weight:800;
  padding: 2px 9px; border-radius:20px;
  border: 1px solid rgba(22,163,74,.16);
}

/* Table */
table.dataTable { border-collapse:separate!important; border-spacing:0!important; width:100%!important; }
table.dataTable thead th {
  background: #f8fafc;
  color: var(--ink3);
  font-size:.63rem; font-weight:800;
  text-transform:uppercase; letter-spacing:.09em;
  padding: 10px 16px;
  border-bottom: 1px solid var(--bord);
  border-top: none; white-space:nowrap;
}
table.dataTable tbody tr { transition: background .12s; }
table.dataTable tbody tr:hover td { background: #f8fcfa; }
table.dataTable tbody td {
  padding: 12px 16px; font-size:.81rem;
  color: var(--ink); border-bottom: 1px solid var(--bord2);
  vertical-align: middle; background: transparent;
}
table.dataTable tbody tr:last-child td { border-bottom: none; }

.row-num {
  width: 26px; height: 26px; border-radius:7px;
  background:#f1f4f9;
  display:inline-flex; align-items:center; justify-content:center;
  font-size:.68rem; font-weight:800; color:var(--ink3);
  font-family:'JetBrains Mono',monospace;
}
.date-main {
  font-family:'JetBrains Mono',monospace;
  font-size:.74rem; font-weight:500; color:var(--ink2);
  display:flex; align-items:center; gap:5px;
}
.date-time {
  font-family:'JetBrains Mono',monospace;
  font-size:.66rem; color:var(--ink4);
  display:flex; align-items:center; gap:5px; margin-top:3px;
}
.ann-title { font-size:.82rem; font-weight:700; color:var(--ink); }
.ann-loc {
  font-size:.68rem; color:var(--ink3);
  display:flex; align-items:center; gap:4px; margin-top:3px;
}
.ann-loc i { color:var(--gr); font-size:9px; }

.badge-loc {
  display:inline-flex; align-items:center; gap:5px;
  padding:3px 10px; border-radius:20px;
  font-size:.68rem; font-weight:700;
  background:var(--gr-lt); color:var(--gr);
  border:1px solid rgba(22,163,74,.18); white-space:nowrap;
}
.badge-vnd {
  display:inline-flex; align-items:center; gap:5px;
  padding:3px 10px; border-radius:20px;
  font-size:.68rem; font-weight:700;
  background:var(--blue-lt); color:var(--blue);
  border:1px solid rgba(37,99,235,.16); white-space:nowrap;
}

.price-val {
  font-family:'JetBrains Mono',monospace;
  font-size:.84rem; font-weight:700; color:var(--ink); white-space:nowrap;
}
.price-unit { font-size:.62rem; color:var(--ink3); font-weight:500; margin-left:2px; }

.view-badge {
  display:inline-flex; align-items:center; gap:5px;
  padding:3px 10px; border-radius:20px;
  font-family:'JetBrains Mono',monospace;
  font-size:.73rem; font-weight:700;
  white-space:nowrap; transition:all .28s;
}
.view-low    { background:#f1f4f9;       color:var(--ink3); }
.view-medium { background:var(--gr-lt);  color:#059669; }
.view-high   { background:var(--amber-lt); color:var(--amber); }
.view-viral  { background:var(--red-lt); color:var(--red); }

.dot-on {
  display:inline-block; width:7px; height:7px;
  background:var(--gr); border-radius:50%; margin-right:6px;
  box-shadow:0 0 0 3px var(--gr-glow);
  animation: pulseDot 2s infinite;
}
.dot-off {
  display:inline-block; width:7px; height:7px;
  background:var(--ink4); border-radius:50%; margin-right:6px;
}
.status-txt { font-size:.76rem; font-weight:700; display:flex; align-items:center; }

/* Actions */
.act-drop .dropdown-toggle {
  width:30px; height:30px; border-radius:8px;
  border:1.5px solid var(--bord); background:var(--card);
  color:var(--ink3); display:inline-flex; align-items:center; justify-content:center;
  font-size:12px; cursor:pointer; transition:all .16s; padding:0;
}
.act-drop .dropdown-toggle::after { display:none; }
.act-drop .dropdown-toggle:hover { border-color:var(--gr); color:var(--gr); background:var(--gr-lt); }

.act-menu {
  border:1px solid var(--bord); border-radius:13px;
  box-shadow:var(--sh-lg); padding:5px; min-width:176px;
  animation: menuDrop .14s ease;
}
.act-menu .dropdown-item {
  display:flex; align-items:center; gap:9px;
  padding:8px 11px; border-radius:8px;
  font-size:.8rem; font-weight:500; color:var(--ink);
  transition:all .12s; border:none; background:none;
  width:100%; cursor:pointer;
}
.act-menu .dropdown-item i { width:13px; text-align:center; font-size:11px; }
.act-menu .dropdown-item:hover           { background:#f1f4f9; }
.act-menu .dropdown-item.i-view:hover    { background:var(--blue-lt); color:var(--blue); }
.act-menu .dropdown-item.i-edit:hover    { background:var(--amber-lt); color:var(--amber); }
.act-menu .dropdown-item.i-toggle:hover  { background:var(--gr-lt); color:var(--gr); }
.act-menu .dropdown-item.i-del           { color:var(--red); }
.act-menu .dropdown-item.i-del:hover     { background:var(--red-lt); }
.act-menu .dropdown-divider              { margin:4px 0; border-color:var(--bord2); }

/* DataTable overrides */
.dataTables_wrapper .dataTables_length select,
.dataTables_wrapper .dataTables_filter input {
  border:1.5px solid var(--bord); border-radius:8px;
  padding:6px 10px; font-size:.76rem;
  font-family:'Inter',sans-serif; outline:none; background:var(--card);
}
.dataTables_wrapper .dataTables_filter input:focus {
  border-color:var(--gr); box-shadow:0 0 0 3px rgba(22,163,74,.07);
}
.dataTables_wrapper .dataTables_info { font-size:.72rem; color:var(--ink3); }
.dataTables_wrapper .dataTables_paginate { margin-top:2px; }
.dataTables_wrapper .page-link { border-radius:7px!important; font-size:.74rem; }
.dataTables_wrapper .page-item.active .page-link { background:var(--gr); border-color:var(--gr); }
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter { padding:13px 20px 0; }
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate { padding:12px 20px 8px; }

/* ══════════════════════════════════════════
   MODALS
══════════════════════════════════════════ */
.modal { z-index:1055!important; }
.modal-backdrop { z-index:1050!important; }
.modal-content {
  border:none; border-radius:18px;
  box-shadow:0 20px 50px rgba(0,0,0,.13);
  overflow:hidden; font-family:'Inter',sans-serif;
}
.modal-header {
  padding:16px 20px 13px; border-bottom:1px solid var(--bord); background:#fafcfb;
}
.modal-header .modal-title { font-size:.88rem; font-weight:800; letter-spacing:-.02em; }
.modal-body  { padding:20px; }
.modal-footer {
  padding:12px 20px; border-top:1px solid var(--bord2); background:#fafcfb;
  display:flex; align-items:center; justify-content:center; gap:10px;
}
.confirm-ico {
  width:58px; height:58px; border-radius:50%;
  display:flex; align-items:center; justify-content:center;
  font-size:22px; margin:0 auto 14px;
}
.confirm-ico.danger  { background:var(--red-lt);   color:var(--red); }
.confirm-ico.warning { background:var(--amber-lt); color:var(--amber); }
.confirm-ico.success { background:var(--gr-lt);    color:var(--gr); }
.modal-body h6 { font-size:.88rem; font-weight:800; letter-spacing:-.02em; margin-bottom:6px; }
.modal-body p  { font-size:.79rem; color:var(--ink3); }

/* ══════════════════════════════════════════
   TOASTS
══════════════════════════════════════════ */
.toast { border-radius:13px!important; border:none!important; font-family:'Inter',sans-serif; }
.toast-body { font-size:.8rem; font-weight:600; }

/* ══════════════════════════════════════════
   OVERLAY MOBILE
══════════════════════════════════════════ */
.sb-overlay {
  display:none; position:fixed; inset:0;
  background:rgba(0,0,0,.45); z-index:890;
  backdrop-filter:blur(3px);
}

/* ══════════════════════════════════════════
   TOOLTIP ANNONCE
══════════════════════════════════════════ */
.tooltip-ann { position:relative; display:inline-block; }
.tooltip-ann .tip {
  visibility:hidden; opacity:0;
  position:absolute; bottom:110%; left:50%;
  transform:translateX(-50%);
  background:#1f2937; color:#fff;
  padding:7px 13px; border-radius:9px;
  font-size:.72rem; white-space:nowrap;
  transition:.18s ease; z-index:1000;
  box-shadow:0 8px 18px rgba(0,0,0,.14);
  pointer-events:none;
}
.tooltip-ann .tip::after {
  content:''; position:absolute;
  top:100%; left:50%; transform:translateX(-50%);
  border:5px solid transparent;
  border-top-color:#1f2937;
}
.tooltip-ann:hover .tip { visibility:visible; opacity:1; }

/* ══════════════════════════════════════════
   ANIMATIONS
══════════════════════════════════════════ */
@keyframes fadeUp {
  to { opacity:1; transform:translateY(0); }
}
@keyframes pulseDot {
  0%,100% { box-shadow:0 0 0 3px var(--gr-glow); }
  50%      { box-shadow:0 0 0 5px rgba(22,163,74,.05); }
}
@keyframes menuDrop {
  from { opacity:0; transform:scale(.94) translateY(-4px); }
  to   { opacity:1; transform:scale(1) translateY(0); }
}

/* ══════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════ */
@media(max-width:1200px) { .stats-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:991px) {
  .sidebar { transform:translateX(-100%); width:var(--sb-w)!important; transition:transform var(--trans); }
  .sidebar.mobile-open { transform:translateX(0); }
  .main { margin-left:0!important; }
  .topbar { padding:10px 14px; }
  .page-body { padding:14px 14px 40px; }
}
@media(max-width:600px) {
  .stats-grid { grid-template-columns:1fr 1fr; gap:10px; }
  .stat-card { padding:14px 12px; }
  .stat-val { font-size:1.25rem; }
  .topbar-right .user-btn span { display:none; }
}
@media(max-width:400px) { .stats-grid { grid-template-columns:1fr; } }
.link-loader.loading { opacity:.5; pointer-events:none; }
</style>
</head>
<body>

{{-- ════════ SIDEBAR ════════ --}}
<aside class="sidebar" id="sidebar">

  {{-- Logo --}}
  <div class="sb-brand">
    <a href="{{ route('home') }}">
      <img
        src="{{ asset('logo.png') }}"
        alt="LOCIMMO">
    </a>
  </div>

  {{-- Navigation --}}
  <nav class="sb-nav">
    <span class="sb-label">Principal</span>
    <a href="{{ route('home') }}" class="sb-link active">
      <i class="fa-solid fa-chart-pie"></i>
      <span class="link-text">Tableau de bord</span>
    </a>
    <a href="{{ route('annonce.all') }}" class="sb-link">
      <i class="fa-solid fa-house-chimney"></i>
      <span class="link-text">Offres disponibles</span>
    </a>

    <span class="sb-label" style="margin-top:6px;">Mon compte</span>
    <a href="{{ route('user.profil') }}" class="sb-link">
      <i class="fa-solid fa-user-circle"></i>
      <span class="link-text">Mon profil</span>
    </a>
    <a href="{{ route('user.logout') }}" class="sb-link">
      <i class="fa-solid fa-right-from-bracket"></i>
      <span class="link-text">Déconnexion</span>
    </a>
  </nav>

  {{-- User --}}
  <div class="sb-bottom">
    <div class="sb-user">
      <div class="sb-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}</div>
      <div class="sb-user-info">
        <div class="sb-user-name">{{ Auth::user()->name ?? 'Utilisateur' }}</div>
        <div class="sb-user-role">Propriétaire</div>
      </div>
    </div>
  </div>

</aside>

{{-- Overlay mobile --}}
<div class="sb-overlay" id="sbOverlay" onclick="closeSidebar()"></div>

{{-- ════════ MAIN ════════ --}}
<div class="main" id="main">

  {{-- TOPBAR --}}
  <header class="topbar">
    <div class="topbar-left">
      <button class="ic-btn" onclick="toggleSidebar()" title="Menu">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div class="topbar-title">
        <h1>Tableau de bord</h1>
        <p>Bonjour, {{ Auth::user()->name ?? 'Utilisateur' }} 👋</p>
      </div>
    </div>
    <div class="topbar-right">
      <a href="{{ route('appartement') }}" class="btn-green">
        <i class="fa-solid fa-plus" style="font-size:10px;"></i>
        Nouvelle annonce
      </a>
      <div class="dropdown">
        <button class="user-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="mini-av">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}</div>
          <span>{{ Auth::user()->name ?? 'Utilisateur' }}</span>
          <i class="fa-solid fa-chevron-down" style="font-size:9px;color:var(--ink3);"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end act-menu" style="min-width:168px;margin-top:6px;">
          <li>
            <a class="dropdown-item i-view" href="{{ route('user.profil') }}">
              <i class="fa-solid fa-user"></i> Mon profil
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item i-del" href="{{ route('user.logout') }}">
              <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
            </a>
          </li>
        </ul>
      </div>
    </div>
  </header>

  {{-- PAGE BODY --}}
  <div class="page-body">

    {{-- ── STATS ── --}}
    <div class="stats-grid">

      <div class="stat-card">
        <div class="stat-ico ico-gr"><i class="fa-solid fa-building"></i></div>
        <div class="stat-body">
          <div class="stat-val">{{ $nombreAppartements }}</div>
          <div class="stat-lbl">Annonces publiées</div>
          <span class="stat-badge badge-neu"><i class="fa-solid fa-list"></i> Total</span>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-ico ico-blue"><i class="fa-solid fa-eye"></i></div>
        <div class="stat-body">
          <div class="stat-val">{{ number_format($totalViews, 0, ',', ' ') }}</div>
          <div class="stat-lbl">Vues totales</div>
          <span class="stat-badge badge-up"><i class="fa-solid fa-chart-line"></i> Toutes annonces</span>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-ico ico-teal"><i class="fa-solid fa-circle-check"></i></div>
        <div class="stat-body">
          <div class="stat-val">{{ $appartements->where('statut', true)->count() }}</div>
          <div class="stat-lbl">Annonces actives</div>
          <span class="stat-badge badge-up"><i class="fa-solid fa-arrow-up"></i> En ligne</span>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-ico ico-red"><i class="fa-solid fa-circle-xmark"></i></div>
        <div class="stat-body">
          <div class="stat-val">{{ $appartements->where('statut', false)->count() }}</div>
          <div class="stat-lbl">Annonces inactives</div>
          <span class="stat-badge badge-dn"><i class="fa-solid fa-arrow-down"></i> Hors ligne</span>
        </div>
      </div>

    </div>

    {{-- ── TABLE ── --}}
    <div class="table-card">
      <div class="tc-header">
        <div class="tc-header-left">
          <i class="fa-solid fa-list-ul" style="color:var(--ink3);font-size:12px;"></i>
          <h5>Mes annonces</h5>
          <span class="count-chip">{{ $nombreAppartements }}</span>
        </div>
        <a href="{{ route('appartement') }}" class="btn-green" style="padding:6px 13px;font-size:.76rem;">
          <i class="fa-solid fa-plus" style="font-size:9px;"></i> Ajouter
        </a>
      </div>

      <div class="table-responsive">
        <table class="table" id="dataTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Date</th>
              <th>Annonce</th>
              <th>Catégorie</th>
              <th>Prix</th>
              <th>Vues</th>
              <th>Statut</th>
              <th style="text-align:center">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($appartements as $index => $app)
            <tr>
              <td><span class="row-num">{{ $index + 1 }}</span></td>

              <td>
                <div class="date-main">
                  <i class="fa-regular fa-calendar" style="color:var(--gr);font-size:9px;"></i>
                  {{ $app->created_at->timezone('Africa/Porto-Novo')->format('d/m/Y') }}
                </div>
                <div class="date-time">
                  <i class="fa-regular fa-clock" style="font-size:8px;"></i>
                  {{ $app->created_at->timezone('Africa/Porto-Novo')->format('H:i') }}
                </div>
              </td>

              <td>
                <div class="tooltip-ann">
                  <a href="{{ route('appartement.detail', $app->id) }}" style="text-decoration:none;color:inherit;">
                    <div class="ann-title">{{ $app->type }}</div>
                    <div class="ann-loc">
                      <i class="fa-solid fa-location-dot"></i>
                      {{ $app->quartier }}
                    </div>
                  </a>
                  <span class="tip">Voir · {{ $app->type }} à {{ $app->quartier }}</span>
                </div>
              </td>

              <td>
                @if($app->categorie === 'louer')
                  <span class="badge-loc">
                    <i class="fa-solid fa-key" style="font-size:8px;"></i> Location
                  </span>
                @else
                  <span class="badge-vnd">
                    <i class="fa-solid fa-tag" style="font-size:8px;"></i> {{ ucfirst($app->categorie) }}
                  </span>
                @endif
              </td>

              <td>
                <span class="price-val">
                  {{ number_format($app->prix, 0, ',', ' ') }}<span class="price-unit"> FCFA</span>
                </span>
              </td>

              <td>
                <span class="view-counter view-badge view-low"
                      data-target="{{ (int)$app->views }}"
                      data-started="false">
                  <i class="fa-solid fa-eye"></i> 0
                </span>
              </td>

              <td>
                @if($app->statut)
                  <span class="status-txt" style="color:var(--gr);">
                    <span class="dot-on"></span>Actif
                  </span>
                @else
                  <span class="status-txt" style="color:var(--ink4);">
                    <span class="dot-off"></span>Inactif
                  </span>
                @endif
              </td>

              <td style="text-align:center;">
                <div class="dropdown act-drop">
                  <button class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                  </button>
                  <ul class="dropdown-menu act-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item i-view link-loader" href="{{ route('appartement.detail', $app->id) }}">
                        <i class="fa-solid fa-eye"></i> Voir les détails
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item i-edit link-loader" href="{{ route('appartement.mod', $app->id) }}">
                        <i class="fa-solid fa-pen-to-square"></i> Modifier
                      </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <a href="#" class="dropdown-item i-toggle {{ $app->statut ? '' : 'off' }}"
                         data-bs-toggle="modal" data-bs-target="#toggleModal{{ $app->id }}">
                        <i class="fa-solid {{ $app->statut ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                        {{ $app->statut ? 'Désactiver' : 'Réactiver' }}
                      </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <a href="#" class="dropdown-item i-del"
                         data-bs-toggle="modal" data-bs-target="#deleteModal{{ $app->id }}">
                        <i class="fa-solid fa-trash"></i> Supprimer
                      </a>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>{{-- /page-body --}}
</div>{{-- /main --}}

{{-- ════════ MODALS ════════ --}}
@foreach($appartements as $app)

<div class="modal fade" id="deleteModal{{ $app->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center py-4">
        <div class="confirm-ico danger"><i class="fa-solid fa-trash-can"></i></div>
        <h6>Supprimer l'annonce ?</h6>
        <p>Action <strong>irréversible</strong>. L'annonce <strong>{{ $app->quartier }}</strong> sera supprimée définitivement.</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light btn-sm px-4" data-bs-dismiss="modal"
                style="border-radius:8px;font-family:'Inter',sans-serif;font-weight:600;">
          Annuler
        </button>
        <form action="{{ route('appartements.destroy', $app->id) }}" method="POST">
          @csrf @method('DELETE')
          <button type="submit" class="btn btn-danger btn-sm px-4"
                  style="border-radius:8px;font-family:'Inter',sans-serif;font-weight:700;">
            <i class="fa-solid fa-trash me-1"></i> Supprimer
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="toggleModal{{ $app->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center py-4">
        <div class="confirm-ico {{ $app->statut ? 'warning' : 'success' }}">
          <i class="fa-solid {{ $app->statut ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
        </div>
        <h6>{{ $app->statut ? 'Désactiver cette annonce ?' : 'Réactiver cette annonce ?' }}</h6>
        <p>
          @if($app->statut)
            L'annonce ne sera plus visible par les visiteurs.
          @else
            L'annonce sera à nouveau visible par les visiteurs.
          @endif
        </p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light btn-sm px-4" data-bs-dismiss="modal"
                style="border-radius:8px;font-family:'Inter',sans-serif;font-weight:600;">
          Annuler
        </button>
        <form action="{{ route('appartement.toggleStatut', $app->id) }}" method="POST">
          @csrf @method('PATCH')
          <button type="submit"
                  class="btn btn-sm px-4 {{ $app->statut ? 'btn-warning' : 'btn-success' }}"
                  style="border-radius:8px;font-family:'Inter',sans-serif;font-weight:700;">
            {{ $app->statut ? 'Désactiver' : 'Réactiver' }}
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

@endforeach

{{-- Modal paiement --}}
@if(session('paiement_required'))
<div class="modal fade show" id="paiementModal" tabindex="-1" style="display:block;" aria-modal="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fa-solid fa-credit-card me-2" style="color:var(--amber);"></i>Paiement requis
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center py-4">
        <p style="font-size:.82rem;color:var(--ink3);">
          Votre annonce a expiré <strong>({{ session('duree') }})</strong>
        </p>
        <div style="font-size:1.7rem;font-weight:800;font-family:'JetBrains Mono',monospace;color:var(--gr);margin:13px 0;">
          {{ number_format(session('montant'),0,',',' ') }}
          <span style="font-size:.95rem;font-weight:500;color:var(--ink3);">FCFA</span>
        </div>
        <kkiapay-widget
          amount="{{ session('montant') }}"
          key="a7f1e5c0652811efbf02478c5adba4b8"
          sandbox="true"
          callback="{{ route('paiement.success', ['appartementId' => session('appartement_id')]) }}">
        </kkiapay-widget>
      </div>
    </div>
  </div>
</div>
<script>document.body.classList.add('modal-open');</script>
@endif

{{-- TOASTS --}}
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:2000;">
  @if(session('success'))
  <div class="toast align-items-center border-0 show" role="alert"
       style="background:var(--gr);border-radius:13px!important;">
    <div class="d-flex">
      <div class="toast-body text-white">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
  @endif
  @if(session('error'))
  <div class="toast align-items-center text-bg-danger border-0 show" role="alert"
       style="border-radius:13px!important;">
    <div class="d-flex">
      <div class="toast-body text-white">
        <i class="fa-solid fa-circle-xmark me-2"></i>{{ session('error') }}
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
  @endif
</div>

{{-- SCRIPTS --}}
<script src="https://cdn.kkiapay.me/k.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
/* ── Sidebar ── */
function isMobile() { return window.innerWidth <= 991; }

function toggleSidebar() {
  var sb = document.getElementById('sidebar');
  var mn = document.getElementById('main');
  var ov = document.getElementById('sbOverlay');
  if (isMobile()) {
    var open = sb.classList.toggle('mobile-open');
    ov.style.display = open ? 'block' : 'none';
  } else {
    sb.classList.toggle('collapsed');
    mn.classList.toggle('shifted');
  }
}

function closeSidebar() {
  document.getElementById('sidebar').classList.remove('mobile-open');
  document.getElementById('sbOverlay').style.display = 'none';
}

window.addEventListener('resize', function () {
  if (!isMobile()) {
    document.getElementById('sidebar').classList.remove('mobile-open');
    document.getElementById('sbOverlay').style.display = 'none';
  }
});

/* ── DataTable ── */
$(document).ready(function () {
  $('#dataTable').DataTable({
    pageLength: 10,
    order: [],
    responsive: true,
    language: {
      lengthMenu:  'Afficher _MENU_ lignes',
      info:        '_START_ à _END_ sur _TOTAL_',
      infoEmpty:   'Aucune ligne',
      zeroRecords: 'Aucun résultat',
      search:      'Rechercher :',
      paginate:    { previous: '‹', next: '›' }
    }
  });
});

/* ── Link loader ── */
document.querySelectorAll('.link-loader').forEach(function (link) {
  link.addEventListener('click', function () {
    var ico = this.querySelector('i');
    if (ico) ico.className = 'fa-solid fa-spinner fa-spin';
    this.classList.add('loading');
  });
});

/* ── Toasts ── */
document.querySelectorAll('.toast').forEach(function (el) {
  new bootstrap.Toast(el, { delay: 4500 }).show();
});

/* ── View counter animé ── */
var vcObs = new IntersectionObserver(function (entries) {
  entries.forEach(function (entry) {
    if (!entry.isIntersecting) return;
    var el = entry.target;
    if (el.dataset.started === 'true') return;
    el.dataset.started = 'true';

    var target = parseInt(el.dataset.target) || 0;

    function applyClass(v) {
      el.classList.remove('view-low', 'view-medium', 'view-high', 'view-viral');
      var icon = 'fa-eye';
      if      (v < 50)   { el.classList.add('view-low');    }
      else if (v < 200)  { el.classList.add('view-medium'); }
      else if (v < 1000) { el.classList.add('view-high');   icon = 'fa-fire'; }
      else               { el.classList.add('view-viral');  icon = 'fa-rocket'; }
      el.innerHTML = '<i class="fa-solid ' + icon + '"></i> ' + v.toLocaleString('fr-FR');
    }

    (function run() {
      var cur = 0;
      applyClass(0);
      var steps = Math.max(40, Math.min(80, target));
      var inc   = Math.ceil(target / steps) || 1;
      var iv = setInterval(function () {
        cur = Math.min(cur + inc, target);
        applyClass(cur);
        if (cur >= target) {
          clearInterval(iv);
          if (target > 0) setTimeout(run, 6000);
        }
      }, 26);
    })();
  });
}, { threshold: 0.4 });

document.querySelectorAll('.view-counter').forEach(function (el) { vcObs.observe(el); });
</script>
</body>
</html>