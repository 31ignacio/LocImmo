@extends('layouts.master')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }

:root {
    --ink:      #111827;
    --ink2:     #374151;
    --ink3:     #6B7280;
    --ink4:     #9CA3AF;
    --border:   #E5E7EB;
    --border2:  #F3F4F6;
    --bg:       #F9FAFB;
    --white:    #FFFFFF;
    --accent:   #FF385C;
    --accent2:  #E31C5F;
    --green:    #059669;
    --green-lt: #ECFDF5;
    --green-bd: #A7F3D0;
    --red:      #DC2626;
    --red-lt:   #FEF2F2;
    --red-bd:   #FECACA;
    --blue:     #2563EB;
    --blue-lt:  #EFF6FF;
    --blue-bd:  #BFDBFE;
    --amber:    #D97706;
    --amber-lt: #FFFBEB;
    --amber-bd: #FDE68A;
    --r:        12px;
    --r-lg:     16px;
    --r-xl:     20px;
    --sh:       0 1px 2px rgba(0,0,0,.06), 0 4px 12px rgba(0,0,0,.05);
    --sh-lg:    0 2px 4px rgba(0,0,0,.06), 0 8px 24px rgba(0,0,0,.09);
}

.ent-wrap {
    font-family: 'Outfit', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    padding: 32px 0 80px;
    color: var(--ink);
    -webkit-font-smoothing: antialiased;
}
.ent-wrap .container { max-width: 1200px; }

/* ════ HEADER PAGE ════ */
.page-hd {
    display: flex; align-items: flex-start;
    justify-content: space-between; flex-wrap: wrap;
    gap: 16px; margin-bottom: 28px;
}
.page-hd-left h1 {
    font-size: 26px; font-weight: 800; color: var(--ink);
    margin: 0 0 4px; letter-spacing: -.03em;
}
.page-hd-left p { font-size: 14px; color: var(--ink3); margin: 0; font-weight: 400; }

