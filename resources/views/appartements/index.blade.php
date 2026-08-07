@extends('layouts.master')
@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

:root {
    --gr:      #16a34a;
    --gr-dk:   #15803d;
    --gr-lt:   #f0fdf4;
    --gr-b:    #bbf7d0;
    --gr-glow: rgba(22,163,74,.22);
    --red:     #dc2626;
    --amber:   #d97706;
    --bg:      #F7F7F7;
    --bg2:     #EFEFEF;
    --card:    #FFFFFF;
    --ink:     #111827;
    --ink2:    #374151;
    --ink3:    #6B7280;
    --bord:    #E5E7EB;
    --bord2:   #F3F4F6;
    --r:       12px;
    --r-lg:    18px;
    --r-xl:    22px;
    --sh:      0 1px 3px rgba(0,0,0,.05), 0 4px 16px rgba(0,0,0,.06);
    --sh-hov:  0 8px 32px rgba(0,0,0,.10), 0 2px 8px rgba(0,0,0,.06);
    --ease:    cubic-bezier(.16,1,.3,1);
}

*,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }
html { scroll-behavior:smooth; }
body {
    font-family:'Inter',sans-serif;
    background:var(--bg);
    color:var(--ink);
    -webkit-font-smoothing:antialiased;
}
.container { max-width:1380px; margin:0 auto; padding:0 24px; }

