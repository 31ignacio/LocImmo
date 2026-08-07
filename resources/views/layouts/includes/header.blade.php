<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* ═══════════════════════════════════════════
   BASE
═══════════════════════════════════════════ */
body { padding-top: 68px; font-family: 'Inter', sans-serif; }

/* ═══════════════════════════════════════════
   NAVBAR
═══════════════════════════════════════════ */
.nb { position:fixed; top:0; left:0; right:0; z-index:1000; height:68px; background:#0b1929; border-bottom:1px solid rgba(255,255,255,.06); box-shadow:0 2px 20px rgba(0,0,0,.22); }
.nb-inner { max-width:1440px; margin:0 auto; padding:0 28px; height:68px; display:flex; align-items:center; }

/* BRAND */
.nb-brand { display:flex; align-items:center; gap:10px; text-decoration:none !important; flex-shrink:0; margin-right:32px; }
.nb-brand-img {
    height: 82px;
    width: auto;
    display: block;
    object-fit: contain;
}
.nb-brand-logo { width:36px; height:36px; border-radius:9px; background:linear-gradient(135deg,#16a34a,#0d9488); display:flex; align-items:center; justify-content:center; color:#fff; font-size:16px; box-shadow:0 4px 14px rgba(22,163,74,.38); flex-shrink:0; }
.nb-brand-name { font-size:17px; font-weight:800; color:#fff; letter-spacing:-.4px; line-height:1.1; display:block; }
.nb-brand-name em { font-style:normal; color:#16a34a; }
.nb-brand-sub { font-size:9px; font-weight:600; color:rgba(255,255,255,.3); letter-spacing:.16em; text-transform:uppercase; display:block; margin-top:2px; }

/* MENU CENTRAL */
.nb-menu { display:flex; align-items:center; list-style:none; margin:0; padding:0; flex:1; justify-content:center; height:68px; gap:0; }
.nb-menu > li { height:68px; display:flex; align-items:center; position:relative; }
.nb-menu > li > a, .nb-menu > li > button { display:flex; align-items:center; height:68px; padding:0 14px; color:rgba(255,255,255,.6); font-size:13.5px; font-weight:600; text-decoration:none !important; white-space:nowrap; letter-spacing:.01em; transition:color .18s; position:relative; background:none; border:none; cursor:pointer; font-family:'Inter',sans-serif; }
.nb-menu > li > a:hover, .nb-menu > li > button:hover { color:#fff; }
.nb-menu > li.active > a, .nb-menu > li.active > button { color:#fff; }
.nb-menu > li.active > a::after, .nb-menu > li.active > button::after { content:''; position:absolute; bottom:0; left:10px; right:10px; height:3px; background:#16a34a; border-radius:3px 3px 0 0; }
.nb-menu > li:not(.active) > a::after, .nb-menu > li:not(.active) > button::after { content:''; position:absolute; bottom:0; left:10px; right:10px; height:2px; background:rgba(255,255,255,.12); border-radius:3px 3px 0 0; transform:scaleX(0); transform-origin:center; transition:transform .2s; }
.nb-menu > li:not(.active) > a:hover::after, .nb-menu > li:not(.active) > button:hover::after { transform:scaleX(1); }

/* DROITE */
.nb-right { display:flex; align-items:center; gap:8px; flex-shrink:0; margin-left:16px; }
.nb-phone { display:flex; align-items:center; gap:7px; color:rgba(255,255,255,.6); font-size:12.5px; font-weight:600; text-decoration:none !important; white-space:nowrap; transition:color .18s; }
.nb-phone:hover { color:#fff; }
.nb-phone-ico { width:28px; height:28px; border-radius:50%; border:1.5px solid rgba(255,255,255,.18); display:flex; align-items:center; justify-content:center; font-size:11px; flex-shrink:0; }
.nb-sep { width:1px; height:22px; background:rgba(255,255,255,.1); flex-shrink:0; margin:0 2px; }
.nb-heart { width:36px; height:36px; border-radius:50%; border:1.5px solid rgba(255,255,255,.16); background:transparent; display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,.62); font-size:14px; text-decoration:none !important; flex-shrink:0; transition:all .18s; }
.nb-heart:hover { background:rgba(255,255,255,.07); color:#fff; border-color:rgba(255,255,255,.28); transform:scale(1.06); }
.nb-btn-outline { display:inline-flex; align-items:center; gap:6px; height:36px; padding:0 16px; border-radius:8px; border:1.5px solid rgba(255,255,255,.24); background:transparent; color:rgba(255,255,255,.84) !important; font-size:12.5px; font-weight:700; text-decoration:none !important; white-space:nowrap; font-family:'Inter',sans-serif; transition:all .18s; cursor:pointer; }
.nb-btn-outline:hover { background:rgba(255,255,255,.07); border-color:rgba(255,255,255,.4); color:#fff !important; }
.nb-btn-outline-green { display:inline-flex; align-items:center; gap:6px; height:36px; padding:0 16px; border-radius:8px; border:1.5px solid rgba(22,163,74,.5); background:transparent; color:#4ade80 !important; font-size:12.5px; font-weight:700; text-decoration:none !important; white-space:nowrap; font-family:'Inter',sans-serif; transition:all .18s; cursor:pointer; }
.nb-btn-outline-green:hover { background:rgba(22,163,74,.1); border-color:#16a34a; color:#fff !important; }
.nb-btn-green { display:inline-flex; align-items:center; gap:6px; height:36px; padding:0 20px; border-radius:8px; border:1.5px solid #16a34a; background:#16a34a; color:#fff !important; font-size:12.5px; font-weight:700; text-decoration:none !important; white-space:nowrap; font-family:'Inter',sans-serif; box-shadow:0 4px 14px rgba(22,163,74,.32); transition:all .18s; cursor:pointer; }
.nb-btn-green:hover { background:#15803d; border-color:#15803d; color:#fff !important; transform:translateY(-1px); box-shadow:0 6px 18px rgba(22,163,74,.42); }
.nb-btn-outline-red { display:inline-flex; align-items:center; gap:6px; height:36px; padding:0 14px; border-radius:8px; border:1.5px solid rgba(239,68,68,.38); background:transparent; color:#f87171 !important; font-size:12.5px; font-weight:700; text-decoration:none !important; white-space:nowrap; font-family:'Inter',sans-serif; transition:all .18s; cursor:pointer; }
.nb-btn-outline-red:hover { background:rgba(239,68,68,.1); border-color:rgba(239,68,68,.6); color:#fff !important; }

/* HAMBURGER */
.nb-toggle { display:none; flex-direction:column; justify-content:center; align-items:center; gap:5px; width:38px; height:38px; border-radius:9px; border:1.5px solid rgba(255,255,255,.13); background:rgba(255,255,255,.05); cursor:pointer; flex-shrink:0; margin-left:auto; padding:0; transition:background .18s; }
.nb-toggle:hover { background:rgba(255,255,255,.1); }
.nb-toggle span { display:block; width:17px; height:2px; background:rgba(255,255,255,.8); border-radius:2px; transition:all .25s; }
.nb-toggle.open span:nth-child(1) { transform:translateY(7px) rotate(45deg); }
.nb-toggle.open span:nth-child(2) { opacity:0; transform:scaleX(0); }
.nb-toggle.open span:nth-child(3) { transform:translateY(-7px) rotate(-45deg); }

/* DRAWER MOBILE */
.nb-drawer { display:none; position:fixed; top:68px; left:0; right:0; background:#0d1f38; border-top:1px solid rgba(255,255,255,.07); box-shadow:0 16px 40px rgba(0,0,0,.35); z-index:999; padding-bottom:16px; overflow-y:auto; max-height:calc(100vh - 68px); }
.nb-drawer.open { display:block; animation:drawerSlide .22s ease forwards; }
@keyframes drawerSlide { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
.nb-drawer-menu { list-style:none; margin:0; padding:8px 0 0; }
.nb-drawer-menu > li > a, .nb-drawer-menu > li > button { display:flex; align-items:center; padding:13px 24px; color:rgba(255,255,255,.68); font-size:14.5px; font-weight:600; text-decoration:none !important; border-left:3px solid transparent; transition:background .15s,color .15s,border-color .15s; background:none; border-top:none; border-right:none; border-bottom:none; width:100%; cursor:pointer; font-family:'Inter',sans-serif; text-align:left; }
.nb-drawer-menu > li > a:hover, .nb-drawer-menu > li > button:hover { background:rgba(255,255,255,.04); color:#fff; }
.nb-drawer-menu > li.active > a, .nb-drawer-menu > li.active > button { color:#4ade80; background:rgba(22,163,74,.07); border-left-color:#16a34a; }
.nb-drawer-bottom { padding:14px 16px 4px; border-top:1px solid rgba(255,255,255,.07); display:flex; flex-direction:column; gap:9px; }
.nb-drawer-phone { display:flex; align-items:center; justify-content:center; gap:9px; padding:11px 16px; background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.07); border-radius:10px; color:rgba(255,255,255,.65); font-size:13.5px; font-weight:600; text-decoration:none !important; transition:background .15s; }
.nb-drawer-phone:hover { background:rgba(255,255,255,.08); color:#fff; }
.nb-drawer-btns { display:flex; gap:8px; flex-wrap:wrap; }
.nb-drawer-btns .nb-heart { border-radius:10px; width:auto; flex:1; height:40px; gap:6px; font-size:13px; }
.nb-drawer-btns .nb-btn-outline, .nb-drawer-btns .nb-btn-outline-green, .nb-drawer-btns .nb-btn-outline-red, .nb-drawer-btns .nb-btn-green { flex:1; justify-content:center; height:40px; padding:0 10px; border-radius:10px; font-size:13px; }

/* TOOLTIP */
.tooltip-register { position:relative; display:inline-block; }
.tooltip-register .tooltip-text { visibility:hidden; opacity:0; position:absolute; top:115%; left:50%; transform:translateX(-50%); width:260px; background:#111827; color:#fff; padding:12px 14px; border-radius:14px; font-size:12px; line-height:1.6; text-align:left; box-shadow:0 10px 30px rgba(0,0,0,.18); transition:all .2s ease; z-index:9999; }
.tooltip-register .tooltip-text::before { content:''; position:absolute; bottom:100%; left:50%; transform:translateX(-50%); border-width:7px; border-style:solid; border-color:transparent transparent #111827 transparent; }
.tooltip-register:hover .tooltip-text { visibility:visible; opacity:1; }

/* RESPONSIVE */
@media (max-width:1200px) { .nb-phone-txt { display:none; } }
@media (max-width:960px) {
    body { padding-top:60px; } .nb { height:60px; } .nb-inner { height:60px; padding:0 16px; }
    .nb-brand { margin-right:0; } .nb-menu { display:none; } .nb-right { display:none; }
    .nb-toggle { display:flex; } .nb-drawer { top:60px; max-height:calc(100vh - 60px); }
}
@media (max-width:420px) {
    .nb-brand-sub { display:none; } .nb-brand-name { font-size:15px; }
    .nb-brand-logo { width:32px; height:32px; font-size:14px; }
    .nb-drawer-btns { flex-direction:column; }
    .nb-drawer-btns .nb-heart, .nb-drawer-btns .nb-btn-outline,
    .nb-drawer-btns .nb-btn-outline-green, .nb-drawer-btns .nb-btn-outline-red,
    .nb-drawer-btns .nb-btn-green { width:100%; }
}

/* ═══════════════════════════════════════════
   MODAL TARIFICATION — VERSION COMPACTE
═══════════════════════════════════════════ */
.tarif-backdrop {
    display:none; position:fixed; inset:0; z-index:2000;
    background:rgba(11,25,41,.72); backdrop-filter:blur(4px);
    align-items:center; justify-content:center; padding:16px;
}
.tarif-backdrop.open { display:flex; animation:bfIn .2s ease; }
@keyframes bfIn { from{opacity:0} to{opacity:1} }

.tarif-modal {
    background:#fff; border-radius:18px;
    width:100%; max-width:400px;          /* ← plus étroit */
    box-shadow:0 24px 72px rgba(0,0,0,.22);
    overflow:hidden;
    animation:modalIn .25s cubic-bezier(.16,1,.3,1);
}
@keyframes modalIn { from{opacity:0;transform:translateY(16px) scale(.97)} to{opacity:1;transform:translateY(0) scale(1)} }

/* En-tête compact */
.tarif-head {
    background:#0b1929; padding:16px 20px;
    display:flex; align-items:center;
    justify-content:space-between; gap:12px;
}
.tarif-head-title { font-size:17px; font-weight:800; color:#fff; letter-spacing:-.02em; margin:0; }
.tarif-head-sub { font-size:11px; color:rgba(255,255,255,.38); margin-top:3px; }
.tarif-close { width:30px; height:30px; border-radius:7px; border:1.5px solid rgba(255,255,255,.14); background:rgba(255,255,255,.06); color:rgba(255,255,255,.55); font-size:13px; display:flex; align-items:center; justify-content:center; cursor:pointer; flex-shrink:0; transition:all .18s; padding:0; }
.tarif-close:hover { background:rgba(255,255,255,.12); color:#fff; }

/* Corps compact */
.tarif-body { padding:18px 20px 0; }

/* Prix mis en avant */
.tarif-price-row {
    display:flex; align-items:center; justify-content:space-between;
    background:#f0fdf4; border:1.5px solid #bbf7d0;
    border-radius:12px; padding:14px 18px; margin-bottom:16px;
}
.tarif-price-left {}
.tarif-price-label { font-size:11px; font-weight:700; color:#16a34a; text-transform:uppercase; letter-spacing:.07em; margin-bottom:4px; }
.tarif-price-val { font-size:32px; font-weight:800; color:#111827; letter-spacing:-.04em; line-height:1; }
.tarif-price-val span { font-size:14px; color:#6b7280; font-weight:600; }
.tarif-price-note { font-size:11px; color:#15803d; font-weight:600; margin-top:4px; }
.tarif-price-badge {
    background:#16a34a; color:#fff;
    border-radius:8px; padding:6px 12px;
    font-size:11px; font-weight:800;
    text-align:center; line-height:1.3;
    flex-shrink:0;
}

/* Features compactes — grille 2 colonnes */
.tarif-features {
    list-style:none; padding:0; margin:0 0 18px;
    display:grid; grid-template-columns:1fr 1fr; gap:7px;
}
.tarif-features li {
    display:flex; align-items:flex-start; gap:7px;
    font-size:12px; color:#374151; font-weight:500; line-height:1.4;
}
.tf-check { width:16px; height:16px; border-radius:4px; background:#f0fdf4; border:1.5px solid #86efac; display:flex; align-items:center; justify-content:center; font-size:8px; color:#16a34a; flex-shrink:0; margin-top:1px; }

/* CTA */
.tarif-foot { padding:0 20px 18px; }
.tarif-cta { display:flex; align-items:center; justify-content:center; gap:8px; width:100%; padding:12px 20px; border-radius:10px; border:none; background:#16a34a; color:#fff; font-size:13.5px; font-weight:700; font-family:'Inter',sans-serif; cursor:pointer; text-decoration:none !important; box-shadow:0 6px 20px rgba(22,163,74,.35); transition:all .2s; }
.tarif-cta:hover { background:#15803d; color:#fff !important; transform:translateY(-1px); box-shadow:0 10px 28px rgba(22,163,74,.44); }
.tarif-note { text-align:center; margin-top:10px; font-size:11px; color:#9ca3af; font-weight:500; }
.tarif-note i { margin-right:4px; color:#d1d5db; }
</style>

{{-- ══════════════════════
     NAVBAR
══════════════════════ --}}
<nav class="nb" role="navigation" aria-label="Navigation principale">
    <div class="nb-inner">
        {{-- <a href="{{ route('home') }}" class="nb-brand">
            <div class="nb-brand-logo"><i class="fa fa-home"></i></div>
            <div>
                <span class="nb-brand-name">IMMO<em>LOC</em></span>
                <span class="nb-brand-sub">Immobilier Bénin</span>
            </div>
        </a> --}}
        <a href="{{ route('home') }}" class="nb-brand">
            <img src="{{ asset('logo.png') }}" alt="IMMOLOC" class="nb-brand-img">
        </a>    

        <ul class="nb-menu">
            <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}">Accueil</a>
            </li>
            <li class="{{ request()->routeIs('annonce.all') ? 'active' : '' }}">
                <a href="{{ route('annonce.all') }}">Nos Offres</a>
            </li>
            @auth
            <li class="{{ request()->routeIs('entreprise.liste') ? 'active' : '' }}">
                <a href="{{ route('entreprise.liste') }}">Entreprises</a>
            </li>
            @endauth
            <li>
                <button type="button" onclick="openTarif()" aria-haspopup="dialog">
                    Tarification <i class="fa fa-chevron-down" style="font-size:9px;margin-left:4px;opacity:.6;"></i>
                </button>
            </li>
            <li>
                <a href="{{ route('annonce.all') }}?categorie=louer">Menu 2</a>
            </li>
            <li class="{{ request()->routeIs('contacte.create') ? 'active' : '' }}">
                <a href="{{ route('contacte.create') }}">Contactez-Nous</a>
            </li>
        </ul>

        <div class="nb-right">
            
            <div class="nb-sep"></div>
            @guest
            <a href="{{ route('login') }}" class="nb-btn-outline">Accéder à mon espace</a>
            <div class="tooltip-register">
                <a href="{{ route('user.registerEntreprise') }}" class="nb-btn-green">Je m'inscrire</a>
                <div class="tooltip-text">
                    <strong><i class="fa fa-info-circle"></i> Inscription réservée</strong><br>
                    Destinée aux <b>propriétaires</b> et <b>agences immobilières</b> souhaitant publier des biens sur la plateforme.
                </div>
            </div>
            @endguest
            @auth
            <a href="{{ route('entreprise.espace') }}" class="nb-btn-outline-green">
                <i class="fa fa-user-circle-o"></i> Mon espace
            </a>
            <a href="{{ route('user.logout') }}" class="nb-btn-outline-red">
                <i class="fa fa-sign-out"></i> Déconnexion
            </a>
            @endauth
        </div>

        <button class="nb-toggle" id="nbToggle" type="button" aria-label="Ouvrir le menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

{{-- ══════════════════════
     DRAWER MOBILE
══════════════════════ --}}
<div class="nb-drawer" id="nbDrawer" aria-hidden="true">
    <ul class="nb-drawer-menu">
        <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}"><i class="fa fa-home" style="margin-right:10px;font-size:13px;"></i>Accueil</a>
        </li>
        <li class="{{ request()->routeIs('annonce.all') ? 'active' : '' }}">
            <a href="{{ route('annonce.all') }}"><i class="fa fa-building-o" style="margin-right:10px;font-size:13px;"></i>Nos Offres</a>
        </li>
        @auth
        <li class="{{ request()->routeIs('entreprise.liste') ? 'active' : '' }}">
            <a href="{{ route('entreprise.liste') }}"><i class="fa fa-users" style="margin-right:10px;font-size:13px;"></i>Entreprises</a>
        </li>
        @endauth
        <li>
            <button type="button" onclick="openTarif(); closeDrawerFn();">
                <i class="fa fa-tag" style="margin-right:10px;font-size:13px;"></i>Tarification
            </button>
        </li>
        <li>
            <a href="{{ route('annonce.all') }}?categorie=louer"><i class="fa fa-key" style="margin-right:10px;font-size:13px;"></i>Menu 2</a>
        </li>
        <li class="{{ request()->routeIs('contacte.create') ? 'active' : '' }}">
            <a href="{{ route('contacte.create') }}"><i class="fa fa-envelope-o" style="margin-right:10px;font-size:13px;"></i>Contactez-Nous</a>
        </li>
    </ul>
    <div class="nb-drawer-bottom">
       
        <div class="nb-drawer-btns">
            @guest
            <a href="{{ route('login') }}" class="nb-btn-outline">Mon espace</a>
            <a href="{{ route('user.registerEntreprise') }}" class="nb-btn-green">Je m'inscrire</a>
            @endguest
            @auth
            <a href="{{ route('entreprise.espace') }}" class="nb-btn-outline-green"><i class="fa fa-user-circle-o"></i> Mon espace</a>
            <a href="{{ route('user.logout') }}" class="nb-btn-outline-red"><i class="fa fa-sign-out"></i> Déconnexion</a>
            @endauth
        </div>
    </div>
</div>

{{-- ══════════════════════
     MODAL TARIFICATION COMPACT
══════════════════════ --}}
<div class="tarif-backdrop" id="tarifBackdrop" role="dialog"
     aria-modal="true" aria-labelledby="tarifTitle">
    <div class="tarif-modal">

        {{-- En-tête --}}
        <div class="tarif-head">
            <div>
                <h2 class="tarif-head-title" id="tarifTitle">Tarification</h2>
                <div class="tarif-head-sub">Simple, transparent, sans abonnement.</div>
            </div>
            <button class="tarif-close" onclick="closeTarif()" aria-label="Fermer">
                <i class="fa fa-times"></i>
            </button>
        </div>

        {{-- Corps --}}
        <div class="tarif-body">

            {{-- Prix --}}
            <div class="tarif-price-row">
                <div class="tarif-price-left">
                    <div class="tarif-price-label">Publication d'annonce</div>
                    <div class="tarif-price-val">5 000 <span>FCFA</span></div>
                    <div class="tarif-price-note"><i class="fa fa-check-circle"></i> Paiement unique</div>
                </div>
                <div class="tarif-price-badge">
                    7 jours<br>de visibilité
                </div>
            </div>

            {{-- Features en grille 2 colonnes --}}
            <ul class="tarif-features">
                <li><div class="tf-check"><i class="fa fa-check"></i></div>Visible 7 jours</li>
                <li><div class="tf-check"><i class="fa fa-check"></i></div>Photos & vidéo</li>
                <li><div class="tf-check"><i class="fa fa-check"></i></div>Dans les recherches</li>
                <li><div class="tf-check"><i class="fa fa-check"></i></div>Coordonnées visibles</li>
                <li><div class="tf-check"><i class="fa fa-check"></i></div>Paiement Scurisé</li>
                <li><div class="tf-check"><i class="fa fa-check"></i></div>Renouvelable</li>
            </ul>
        </div>

        {{-- Footer --}}
        <div class="tarif-foot">
            @guest
            <a href="{{ route('login') }}" class="tarif-cta">
                <i class="fa fa-rocket"></i> Publier mon annonce
            </a>
            @endguest
            @auth
            <a href="{{ route('appartement') }}" class="tarif-cta">
                <i class="fa fa-rocket"></i> Publier mon annonce
            </a>
            @endauth
            <p class="tarif-note"><i class="fa fa-lock"></i> Paiement sécurisé · Actif dès validation</p>
        </div>
    </div>
</div>

<script>
/* HAMBURGER */
(function () {
    var toggle = document.getElementById('nbToggle');
    var drawer = document.getElementById('nbDrawer');
    if (!toggle || !drawer) return;
    function openDrawer() { drawer.classList.add('open'); toggle.classList.add('open'); toggle.setAttribute('aria-expanded','true'); drawer.setAttribute('aria-hidden','false'); document.body.style.overflow='hidden'; }
    window.closeDrawerFn = function () { drawer.classList.remove('open'); toggle.classList.remove('open'); toggle.setAttribute('aria-expanded','false'); drawer.setAttribute('aria-hidden','true'); document.body.style.overflow=''; };
    toggle.addEventListener('click', function(e){ e.stopPropagation(); drawer.classList.contains('open') ? closeDrawerFn() : openDrawer(); });
    document.addEventListener('click', function(e){ if (drawer.classList.contains('open') && !drawer.contains(e.target) && !toggle.contains(e.target)) closeDrawerFn(); });
    document.addEventListener('keydown', function(e){ if (e.key==='Escape') closeDrawerFn(); });
    window.addEventListener('resize', function(){ if (window.innerWidth>960) closeDrawerFn(); });
})();

/* MODAL */
function openTarif() { var bd=document.getElementById('tarifBackdrop'); bd.classList.add('open'); document.body.style.overflow='hidden'; }
function closeTarif() { var bd=document.getElementById('tarifBackdrop'); bd.classList.remove('open'); document.body.style.overflow=''; }
document.getElementById('tarifBackdrop').addEventListener('click', function(e){ if(e.target===this) closeTarif(); });
document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeTarif(); });
</script>