/* ════ KPI GRID ════ */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px; margin-bottom: 28px;
}
.kpi-card {
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: var(--r-xl); padding: 20px 22px;
    box-shadow: var(--sh); transition: all .2s;
    display: flex; align-items: center; gap: 16px;
    min-width: 0;
}
.kpi-card:hover { transform: translateY(-3px); box-shadow: var(--sh-lg); border-color: var(--ink3); }
.kpi-ico {
    width: 48px; height: 48px; border-radius: var(--r-lg);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.kpi-ico.total  { background: var(--blue-lt);  color: var(--blue); }
.kpi-ico.active { background: var(--green-lt); color: var(--green); }
.kpi-ico.inact  { background: var(--red-lt);   color: var(--red); }
.kpi-ico.new    { background: var(--amber-lt); color: var(--amber); }
.kpi-val { font-size: 28px; font-weight: 800; color: var(--ink); line-height: 1; letter-spacing: -.04em; }
.kpi-lbl { font-size: 12px; color: var(--ink3); font-weight: 500; margin-top: 3px; text-transform: uppercase; letter-spacing: .05em; white-space: nowrap; }

/* ════ MAIN CARD ════ */
.main-card {
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: var(--r-xl); box-shadow: var(--sh); overflow: hidden;
}

/* ════ TOOLBAR ════ */
.card-toolbar {
    padding: 18px 24px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px; background: var(--white);
}
.toolbar-left { display: flex; align-items: center; gap: 10px; }
.toolbar-title {
    font-size: 15px; font-weight: 700; color: var(--ink);
    display: flex; align-items: center; gap: 8px;
}
.toolbar-badge {
    background: var(--ink); color: var(--white);
    padding: 2px 10px; border-radius: 30px;
    font-size: 11px; font-weight: 700;
}
.toolbar-search {
    display: flex; align-items: center; gap: 8px;
    background: var(--bg); border: 1.5px solid var(--border);
    border-radius: var(--r); padding: 8px 14px;
    transition: all .18s;
    width: 100%; max-width: 260px;
}
.toolbar-search:focus-within {
    border-color: var(--ink); background: var(--white);
    box-shadow: 0 0 0 3px rgba(17,24,39,.06);
}
.toolbar-search i { color: var(--ink4); font-size: 13px; flex-shrink: 0; }
.toolbar-search input {
    border: none; background: transparent; outline: none;
    font-size: 13.5px; font-family: 'Outfit', sans-serif;
    color: var(--ink); width: 100%; min-width: 0;
}
.toolbar-search input::placeholder { color: var(--ink4); }

/* ════ TABLE (desktop) ════ */
.ent-table { width: 100%; border-collapse: collapse; }
.ent-table th {
    padding: 11px 20px; font-size: 10.5px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .07em;
    color: var(--ink3); background: var(--bg);
    border-bottom: 1px solid var(--border);
    white-space: nowrap; text-align: left;
}
.ent-table td {
    padding: 14px 20px; vertical-align: middle;
    border-bottom: 1px solid var(--border2);
    font-size: 14px; color: var(--ink2);
}
.ent-table tbody tr { transition: background .12s; }
.ent-table tbody tr:last-child td { border-bottom: none; }
.ent-table tbody tr:hover td { background: var(--bg); }

/* Cellule agent */
.agent-cell { display: flex; align-items: center; gap: 12px; min-width: 0; }
.agent-av {
    width: 40px; height: 40px; border-radius: 50%;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 700; color: #fff;
    flex-shrink: 0; letter-spacing: .01em;
}
.agent-name  { font-size: 14px; font-weight: 600; color: var(--ink); display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.agent-email { font-size: 12px; color: var(--ink4); display: block; margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

/* Localisation */
.loc-val { font-size: 13.5px; font-weight: 500; color: var(--ink2); }
.loc-arr  { font-size: 11px; color: var(--ink4); display: block; margin-top: 1px; }

/* Téléphone */
.tel-val { display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 500; }
.tel-val i { color: var(--ink4); font-size: 11px; }

/* Date */
.date-main { font-size: 13px; font-weight: 600; color: var(--ink2); display: block; }
.date-rel  { font-size: 11px; color: var(--ink4); display: block; margin-top: 2px; }

/* Status badge */
.status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 30px;
    font-size: 11.5px; font-weight: 700; white-space: nowrap;
}
.sb-active { background: var(--green-lt); color: var(--green); border: 1px solid var(--green-bd); }
.sb-inact  { background: var(--red-lt);   color: var(--red);   border: 1px solid var(--red-bd); }
.sb-dot    { width: 6px; height: 6px; border-radius: 50%; background: currentColor; flex-shrink: 0; }

/* Actions */
.act-group { display: inline-flex; align-items: center; gap: 4px; }
.act-btn {
    width: 32px; height: 32px; border-radius: 8px; border: 1.5px solid var(--border);
    background: var(--white); display: inline-flex; align-items: center; justify-content: center;
    font-size: 12px; cursor: pointer; transition: all .15s; text-decoration: none;
    color: var(--ink3); font-family: 'Outfit', sans-serif;
}
.act-btn:hover { transform: translateY(-1px); }
.act-btn.view:hover       { background: var(--blue-lt);  color: var(--blue);  border-color: var(--blue-bd); }
.act-btn.toggle-off:hover { background: var(--red-lt);   color: var(--red);   border-color: var(--red-bd); }
.act-btn.toggle-on:hover  { background: var(--green-lt); color: var(--green); border-color: var(--green-bd); }
.act-btn.delete:hover     { background: var(--red-lt);   color: var(--red);   border-color: var(--red-bd); }

/* ════ ALERTE ════ */
.ent-alert {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: var(--r);
    font-size: 13.5px; font-weight: 600; margin-bottom: 20px;
    border: 1px solid var(--green-bd); background: var(--green-lt);
    color: var(--green);
    animation: slideDown .3s ease both;
}
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ════ EMPTY ════ */
.ent-empty {
    text-align: center; padding: 60px 24px; color: var(--ink4);
}
.ent-empty-ring {
    width: 72px; height: 72px; border-radius: 50%;
    background: var(--bg); border: 2px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px; font-size: 26px; color: var(--ink4);
}
.ent-empty h3 { font-size: 16px; font-weight: 700; color: var(--ink2); margin: 0 0 6px; }
.ent-empty p  { font-size: 14px; color: var(--ink4); margin: 0; }

/* ════ PAGINATION ════ */
.card-footer {
    padding: 14px 24px; border-top: 1px solid var(--border);
    background: var(--bg); display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: 10px;
}
.footer-info { font-size: 13px; color: var(--ink3); font-weight: 500; }

/* ════════════════════════════════════════════════
   RESPONSIVE — le tableau devient des cartes empilées
   ════════════════════════════════════════════════ */
@media (max-width: 992px) {
    .kpi-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 860px) {

    .ent-wrap { padding: 20px 0 60px; }
    .page-hd-left h1 { font-size: 21px; }

    .card-toolbar { flex-direction: column; align-items: stretch; }
    .toolbar-search { max-width: none; }

    /* Le tableau desktop passe en mode "cartes" */
    .ent-table thead { display: none; }
    .ent-table, .ent-table tbody, .ent-table tr, .ent-table td { display: block; width: 100%; }

    .ent-table tbody tr {
        border: 1px solid var(--border2);
        border-radius: var(--r-lg);
        margin: 12px;
        overflow: hidden;
        box-shadow: var(--sh);
    }
    .ent-table tbody tr:hover td { background: transparent; }

    .ent-table td {
        padding: 10px 16px;
        border-bottom: 1px solid var(--border2);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        text-align: right;
    }
    .ent-table td:last-child { border-bottom: none; }

    /* Label mobile généré via attribut data-label */
    .ent-table td::before {
        content: attr(data-label);
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--ink4);
        flex-shrink: 0;
    }

    /* La cellule "Entreprise" garde son alignement horizontal naturel (avatar+nom) */
    .ent-table td.cell-agent {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
        gap: 4px;
    }
    .ent-table td.cell-agent::before { margin-bottom: 2px; }
    .agent-cell { width: 100%; }

    .ent-table td.cell-loc,
    .ent-table td.cell-date { text-align: right; }
    .loc-val, .loc-arr, .date-main, .date-rel { text-align: right; }

    .ent-table td.cell-actions { justify-content: flex-end; }
    .ent-table td.cell-actions::before { display: none; }

    .card-footer { flex-direction: column; align-items: stretch; text-align: center; }
}

@media (max-width: 480px) {
    .kpi-grid { grid-template-columns: 1fr; }
    .kpi-card { padding: 16px 18px; }
}

/* ════════════════════════════════════════════════
   MODALES (confirmation + détail)
   ════════════════════════════════════════════════ */
.ent-modal-overlay {
    display: none; position: fixed; inset: 0; z-index: 9999;
    background: rgba(17,24,39,.55); backdrop-filter: blur(3px);
    align-items: center; justify-content: center; padding: 18px;
}
.ent-modal-overlay.open { display: flex; animation: entModalFade .18s ease; }
@keyframes entModalFade { from{opacity:0} to{opacity:1} }

.ent-modal {
    background: var(--white); border-radius: var(--r-xl);
    width: 100%; max-width: 420px; overflow: hidden;
    box-shadow: 0 24px 64px rgba(0,0,0,.25);
    transform: translateY(16px) scale(.97); opacity: 0;
    transition: transform .25s cubic-bezier(.34,1.56,.64,1), opacity .25s ease;
}
.ent-modal-overlay.open .ent-modal { transform: none; opacity: 1; }
.ent-modal.detail-modal { max-width: 460px; }

.ent-modal-head {
    padding: 20px 22px 16px; display: flex; align-items: center; gap: 13px;
    border-bottom: 1px solid var(--border2);
}
.ent-modal-ico {
    width: 42px; height: 42px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; flex-shrink: 0;
}
.ent-modal-ico.warn { background: var(--red-lt); color: var(--red); border: 1.5px solid var(--red-bd); }
.ent-modal-ico.ok   { background: var(--green-lt); color: var(--green); border: 1.5px solid var(--green-bd); }
.ent-modal-ico.info { background: var(--blue-lt); color: var(--blue); border: 1.5px solid var(--blue-bd); }
.ent-modal-head-txt { flex: 1; min-width: 0; }
.ent-modal-title { font-size: 15px; font-weight: 800; color: var(--ink); margin: 0; }
.ent-modal-sub { font-size: 12px; color: var(--ink4); margin: 2px 0 0; }
.ent-modal-close {
    width: 30px; height: 30px; border-radius: 8px; border: 1.5px solid var(--border);
    background: var(--bg); color: var(--ink3); display: flex; align-items: center; justify-content: center;
    font-size: 12px; cursor: pointer; transition: all .15s; flex-shrink: 0;
}
.ent-modal-close:hover { background: var(--red-lt); border-color: var(--red-bd); color: var(--red); }

.ent-modal-body { padding: 20px 22px; }
.ent-modal-body p { font-size: 13.5px; color: var(--ink2); line-height: 1.6; margin: 0; }
.ent-modal-body p strong { color: var(--ink); }

.ent-modal-actions {
    padding: 0 22px 22px; display: flex; gap: 10px;
}
.emb-cancel {
    flex: 1; padding: 11px; border-radius: var(--r); border: 1.5px solid var(--border);
    background: var(--white); color: var(--ink2); font-size: 13.5px; font-weight: 700;
    cursor: pointer; font-family: 'Outfit', sans-serif; transition: all .15s;
}
.emb-cancel:hover { background: var(--bg); }
.emb-confirm {
    flex: 1.3; padding: 11px; border-radius: var(--r); border: none;
    color: #fff; font-size: 13.5px; font-weight: 700; cursor: pointer;
    font-family: 'Outfit', sans-serif; transition: all .15s;
    display: flex; align-items: center; justify-content: center; gap: 7px;
}
.emb-confirm.danger { background: var(--red); box-shadow: 0 6px 18px rgba(220,38,38,.28); }
.emb-confirm.danger:hover { background: #b91c1c; transform: translateY(-1px); }
.emb-confirm.success { background: var(--green); box-shadow: 0 6px 18px rgba(5,150,105,.28); }
.emb-confirm.success:hover { background: #047857; transform: translateY(-1px); }
.emb-confirm:disabled,
.emb-cancel:disabled { opacity: .65; cursor: not-allowed; transform: none !important; }

/* Spinner */
.emb-spin {
    width: 14px; height: 14px; border-radius: 50%;
    border: 2px solid rgba(255,255,255,.4); border-top-color: #fff;
    animation: embSpin .6s linear infinite; flex-shrink: 0;
}
@keyframes embSpin { to { transform: rotate(360deg); } }

/* ── Détail modal ── */
.detail-top {
    display: flex; align-items: center; gap: 14px;
    padding: 20px 22px; background: var(--bg);
    border-bottom: 1px solid var(--border2);
}
.detail-av {
    width: 58px; height: 58px; border-radius: 16px;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; font-weight: 800; color: #fff; flex-shrink: 0;
}
.detail-top-txt { flex: 1; min-width: 0; }
.detail-name { font-size: 16px; font-weight: 800; color: var(--ink); margin: 0 0 3px; }
.detail-status { margin: 0; }

.detail-list { padding: 6px 22px 20px; }
.dl-row {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 12px 0; border-bottom: 1px dashed var(--border2);
}
.dl-row:last-child { border-bottom: none; }
.dl-ico {
    width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
    background: var(--blue-lt); color: var(--blue); border: 1.5px solid var(--blue-bd);
    display: flex; align-items: center; justify-content: center; font-size: 13px;
}
.dl-txt { min-width: 0; flex: 1; }
.dl-lbl { font-size: 10.5px; font-weight: 700; color: var(--ink4); text-transform: uppercase; letter-spacing: .06em; display: block; margin-bottom: 3px; }
.dl-val { font-size: 14px; font-weight: 600; color: var(--ink); word-break: break-word; }
</style>


<div class="ent-wrap">
<div class="container">

    {{-- ════ ALERTE (succès activation/désactivation) ════ --}}
    @if(session('success'))
    <div class="ent-alert">
        <i class="fa fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    {{-- ════ HEADER ════ --}}
    <div class="page-hd">
        <div class="page-hd-left">
            <h1>Gestion des proprietaires</h1>
            <p>Tous les propriétaires inscrits sur la plateforme</p>
        </div>
    </div>

    {{-- ════ KPI ════ --}}
    @php
        $totalItems  = $entreprises->total();
        $actifs      = $entreprises->getCollection()->filter(fn($e) => $e->user->estActive)->count();
        $inactifs    = $entreprises->getCollection()->filter(fn($e) => !$e->user->estActive)->count();
        $nouveaux    = $entreprises->getCollection()->filter(fn($e) => $e->created_at->gte(now()->subDays(30)))->count();
    @endphp
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-ico total"><i class="fa fa-building"></i></div>
            <div>
                <div class="kpi-val">{{ $totalItems }}</div>
                <div class="kpi-lbl">Total proprietaire</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-ico active"><i class="fa fa-check-circle"></i></div>
            <div>
                <div class="kpi-val">{{ $actifs }}</div>
                <div class="kpi-lbl">Comptes actifs</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-ico inact"><i class="fa fa-ban"></i></div>
            <div>
                <div class="kpi-val">{{ $inactifs }}</div>
                <div class="kpi-lbl">Comptes inactifs</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-ico new"><i class="fa fa-star"></i></div>
            <div>
                <div class="kpi-val">{{ $nouveaux }}</div>
                <div class="kpi-lbl">Nouveaux (30j)</div>
            </div>
        </div>
    </div>

    {{-- ════ TABLE CARD ════ --}}
    <div class="main-card">

        {{-- Toolbar --}}
        <div class="card-toolbar">
            <div class="toolbar-left">
                <span class="toolbar-title">
                    <i class="fa fa-list" style="color:var(--ink3)"></i>
                    Liste des utilisateurs inscrits sur la plateforme LocImmo
                    <span class="toolbar-badge">{{ $totalItems }}</span>
                </span>
            </div>
            <div class="toolbar-search">
                <i class="fa fa-search"></i>
                <input type="text" id="searchInput" placeholder="Rechercher un proprietaire...">
            </div>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto">
            <table class="ent-table" id="entTable">
                <thead>
                    <tr>
                        <th>Entreprise / Propriétaire</th>
                        <th>Localisation</th>
                        <th>Téléphone</th>
                        <th>Inscrit le</th>
                        <th>Statut</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entreprises as $entreprise)
                    @php
                        $initials = strtoupper(substr($entreprise->nom ?? 'E', 0, 1) . substr($entreprise->prenom ?? '', 0, 1));
                        $isActive = $entreprise->user->estActive;
                        $fullName = trim($entreprise->nom.' '.$entreprise->prenom);
                    @endphp
                    <tr>
                        {{-- Entreprise --}}
                        <td class="cell-agent" data-label="Propriétaire">
                            <div class="agent-cell">
                                <div class="agent-av">{{ $initials }}</div>
                                <div style="min-width:0">
                                    <span class="agent-name">{{ $fullName }}</span>
                                    <span class="agent-email">{{ $entreprise->user->email ?? '—' }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Localisation --}}
                        <td class="cell-loc" data-label="Localisation">
                            <div>
                                <span class="loc-val">{{ $entreprise->ville }}</span>
                                <span class="loc-arr">{{ $entreprise->quatier }}</span>
                            </div>
                        </td>

                        {{-- Téléphone --}}
                        <td data-label="Téléphone">
                            <span class="tel-val">
                                <i class="fa fa-phone"></i>
                                {{ $entreprise->telephone }}
                            </span>
                        </td>

                        {{-- Date --}}
                        <td class="cell-date" data-label="Inscrit le">
                            <div>
                                <span class="date-main">{{ $entreprise->created_at->format('d/m/Y') }}</span>
                                <span class="date-rel">{{ $entreprise->created_at->diffForHumans() }}</span>
                            </div>
                        </td>

                        {{-- Statut --}}
                        <td data-label="Statut">
                            @if($isActive)
                                <span class="status-badge sb-active">
                                    <span class="sb-dot"></span> Actif
                                </span>
                            @else
                                <span class="status-badge sb-inact">
                                    <span class="sb-dot"></span> Inactif
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="cell-actions" data-label="Actions">
                            <div class="act-group">

                                {{-- Bouton "Voir" → ouvre la modale détail (pas de rechargement) --}}
                                <button type="button" class="act-btn view" title="Voir le détail"
                                    onclick="openDetailModal({
                                        initials: '{{ $initials }}',
                                        nom: '{{ addslashes($fullName) }}',
                                        email: '{{ addslashes($entreprise->user->email ?? '—') }}',
                                        telephone: '{{ addslashes($entreprise->telephone ?? '—') }}',
                                        ville: '{{ addslashes($entreprise->ville ?? '—') }}',
                                        quartier: '{{ addslashes($entreprise->quatier ?? '—') }}',
                                        profil: '{{ addslashes($entreprise->profil ?? '—') }}',
                                        date: '{{ $entreprise->created_at->format('d/m/Y à H:i') }}',
                                        actif: {{ $isActive ? 'true' : 'false' }}
                                    })">
                                    <i class="fa fa-eye"></i>
                                </button>

                                {{-- Bouton toggle → ouvre la modale de CONFIRMATION --}}
                                @if($isActive)
                                    <button type="button" class="act-btn toggle-off" title="Désactiver"
                                        onclick="openConfirmModal({
                                            action: '{{ route('entreprise.desactiver', $entreprise->id) }}',
                                            nom: '{{ addslashes($fullName) }}',
                                            type: 'desactiver'
                                        })">
                                        <i class="fa fa-ban"></i>
                                    </button>
                                @else
                                    <button type="button" class="act-btn toggle-on" title="Activer"
                                        onclick="openConfirmModal({
                                            action: '{{ route('entreprise.activer', $entreprise->id) }}',
                                            nom: '{{ addslashes($fullName) }}',
                                            type: 'activer'
                                        })">
                                        <i class="fa fa-check"></i>
                                    </button>
                                @endif

                                {{-- Bouton "Supprimer" → ouvre la modale de confirmation (suppression) --}}
                                <button type="button" class="act-btn delete" title="Supprimer"
                                    onclick="openConfirmModal({
                                        action: '{{ route('entreprise.destroy', $entreprise->id) }}',
                                        nom: '{{ addslashes($fullName) }}',
                                        type: 'supprimer'
                                    })">
                                    <i class="fa fa-trash"></i>
                                </button>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="ent-empty">
                                <div class="ent-empty-ring"><i class="fa fa-building-o"></i></div>
                                <h3>Aucune entreprise trouvée</h3>
                                <p>Les entreprises inscrites apparaîtront ici.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer pagination --}}
        <div class="card-footer">
            <span class="footer-info">
                Affichage {{ $entreprises->firstItem() ?? 0 }} – {{ $entreprises->lastItem() ?? 0 }}
                sur {{ $totalItems }} entreprise(s)
            </span>
            <div>{{ $entreprises->links() }}</div>
        </div>

    </div>