/* ══════════════════════════════════
   HERO
══════════════════════════════════ */
.page-hero {
    position:relative;
    padding:52px 0 90px;
    overflow:hidden;
    min-height:260px;
    display:flex;
    align-items:center;
}
.page-hero-bg {
    position:absolute; inset:0; z-index:0;
}
.page-hero-bg img {
    width:100%; height:100%;
    object-fit:cover;
    object-position:center 40%;
    display:block;
    /* ← dézoom : scale down + brightness moins sombre */
    transform:scale(1.0);
    filter:brightness(.72) saturate(.95);
    transition:transform 8s ease;
}
.page-hero-overlay {
    position:absolute; inset:0; z-index:1;
    background:linear-gradient(
        105deg,
        rgba(11,25,41,.72) 0%,
        rgba(11,25,41,.45) 40%,
        rgba(11,25,41,.15) 70%,
        transparent 100%
    );
}
.page-hero-deco {
    position:absolute; left:0; top:0; bottom:0;
    width:5px; z-index:3;
    background:var(--gr);
}
.hero-inner {
    position:relative; z-index:3;
    max-width:560px;
}
.hero-eyebrow {
    display:inline-flex; align-items:center; gap:10px;
    font-size:10.5px; font-weight:700; letter-spacing:.13em;
    text-transform:uppercase; color:#4ade80;
    margin-bottom:12px;
}
.hero-eyebrow-line { width:22px; height:2px; background:#4ade80; border-radius:2px; flex-shrink:0; }
.hero-h1 {
    font-size:clamp(1.6rem,3.5vw,2.6rem);
    font-weight:800; line-height:1.1;
    color:#fff; letter-spacing:-.03em;
    margin-bottom:10px;
}
.hero-h1 em { font-style:normal; color:#4ade80; }
.hero-sub {
    font-size:13.5px; font-weight:400;
    color:rgba(255,255,255,.6); line-height:1.65;
    max-width:440px;
}

/* ══════════════════════════════════
   SEARCH PANEL
══════════════════════════════════ */
.search-wrap {
    margin-top:-60px;
    position:relative; z-index:20;
    margin-bottom:40px;
}
.search-panel {
    background:var(--card);
    border-radius:var(--r-xl);
    border:1px solid var(--bord);
    box-shadow:0 20px 64px rgba(0,0,0,.10), 0 4px 16px rgba(0,0,0,.05);
    overflow:hidden;
}
.sp-head {
    display:flex; align-items:center; gap:9px;
    padding:14px 24px 12px;
    border-bottom:1px solid var(--bord2);
}
.sp-head-dot {
    width:7px; height:7px; border-radius:50%;
    background:var(--gr);
    animation:blinkGr 2s ease-in-out infinite;
}
@keyframes blinkGr {
    0%,100%{opacity:1;transform:scale(1);}
    50%{opacity:.35;transform:scale(.6);}
}
.sp-head-title {
    font-size:11px; font-weight:700;
    color:var(--ink3); letter-spacing:.09em;
    text-transform:uppercase;
}
.sp-form { padding:18px 24px 22px; }
.sp-grid-top {
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:12px; margin-bottom:12px;
}
.sp-grid-bottom {
    display:grid;
    grid-template-columns:1fr 1fr auto;
    gap:12px; align-items:end;
}
@media(max-width:1080px){
    .sp-grid-top    { grid-template-columns:repeat(3,1fr); }
    .sp-grid-bottom { grid-template-columns:1fr 1fr 1fr; }
}
@media(max-width:680px){
    .sp-grid-top    { grid-template-columns:1fr 1fr; }
    .sp-grid-bottom { grid-template-columns:1fr 1fr; }
}
@media(max-width:420px){
    .sp-grid-top,.sp-grid-bottom { grid-template-columns:1fr; }
}
.sf-group { display:flex; flex-direction:column; gap:5px; }
.sf-label {
    font-size:10px; font-weight:600; letter-spacing:.08em;
    text-transform:uppercase; color:var(--ink3); padding-left:1px;
}
.sf-inp,.sf-sel {
    height:42px;
    border:1.5px solid var(--bord);
    border-radius:var(--r); padding:0 13px;
    font-size:13px; font-weight:500; color:var(--ink);
    background:var(--bg2); outline:none; width:100%;
    font-family:'Inter',sans-serif;
    transition:border-color .18s,background .18s,box-shadow .18s;
    -webkit-appearance:none;
}
.sf-inp:focus,.sf-sel:focus {
    border-color:var(--gr); background:var(--card);
    box-shadow:0 0 0 3px rgba(22,163,74,.1);
}
.sf-inp::placeholder { color:rgba(100,104,124,.4); }
.qac-wrap { position:relative; }
.qac-list {
    position:absolute; top:calc(100% + 5px); left:0; right:0;
    background:var(--card); border:1.5px solid var(--bord);
    border-radius:var(--r-lg);
    box-shadow:0 8px 32px rgba(0,0,0,.1);
    z-index:200; list-style:none; padding:6px;
    display:none; max-height:190px; overflow-y:auto;
}
.qac-list.open { display:block; }
.qac-item {
    padding:9px 11px; font-size:12.5px; border-radius:9px;
    cursor:pointer; color:var(--ink2);
    display:flex; align-items:center; gap:7px;
    transition:background .1s;
}
.qac-item:hover { background:var(--bg2); }
.qac-item i { color:var(--gr); font-size:10px; }
.btn-search {
    height:42px; padding:0 26px;
    border-radius:var(--r); border:none;
    background:var(--gr); color:#fff;
    font-size:13px; font-weight:600;
    font-family:'Inter',sans-serif;
    cursor:pointer; white-space:nowrap;
    display:inline-flex; align-items:center; gap:7px;
    box-shadow:0 4px 14px var(--gr-glow);
    transition:all .18s;
}
.btn-search:hover { background:var(--gr-dk); transform:translateY(-2px); box-shadow:0 8px 22px rgba(22,163,74,.36); }
.btn-search:disabled { opacity:.55; cursor:not-allowed; transform:none; }
.active-filters {
    padding:10px 24px 13px; border-top:1px solid var(--bord2);
    display:flex; flex-wrap:wrap; gap:6px; align-items:center;
}
.af-label { font-size:10.5px; font-weight:600; color:var(--ink3); margin-right:3px; }
.filter-chip {
    display:inline-flex; align-items:center; gap:4px;
    padding:4px 11px; border-radius:30px;
    background:var(--gr-lt); color:var(--gr);
    border:1px solid rgba(22,163,74,.2);
    font-size:11.5px; font-weight:600;
}
.btn-clear-all {
    margin-left:auto;
    display:inline-flex; align-items:center; gap:5px;
    font-size:11.5px; font-weight:600; color:var(--ink3);
    text-decoration:none !important; padding:4px 11px;
    border-radius:30px; border:1px solid var(--bord);
    background:var(--card); transition:all .15s;
}
.btn-clear-all:hover { color:var(--red); border-color:rgba(220,38,38,.25); }

/* ══════════════════════════════════
   LIST HEADER
══════════════════════════════════ */
.list-head {
    display:flex; align-items:center;
    justify-content:space-between;
    flex-wrap:wrap; gap:12px; margin-bottom:22px;
}
.list-count { font-size:13.5px; font-weight:500; color:var(--ink3); }
.list-count strong {
    font-size:1.4rem; font-weight:800;
    color:var(--ink); margin-right:3px; vertical-align:middle;
}
.sort-row { display:flex; align-items:center; gap:7px; }
.sort-label { font-size:11.5px; color:var(--ink3); font-weight:500; }
.sort-sel {
    height:36px; padding:0 13px;
    border-radius:30px;
    border:1.5px solid var(--bord);
    font-size:12px; font-weight:600;
    background:var(--card); color:var(--ink);
    font-family:'Inter',sans-serif;
    outline:none; cursor:pointer; -webkit-appearance:none;
    box-shadow:var(--sh);
    transition:border-color .18s;
}
.sort-sel:focus { border-color:var(--gr); }

/* ══════════════════════════════════
   PROPERTY GRID
══════════════════════════════════ */
.prop-grid {
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:20px;
}
@media(max-width:1280px){ .prop-grid { grid-template-columns:repeat(3,1fr); } }
@media(max-width:860px) { .prop-grid { grid-template-columns:repeat(2,1fr); gap:14px; } }
@media(max-width:480px) { .prop-grid { grid-template-columns:repeat(2,1fr); gap:10px; } }
@media(max-width:360px) { .prop-grid { grid-template-columns:1fr; } }

/* ══════════════════════════════════
   PROPERTY CARD
══════════════════════════════════ */
.prop-card {
    background:var(--card);
    border-radius:20px;
    overflow:hidden;
    border:1px solid var(--bord);
    box-shadow:0 2px 12px rgba(0,0,0,.06);
    display:flex; flex-direction:column;
    opacity:0; transform:translateY(14px);
    transition:opacity .44s var(--ease), transform .44s var(--ease), box-shadow .22s;
}
.prop-card.vis { opacity:1; transform:none; }
.prop-card:hover {
    transform:translateY(-4px) !important;
    box-shadow:var(--sh-hov);
}

.pc-img-wrap {
    position:relative; overflow:hidden;
    aspect-ratio:16/10; flex-shrink:0;
    background:var(--bg2);
}
.pc-img-wrap img {
    width:100%; height:100%; object-fit:cover; display:block;
    transition:transform .55s var(--ease);
}
.prop-card:hover .pc-img-wrap img { transform:scale(1.06); }

.pc-badge {
    position:absolute; top:12px; left:12px; z-index:2;
    display:inline-flex; align-items:center; gap:5px;
    padding:6px 14px; border-radius:8px;
    font-size:11.5px; font-weight:700; letter-spacing:.02em;
    box-shadow:0 2px 8px rgba(0,0,0,.15);
}
.pc-badge-louer  { background:var(--gr);   color:#fff; }
.pc-badge-vendre { background:#1e3a5c;     color:#fff; }

.pc-fav {
    position:absolute; top:12px; right:12px; z-index:2;
    width:34px; height:34px; border-radius:50%;
    background:#fff;
    border:none; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    color:#ccc; font-size:13px;
    box-shadow:0 2px 8px rgba(0,0,0,.12);
    transition:color .18s,transform .18s;
}
.pc-fav:hover { color:var(--red); transform:scale(1.12); }
.pc-fav.liked { color:var(--red); }

.pc-body {
    padding:16px 16px 10px;
    flex:1; display:flex; flex-direction:column; gap:4px;
}
.pc-price {
    font-size:22px; font-weight:800; color:var(--ink);
    display:flex; align-items:baseline; gap:5px; line-height:1.1;
    margin-bottom:4px;
}
.pc-price-unit { font-size:12px; color:var(--ink3); font-weight:500; }
.pc-title {
    font-size:14px; font-weight:700; color:var(--ink);
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
}
.pc-addr {
    display:flex; align-items:center; gap:5px;
    font-size:12.5px; color:var(--ink3); font-weight:500;
    margin-top:1px;
}
.pc-addr i { color:var(--gr); font-size:11px; flex-shrink:0; }
.pc-feats {
    display:flex; gap:14px; flex-wrap:wrap;
    padding-top:10px; border-top:1px solid var(--bord2);
    margin-top:8px;
}
.pc-feat {
    display:inline-flex; align-items:center; gap:5px;
    font-size:11.5px; font-weight:600; color:var(--ink3);
}
.pc-feat i { font-size:11px; color:var(--ink); }
.pc-footer {
    padding:10px 14px 14px;
    margin-top:auto;
}
.btn-appeler {
    width:100%;
    display:inline-flex; align-items:center; justify-content:center;
    gap:7px; padding:11px 12px; border-radius:10px;
    font-size:13px; font-weight:600; text-decoration:none !important;
    background:var(--gr-lt); color:var(--gr);
    border:1.5px solid rgba(22,163,74,.25);
    transition:all .15s; white-space:nowrap;
    font-family:'Inter',sans-serif;
}
.btn-appeler:hover {
    background:var(--gr); color:#fff;
    border-color:var(--gr); transform:translateY(-1px);
}

@media(max-width:480px){
    .pc-body    { padding:12px 12px 8px; }
    .pc-footer  { padding:8px 12px 12px; }
    .pc-price   { font-size:18px; }
    .pc-title   { font-size:13px; }
    .pc-badge   { font-size:10px; padding:5px 10px; }
    .pc-fav     { width:30px; height:30px; font-size:11px; }
    .btn-appeler{ font-size:12px; padding:9px 10px; }
}

/* ══════════════════════════════════
   EMPTY STATE
══════════════════════════════════ */
.empty-state {
    grid-column:1/-1;
    text-align:center; padding:72px 24px;
}
.es-ico {
    width:84px; height:84px; border-radius:var(--r-xl);
    background:var(--gr-lt); border:1.5px solid var(--gr-b);
    display:flex; align-items:center; justify-content:center;
    margin:0 auto 22px; font-size:28px; color:var(--gr);
}
.es-title { font-size:1.5rem; font-weight:800; color:var(--ink); margin-bottom:9px; }
.es-sub { font-size:13.5px; color:var(--ink3); margin-bottom:26px; max-width:360px; margin-left:auto; margin-right:auto; }
.btn-es {
    display:inline-flex; align-items:center; gap:7px;
    background:var(--gr); color:#fff !important;
    border-radius:var(--r-lg); padding:12px 24px;
    font-size:13.5px; font-weight:700;
    text-decoration:none !important;
    transition:all .18s;
    box-shadow:0 6px 18px var(--gr-glow);
}
.btn-es:hover { background:var(--gr-dk); transform:translateY(-2px); }

/* ══════════════════════════════════
   PAGINATION
══════════════════════════════════ */
.pag-wrap {
    margin-top:48px; padding-top:32px;
    border-top:1px solid var(--bord);
    display:flex; flex-direction:column;
    align-items:center; gap:14px;
}
.pag-info { font-size:12.5px; color:var(--ink3); font-weight:500; }
.pag-info strong { font-size:.95rem; font-weight:800; color:var(--ink); }
.pag-btns { display:flex; gap:5px; flex-wrap:wrap; justify-content:center; }
.pag-btn {
    display:inline-flex; align-items:center; justify-content:center;
    min-width:38px; height:38px; padding:0 7px;
    border-radius:var(--r);
    border:1.5px solid var(--bord);
    background:var(--card); color:var(--ink2);
    font-size:12.5px; font-weight:600;
    text-decoration:none !important;
    font-family:'Inter',sans-serif;
    box-shadow:var(--sh);
    transition:all .16s var(--ease); cursor:pointer;
}
.pag-btn:hover { border-color:var(--gr); color:var(--gr); background:var(--gr-lt); transform:translateY(-1px); }
.pag-btn.active { background:var(--gr); border-color:var(--gr); color:#fff; box-shadow:0 4px 12px var(--gr-glow); transform:translateY(-1px); }
.pag-btn.disabled { opacity:.28; pointer-events:none; }
.pag-btn-arrow { padding:0 14px; gap:5px; font-size:12px; }
.pag-sep { border:none; box-shadow:none; color:var(--ink3); pointer-events:none; }

.list-section { padding:40px 0 90px; }

@media(max-width:640px){
    .page-hero    { padding:40px 0 80px; min-height:200px; }
    .sp-form      { padding:14px 14px 18px; }
    .sp-head      { padding:12px 14px; }
    .active-filters { padding:10px 14px 13px; }
    .list-section { padding:28px 0 64px; }
    .container    { padding:0 13px; }
    .hero-h1      { font-size:1.6rem; }
}
</style>

{{-- ════ HERO ════ --}}
<section class="page-hero">
    <div class="page-hero-bg">
        {{-- Belle vue aérienne de quartier résidentiel africain, claire et moderne --}}
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1600&q=85"
             alt="Immobilier Bénin"
             onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1600&q=85'">
    </div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-deco"></div>
    <div class="container">
        <div class="hero-inner">
            <div class="hero-eyebrow">
                <span class="hero-eyebrow-line"></span>
                Toutes les annonces
                <span class="hero-eyebrow-line"></span>
            </div>
            <h1 class="hero-h1">
                Trouvez le bien <em>idéal</em><br>au meilleur prix
            </h1>
            <p class="hero-sub">Maisons, appartements, bureaux &amp; boutiques — partout au Bénin</p>
        </div>
    </div>
</section>

{{-- ════ SEARCH PANEL ════ --}}
<section class="search-wrap">
    <div class="container">
        <div class="search-panel">
            <div class="sp-head">
                <div class="sp-head-dot"></div>
                <div class="sp-head-title">Affiner la recherche</div>
            </div>
            <form action="{{ route('search.appartement') }}" method="GET" id="searchForm">
                <div class="sp-form">
                    <div class="sp-grid-top">
                        <div class="sf-group">
                            <label class="sf-label">Type de bien</label>
                            <select name="type" class="sf-sel">
                                <option value="">Tous les types</option>
                                <option value="Maison"      {{ request('type')=='Maison'      ?'selected':'' }}>Maison</option>
                                <option value="Appartement" {{ request('type')=='Appartement' ?'selected':'' }}>Appartement</option>
                                <option value="Bureaux"     {{ request('type')=='Bureaux'     ?'selected':'' }}>Bureaux</option>
                                <option value="Boutique"    {{ request('type')=='Boutique'    ?'selected':'' }}>Boutique</option>
                                <option value="Terrain"    {{ request('type')=='Terrain'    ?'selected':'' }}>Terrain</option>
                            </select>
                        </div>
                        <div class="sf-group">
                            <label class="sf-label">Catégorie</label>
                            <select name="categorie" class="sf-sel">
                                <option value="">Toutes</option>
                                <option value="louer"  {{ request('categorie')=='louer'  ?'selected':'' }}>À louer</option>
                                <option value="vendre" {{ request('categorie')=='vendre' ?'selected':'' }}>À vendre</option>
                            </select>
                        </div>
                        <div class="sf-group">
                            <label class="sf-label">Département</label>
                            <select class="sf-sel" id="departementSelect" name="departement"></select>
                        </div>
                        <div class="sf-group">
                            <label class="sf-label">Commune</label>
                            <select class="sf-sel" id="communeSelect" name="commune" disabled>
                                <option value="">Sélectionner</option>
                            </select>
                        </div>
                        <div class="sf-group">
                            <label class="sf-label">Quartier</label>
                            <div class="qac-wrap">
                                <input type="text" class="sf-inp" id="quartierInput" name="quartier"
                                       value="{{ request('quartier') }}"
                                       placeholder="Ex: Akpakpa…" autocomplete="off">
                                <ul class="qac-list" id="quartierSuggestions"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="sp-grid-bottom">
                        <div class="sf-group">
                            <label class="sf-label">Prix minimum (FCFA)</label>
                            <input type="number" class="sf-inp" name="prix_min"
                                   value="{{ request('prix_min') }}" placeholder="Ex : 50 000">
                        </div>
                        <div class="sf-group">
                            <label class="sf-label">Prix maximum (FCFA)</label>
                            <input type="number" class="sf-inp" name="prix_max"
                                   value="{{ request('prix_max') }}" placeholder="Illimité">
                        </div>
                        <div class="sf-group" style="justify-content:flex-end;">
                            <label class="sf-label" style="opacity:0">_</label>
                            <button type="submit" class="btn-search" id="searchBtn">
                                <i class="fa fa-search"></i>
                                <span id="btnTxt">Rechercher</span>
                            </button>
                        </div>
                    </div>
                </div>
                @if(request()->query())
                <div class="active-filters">
                    <span class="af-label">Filtres :</span>
                    @if(request('type'))        <span class="filter-chip"><i class="fa fa-home"></i> {{ request('type') }}</span>@endif
                    @if(request('categorie'))   <span class="filter-chip"><i class="fa fa-tag"></i> {{ request('categorie')=='louer'?'À louer':'À vendre' }}</span>@endif
                    @if(request('departement')) <span class="filter-chip"><i class="fa fa-map"></i> {{ request('departement') }}</span>@endif
                    @if(request('commune'))     <span class="filter-chip"><i class="fa fa-map-marker"></i> {{ request('commune') }}</span>@endif
                    @if(request('quartier'))    <span class="filter-chip"><i class="fa fa-map-pin"></i> {{ request('quartier') }}</span>@endif
                    @if(request('prix_min') || request('prix_max'))
                        <span class="filter-chip">
                            <i class="fa fa-money"></i>
                            {{ request('prix_min') ? number_format(request('prix_min'),0,',',' ') : '0' }}
                            → {{ request('prix_max') ? number_format(request('prix_max'),0,',',' ') : '∞' }} FCFA
                        </span>
                    @endif
                    <a href="{{ route('annonce.all') }}" class="btn-clear-all">
                        <i class="fa fa-times"></i> Effacer tout
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>
</section>

{{-- ════ LISTE ════ --}}
<section class="list-section">
    <div class="container">

        <div class="list-head">
            <div class="list-count">
                <strong>{{ $appartements->total() }}</strong>
                bien{{ $appartements->total() > 1 ? 's' : '' }} trouvé{{ $appartements->total() > 1 ? 's' : '' }}
            </div>
            <div class="sort-row">
                <span class="sort-label">Trier :</span>
                <select class="sort-sel" onchange="window.location=this.value">
                    <option value="{{ request()->fullUrlWithQuery(['sort'=>'recent']) }}"    {{ request('sort','recent')=='recent'   ?'selected':'' }}>Plus récents</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort'=>'prix_asc']) }}"  {{ request('sort')=='prix_asc'          ?'selected':'' }}>Prix croissant</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort'=>'prix_desc']) }}" {{ request('sort')=='prix_desc'         ?'selected':'' }}>Prix décroissant</option>
                </select>
            </div>
        </div>

        <div class="prop-grid" id="propGrid">
            @forelse($appartements as $i => $app)
            @php
                $imgs    = array_values(array_filter(explode('|', $app->images ?? '')));
                $img     = !empty($imgs[0]) ? URL::to($imgs[0]) : asset('images/no-image.jpg');
                $prix    = number_format($app->prix ?? 0, 0, ',', ' ');
                $isLouer = ($app->categorie ?? '') === 'louer';
                $chambres = $app->nombreChambre ?? 0;
                $salles   = $app->nombreSalleBain ?? 0;
                $surface  = $app->surface ?? null;
                $pieces   = $app->nombrePieces ?? 0;
            @endphp
            <div class="prop-card" style="transition-delay:{{ min($i % 10, 9) * 55 }}ms">

                <div class="pc-img-wrap">
                    <a href="{{ route('appartement.detail', $app->id) }}" style="display:block;height:100%;">
                        <img src="{{ $img }}" alt="{{ $app->quartier ?? 'Bien' }}"
                             loading="{{ $i < 8 ? 'eager' : 'lazy' }}">
                    </a>
                    <span class="pc-badge {{ $isLouer ? 'pc-badge-louer' : 'pc-badge-vendre' }}">
                        {{ $isLouer ? 'À louer' : 'À vendre' }}
                    </span>
                    <button class="pc-fav" type="button" onclick="toggleFav(this)" aria-label="Favori">
                        <i class="fa fa-heart-o"></i>
                    </button>
                </div>

                <a href="{{ route('appartement.detail', $app->id) }}" style="text-decoration:none;color:inherit;flex:1;display:flex;flex-direction:column;">
                    <div class="pc-body">
                        <div class="pc-price">
                            {{ $prix }}
                            <span class="pc-price-unit">FCFA{{ $isLouer ? '/mois' : '' }}</span>
                        </div>
                        <div class="pc-title">
                            {{ $app->type ?? '' }}{{ ($app->type && $app->quartier) ? ' — ' : '' }}{{ Str::limit($app->quartier ?? '—', 24) }}
                        </div>
                        <div class="pc-addr">
                            <i class="fa fa-map-marker"></i>
                            {{ $app->commune ?? '' }}{{ ($app->commune && $app->departement) ? ', ' : '' }}{{ $app->departement ?? '' }}
                        </div>
                        <div class="pc-feats">
                            @if($chambres > 0)
                            <div class="pc-feat"><i class="fa fa-bed"></i> {{ $chambres }} ch.</div>
                            @endif
                            @if($salles > 0)
                            <div class="pc-feat"><i class="fa fa-bath"></i> {{ $salles }} sdb</div>
                            @endif
                            @if($surface)
                            <div class="pc-feat"><i class="fa fa-arrows-alt"></i> {{ $surface }} m²</div>
                            @elseif($pieces > 0)
                            <div class="pc-feat"><i class="fa fa-th-large"></i> {{ $pieces }} pièces</div>
                            @endif
                        </div>
                    </div>
                </a>

                <div class="pc-footer">
                    <a href="tel:{{ $app->entreprise->telephone ?? '' }}" class="btn-appeler"
                       onclick="event.stopPropagation()">
                        <i class="fa fa-phone"></i> Appeler
                    </a>
                </div>

            </div>
            @empty
            <div class="empty-state">
                <div class="es-ico"><i class="fa fa-search"></i></div>
                <div class="es-title">Aucun bien trouvé</div>
                <p class="es-sub">Modifiez vos critères ou explorez toutes nos annonces disponibles.</p>
                <a href="{{ route('annonce.all') }}" class="btn-es">
                    <i class="fa fa-refresh"></i> Voir toutes les annonces
                </a>
            </div>
            @endforelse
        </div>

        @if($appartements->hasPages())
        <div class="pag-wrap">
            <div class="pag-info">
                Affichage <strong>{{ $appartements->firstItem() }}</strong> –
                <strong>{{ $appartements->lastItem() }}</strong>
                sur <strong>{{ $appartements->total() }}</strong>
                annonce{{ $appartements->total() > 1 ? 's' : '' }}
            </div>
            <div class="pag-btns">
                @if($appartements->onFirstPage())
                    <span class="pag-btn pag-btn-arrow disabled"><i class="fa fa-chevron-left"></i> Précédent</span>
                @else
                    <a href="{{ $appartements->previousPageUrl() }}" class="pag-btn pag-btn-arrow"><i class="fa fa-chevron-left"></i> Précédent</a>
                @endif

                @php
                    $cur   = $appartements->currentPage();
                    $last  = $appartements->lastPage();
                    $start = max(1, $cur - 2);
                    $end   = min($last, $cur + 2);
                @endphp

                @if($start > 1)
                    <a href="{{ $appartements->url(1) }}" class="pag-btn">1</a>
                    @if($start > 2)<span class="pag-btn pag-sep disabled">…</span>@endif
                @endif

                @for($p = $start; $p <= $end; $p++)
                    @if($p == $cur)
                        <span class="pag-btn active">{{ $p }}</span>
                    @else
                        <a href="{{ $appartements->url($p) }}" class="pag-btn">{{ $p }}</a>
                    @endif
                @endfor

                @if($end < $last)
                    @if($end < $last - 1)<span class="pag-btn pag-sep disabled">…</span>@endif
                    <a href="{{ $appartements->url($last) }}" class="pag-btn">{{ $last }}</a>
                @endif

                @if($appartements->hasMorePages())
                    <a href="{{ $appartements->nextPageUrl() }}" class="pag-btn pag-btn-arrow">Suivant <i class="fa fa-chevron-right"></i></a>
                @else
                    <span class="pag-btn pag-btn-arrow disabled">Suivant <i class="fa fa-chevron-right"></i></span>
                @endif
            </div>
        </div>
        @endif

    </div>
</section>

<script>
var beninData = {
    "":           [],
    "Alibori":    ["Banikoara","Gogounou","Kandi","Karimama","Malanville","Ségbana"],
    "Atacora":    ["Boukoumbé","Cobly","Kérou","Kouandé","Matéri","Natitingou","Péhunco","Tanguiéta","Toucountouna"],
    "Atlantique": ["Abomey-Calavi","Allada","Kpomassè","Ouidah","So-Ava","Toffo","Tori-Bossito","Zè"],
    "Borgou":     ["Bembèrèkè","Kalalé","N'Dali","Nikki","Parakou","Pèrèrè","Sinendé","Tchaourou"],
    "Collines":   ["Bantè","Dassa-Zoumè","Glazoué","Ouèssè","Savalou","Savè"],
    "Couffo":     ["Aplahoué","Djakotomey","Dogbo","Klouékanmè","Lalo","Toviklin"],
    "Donga":      ["Bassila","Copargo","Djougou","Ouaké"],
    "Littoral":   ["Cotonou"],
    "Mono":       ["Athiémé","Bopa","Comè","Grand-Popo","Houéyogbé","Lokossa"],
    "Ouémé":      ["Adjarra","Adjohoun","Aguegues","Akpro-Missérété","Avrankou","Bonou","Dangbo","Porto-Novo","Sèmè-Podji"],
    "Plateau":    ["Adja-Ouèrè","Ifangni","Kétou","Pobè","Sakété"],
    "Zou":        ["Abomey","Agbangnizoun","Bohicon","Covè","Djidja","Ouinhi","Zagnanado"]
};
var quartiersBenin = [
    "Akpakpa","Fidjrossè","Cadjehoun","Ganhi","Zogbo","Houéyiho","Godomey","Ste Rita","Agla","Vêdoko",
    "Gbégamey","Wologuèdè","Jéricho","Hindé","Mènontin","Togoudo","Tankpè","Zopa","Calavi Kpota",
    "Zogbadjè","Aitchedji","Dota","Oganla","Djassin","Kouhounou","Guéma","Kpébié","Zongo",
    "Agongointo","Saclo","Sodohomey","Pahou","Savi","Dantokpa","Houinta","Akassato","Agori","Onigbolo"
];

var depSel = document.getElementById('departementSelect');
var comSel = document.getElementById('communeSelect');

Object.keys(beninData).forEach(function(d){
    var o = document.createElement('option');
    o.value = d; o.textContent = d || 'Tous les départements';
    depSel.appendChild(o);
});
depSel.addEventListener('change', function(){
    comSel.innerHTML = '<option value="">Sélectionner</option>';
    comSel.disabled = true;
    var arr = beninData[this.value];
    if (arr && arr.length){
        arr.forEach(function(c){
            var o = document.createElement('option');
            o.value = c; o.textContent = c;
            comSel.appendChild(o);
        });
        comSel.disabled = false;
    }
});
document.addEventListener('DOMContentLoaded', function(){
    var dept = "{{ request('departement') }}";
    var com  = "{{ request('commune') }}";
    if (dept){
        depSel.value = dept;
        depSel.dispatchEvent(new Event('change'));
        if (com) setTimeout(function(){ comSel.value = com; }, 80);
    }
});

var qInp = document.getElementById('quartierInput');
var qBox = document.getElementById('quartierSuggestions');
qInp.addEventListener('input', function(){
    var v = this.value.toLowerCase();
    qBox.innerHTML = '';
    if (v.length < 2){ qBox.classList.remove('open'); return; }
    var r = quartiersBenin.filter(function(q){ return q.toLowerCase().indexOf(v) !== -1; }).slice(0,8);
    if (!r.length){ qBox.classList.remove('open'); return; }
    r.forEach(function(q){
        var li = document.createElement('li');
        li.className = 'qac-item';
        li.innerHTML = '<i class="fa fa-map-marker"></i>' + q;
        li.addEventListener('click', function(){ qInp.value = q; qBox.classList.remove('open'); });
        qBox.appendChild(li);
    });
    qBox.classList.add('open');
});
document.addEventListener('click', function(e){
    if (!qInp.contains(e.target) && !qBox.contains(e.target)) qBox.classList.remove('open');
});

document.getElementById('searchForm').addEventListener('submit', function(){
    var btn = document.getElementById('searchBtn');
    var txt = document.getElementById('btnTxt');
    txt.textContent = 'Recherche…';
    btn.disabled = true;
});

@if(request()->query())
window.addEventListener('load', function(){
    var grid = document.getElementById('propGrid');
    if (grid) setTimeout(function(){ grid.scrollIntoView({behavior:'smooth',block:'start'}); }, 250);
});
@endif

(function(){
    var cards = document.querySelectorAll('.prop-card');
    if (!cards.length) return;
    if ('IntersectionObserver' in window){
        var obs = new IntersectionObserver(function(entries){
            entries.forEach(function(e){
                if (e.isIntersecting){ e.target.classList.add('vis'); obs.unobserve(e.target); }
            });
        }, {threshold:.06});
        cards.forEach(function(c){ obs.observe(c); });
    } else {
        cards.forEach(function(c){ c.classList.add('vis'); });
    }
})();

function toggleFav(btn){
    var ico = btn.querySelector('i');
    var liked = btn.classList.toggle('liked');
    ico.className = liked ? 'fa fa-heart' : 'fa fa-heart-o';
}
</script>
@endsection