</div>
</div>

{{-- ════════════════════════════════════════════════
     MODALE DE CONFIRMATION (activer / désactiver)
     ════════════════════════════════════════════════ --}}
<div class="ent-modal-overlay" id="confirmModal" onclick="if(event.target===this) closeConfirmModal()">
    <div class="ent-modal">
        <div class="ent-modal-head">
            <div class="ent-modal-ico" id="confirmIco"><i class="fa fa-exclamation-triangle"></i></div>
            <div class="ent-modal-head-txt">
                <p class="ent-modal-title" id="confirmTitle">Confirmer l'action</p>
                <p class="ent-modal-sub">Cette action est réversible</p>
            </div>
            <button type="button" class="ent-modal-close" onclick="closeConfirmModal()"><i class="fa fa-times"></i></button>
        </div>
        <div class="ent-modal-body">
            <p id="confirmText">Êtes-vous sûr de vouloir effectuer cette action ?</p>
        </div>
        <div class="ent-modal-actions">
            <button type="button" class="emb-cancel" onclick="closeConfirmModal()">Annuler</button>
            <form id="confirmForm" method="POST" style="flex:1.3">
                @csrf
                <input type="hidden" name="_method" id="confirmMethod" value="PUT">
                <button type="submit" class="emb-confirm" id="confirmBtn" style="width:100%">
                    <i class="fa fa-check"></i> Confirmer
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════
     MODALE DE DÉTAIL (clic sur l'œil)
     ════════════════════════════════════════════════ --}}
<div class="ent-modal-overlay" id="detailModal" onclick="if(event.target===this) closeDetailModal()">
    <div class="ent-modal detail-modal">

        <div class="ent-modal-head" style="border-bottom:none;padding-bottom:0">
            <div style="flex:1"></div>
            <button type="button" class="ent-modal-close" onclick="closeDetailModal()"><i class="fa fa-times"></i></button>
        </div>

        <div class="detail-top">
            <div class="detail-av" id="detailAv">--</div>
            <div class="detail-top-txt">
                <p class="detail-name" id="detailNom">—</p>
                <p class="detail-status" id="detailStatus"></p>
            </div>
        </div>

        <div class="detail-list">
            <div class="dl-row">
                <div class="dl-ico"><i class="fa fa-id-badge"></i></div>
                <div class="dl-txt">
                    <span class="dl-lbl">Profil</span>
                    <span class="dl-val" id="detailProfil">—</span>
                </div>
            </div>
            <div class="dl-row">
                <div class="dl-ico"><i class="fa fa-envelope"></i></div>
                <div class="dl-txt">
                    <span class="dl-lbl">Email</span>
                    <span class="dl-val" id="detailEmail">—</span>
                </div>
            </div>
            <div class="dl-row">
                <div class="dl-ico"><i class="fa fa-phone"></i></div>
                <div class="dl-txt">
                    <span class="dl-lbl">Téléphone</span>
                    <span class="dl-val" id="detailTel">—</span>
                </div>
            </div>
            <div class="dl-row">
                <div class="dl-ico"><i class="fa fa-map-marker"></i></div>
                <div class="dl-txt">
                    <span class="dl-lbl">Localisation</span>
                    <span class="dl-val" id="detailLoc">—</span>
                </div>
            </div>
            <div class="dl-row">
                <div class="dl-ico"><i class="fa fa-calendar"></i></div>
                <div class="dl-txt">
                    <span class="dl-lbl">Inscrit le</span>
                    <span class="dl-val" id="detailDate">—</span>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// ═══════════════════════════════════════════
// RECHERCHE LIVE
// ═══════════════════════════════════════════
document.getElementById('searchInput')?.addEventListener('input', function() {
    var q = this.value.toLowerCase();
    document.querySelectorAll('#entTable tbody tr').forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});

// ═══════════════════════════════════════════
// MODALE CONFIRMATION (activer / désactiver)
// ═══════════════════════════════════════════
function openConfirmModal(opts) {
    var isActivation = opts.type === 'activer';
    var isDelete = opts.type === 'supprimer';

    var icoEl = document.getElementById('confirmIco');
    var subEl = document.querySelector('#confirmModal .ent-modal-sub');
    var btn = document.getElementById('confirmBtn');

    if (isDelete) {
        icoEl.className = 'ent-modal-ico warn';
        icoEl.innerHTML = '<i class="fa fa-trash"></i>';

        document.getElementById('confirmTitle').textContent = 'Supprimer ce compte ?';
        subEl.textContent = 'Cette action est irréversible';

        document.getElementById('confirmText').innerHTML = 'Vous êtes sur le point de <strong>supprimer définitivement</strong> le compte de <strong>' + opts.nom + '</strong>. Toutes ses données (annonces, informations) seront perdues.';

        btn.className = 'emb-confirm danger';
        btn.innerHTML = '<i class="fa fa-trash"></i> Oui, supprimer';

        document.getElementById('confirmMethod').value = 'DELETE';
    } else {
        icoEl.className = 'ent-modal-ico ' + (isActivation ? 'ok' : 'warn');
        icoEl.innerHTML = isActivation
            ? '<i class="fa fa-check-circle"></i>'
            : '<i class="fa fa-exclamation-triangle"></i>';

        document.getElementById('confirmTitle').textContent = isActivation
            ? 'Activer ce compte ?'
            : 'Désactiver ce compte ?';
        subEl.textContent = 'Cette action est réversible';

        document.getElementById('confirmText').innerHTML = isActivation
            ? 'Vous êtes sur le point d\'activer le compte de <strong>' + opts.nom + '</strong>. Il pourra à nouveau se connecter et publier des annonces.'
            : 'Vous êtes sur le point de désactiver le compte de <strong>' + opts.nom + '</strong>. Il ne pourra plus se connecter ni publier d\'annonces tant qu\'il ne sera pas réactivé.';

        btn.className = 'emb-confirm ' + (isActivation ? 'success' : 'danger');
        btn.innerHTML = isActivation
            ? '<i class="fa fa-check"></i> Oui, activer'
            : '<i class="fa fa-ban"></i> Oui, désactiver';

        document.getElementById('confirmMethod').value = 'PUT';
    }

    document.getElementById('confirmForm').setAttribute('action', opts.action);

    // Réinitialise l'état du bouton (utile si une modale précédente est restée en chargement)
    btn.disabled = false;
    document.querySelector('#confirmModal .emb-cancel').disabled = false;
    btn.dataset.originalHtml = btn.innerHTML;

    document.getElementById('confirmModal').classList.add('open');
}
function closeConfirmModal() {
    document.getElementById('confirmModal').classList.remove('open');
}

// ═══════════════════════════════════════════
// LOADER sur soumission (activer / désactiver)
// ═══════════════════════════════════════════
document.getElementById('confirmForm')?.addEventListener('submit', function() {
    var btn = document.getElementById('confirmBtn');
    var cancelBtn = document.querySelector('#confirmModal .emb-cancel');

    btn.dataset.originalHtml = btn.dataset.originalHtml || btn.innerHTML;
    btn.disabled = true;
    cancelBtn.disabled = true;
    btn.innerHTML = '<span class="emb-spin"></span> Traitement...';
});

// ═══════════════════════════════════════════
// MODALE DÉTAIL (œil)
// ═══════════════════════════════════════════
function openDetailModal(d) {
    document.getElementById('detailAv').textContent = d.initials;
    document.getElementById('detailNom').textContent = d.nom;
    document.getElementById('detailEmail').textContent = d.email;
    document.getElementById('detailTel').textContent = d.telephone;
    document.getElementById('detailLoc').textContent = d.ville + (d.quartier && d.quartier !== '—' ? ' — ' + d.quartier : '');
    document.getElementById('detailDate').textContent = d.date;
    document.getElementById('detailProfil').textContent = d.profil;

    var statusEl = document.getElementById('detailStatus');
    statusEl.innerHTML = d.actif
        ? '<span class="status-badge sb-active"><span class="sb-dot"></span> Actif</span>'
        : '<span class="status-badge sb-inact"><span class="sb-dot"></span> Inactif</span>';

    document.getElementById('detailModal').classList.add('open');
}
function closeDetailModal() {
    document.getElementById('detailModal').classList.remove('open');
}

// Fermer les modales avec Échap
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeConfirmModal();
        closeDetailModal();
    }
});
</script>

@endsection