<style>
/* ═══════════════════════════════════════════
   FOOTER
═══════════════════════════════════════════ */
.ft {
    background: #0b1929;
    border-top: 1px solid rgba(255,255,255,.06);
    padding: 48px 0 0;
    font-family: 'DM Sans', sans-serif;
    color: rgba(255,255,255,.55);
}

.ft .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 28px;
}

/* Grille 3 colonnes */
.ft-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr 1.2fr;
    gap: 40px;
    padding-bottom: 40px;
    border-bottom: 1px solid rgba(255,255,255,.07);
}

/* ── COL 1 : Brand ── */
.ft-brand-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
}
.ft-brand-ico {
    width: 36px; height: 36px;
    border-radius: 9px;
    background: linear-gradient(135deg, #16a34a, #0d9488);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 16px;
    box-shadow: 0 4px 14px rgba(22,163,74,.35);
    flex-shrink: 0;
}
.ft-brand-name {
    font-size: 17px; font-weight: 800;
    color: #fff; letter-spacing: -.4px; display: block; line-height: 1.1;
}
.ft-brand-name em { font-style: normal; color: #16a34a; }
.ft-brand-sub {
    font-size: 9px; font-weight: 600;
    color: rgba(255,255,255,.3); letter-spacing: .16em;
    text-transform: uppercase; display: block; margin-top: 2px;
}

.ft-desc {
    font-size: 13px; line-height: 1.75;
    color: rgba(255,255,255,.42);
    margin-bottom: 18px; max-width: 280px;
}

/* Réseaux sociaux */
.ft-social {
    display: flex; gap: 8px;
}
.ft-social a {
    width: 34px; height: 34px; border-radius: 9px;
    border: 1.5px solid #16a34a;
    background: #16a34a;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,.55); font-size: 13px;
    text-decoration: none !important;
    transition: all .18s;
}
.ft-social a:hover {
    background: #16a34a;
    border-color: #16a34a;
    color: #fff;
    transform: translateY(-2px);
}

/* ── COL 2 : Liens rapides ── */
.ft-title {
    font-size: 12px; font-weight: 800;
    color: #fff; text-transform: uppercase;
    letter-spacing: .1em; margin-bottom: 16px;
    display: flex; align-items: center; gap: 8px;
}
.ft-title::after {
    content: '';
    flex: 1; height: 1px;
    background: rgba(255,255,255,.08);
}

.ft-links {
    list-style: none; margin: 0; padding: 0;
    display: flex; flex-direction: column; gap: 10px;
}
.ft-links li a {
    display: flex; align-items: center; gap: 8px;
    font-size: 13.5px; font-weight: 500;
    color: rgba(255,255,255,.5);
    text-decoration: none !important;
    transition: color .18s, gap .18s;
}
.ft-links li a i {
    font-size: 10px; color: #16a34a;
    transition: transform .18s;
}
.ft-links li a:hover {
    color: #fff; gap: 11px;
}
.ft-links li a:hover i { transform: translateX(2px); }

/* ── COL 3 : Tarification ── */
.ft-pricing-list {
    list-style: none; margin: 0 0 18px; padding: 0;
    display: flex; flex-direction: column; gap: 10px;
}
.ft-pricing-list li {
    display: flex; align-items: center; gap: 9px;
    font-size: 13px; color: rgba(255,255,255,.5);
}
.ft-pricing-list li i {
    width: 22px; height: 22px; border-radius: 6px;
    background: rgba(22,163,74,.14);
    border: 1px solid rgba(22,163,74,.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; color: #4ade80; flex-shrink: 0;
}
.ft-pricing-list li strong { color: rgba(255,255,255,.82); font-weight: 700; }

/* Bouton tarifs */
.ft-btn-tarif {
    display: inline-flex; align-items: center; gap: 7px;
    height: 36px; padding: 0 18px;
    border-radius: 8px;
    border: 1.5px solid rgba(22,163,74,.45);
    background: transparent;
    color: #4ade80 !important;
    font-size: 12.5px; font-weight: 700;
    text-decoration: none !important;
    font-family: 'DM Sans', sans-serif;
    transition: all .18s; cursor: pointer;
}
.ft-btn-tarif:hover {
    background: #16a34a;
    border-color: #16a34a;
    color: #fff !important;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(22,163,74,.32);
}

/* ── BOTTOM BAR ── */
.ft-bottom {
    background: rgba(0,0,0,.3);
    border-top: 1px solid rgba(255,255,255,.05);
}
.ft-bottom-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 16px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}
.ft-copy {
    font-size: 12.5px; font-weight: 500;
    color: rgba(255,255,255,.3);
}
.ft-copy strong { color: rgba(255,255,255,.5); font-weight: 700; }

.ft-bottom-links {
    display: flex; gap: 20px;
}
.ft-bottom-links a {
    font-size: 12.5px; font-weight: 500;
    color: rgba(255,255,255,.35);
    text-decoration: none !important;
    transition: color .18s;
}
.ft-bottom-links a:hover { color: #4ade80; }

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media (max-width: 768px) {
    .ft-grid {
        grid-template-columns: 1fr 1fr;
        gap: 28px;
    }
    /* Brand prend toute la première ligne */
    .ft-col-brand {
        grid-column: 1 / -1;
    }
    .ft-desc { max-width: 100%; }
}

@media (max-width: 520px) {
    .ft { padding-top: 36px; }
    .ft .container { padding: 0 16px; }
    .ft-grid { grid-template-columns: 1fr; gap: 24px; }
    .ft-col-brand { grid-column: auto; }
    .ft-bottom-inner { flex-direction: column; align-items: flex-start; gap: 8px; }
    .ft-bottom-links { gap: 14px; }
}


/* ═══════════════════════════════════════════
   MODAL TARIFS — reprend le style du header
═══════════════════════════════════════════ */
.tarif-modal-content {
    background: #0d1f38;
    border: 1px solid rgba(22,163,74,.2);
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 24px 64px rgba(0,0,0,.4);
    font-family: 'DM Sans', sans-serif;
}
.tarif-modal-header {
    background: #0b1929;
    border-bottom: 1px solid rgba(255,255,255,.07);
    padding: 20px 24px;
    display: flex; align-items: center; justify-content: space-between;
}
.tarif-modal-header h4 {
    color: #fff; font-size: 16px; font-weight: 800;
    margin: 0; display: flex; align-items: center; gap: 9px;
}
.tarif-modal-header h4 i { color: #16a34a; }
.tarif-modal-close {
    width: 34px; height: 34px; border-radius: 50%;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.1);
    color: rgba(255,255,255,.6); font-size: 14px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all .18s;
}
.tarif-modal-close:hover { background: #dc2626; border-color: #dc2626; color: #fff; }

.tarif-modal-body { padding: 24px; }

.tarif-card-new {
    background: rgba(255,255,255,.04);
    border: 1.5px solid rgba(255,255,255,.08);
    border-radius: 14px; padding: 24px;
    transition: border-color .2s, transform .2s;
}
.tarif-card-new:hover {
    border-color: rgba(22,163,74,.4);
    transform: translateY(-4px);
}
.tarif-card-new.premium-new {
    border-color: rgba(22,163,74,.3);
    background: rgba(22,163,74,.05);
}
.tc-ico {
    width: 44px; height: 44px; border-radius: 11px;
    background: rgba(22,163,74,.14);
    border: 1px solid rgba(22,163,74,.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; color: #4ade80; margin-bottom: 14px;
}
.tc-name {
    font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 4px;
}
.tc-price {
    font-size: 30px; font-weight: 800; color: #4ade80;
    font-family: 'JetBrains Mono', monospace;
    letter-spacing: -.02em; margin-bottom: 4px;
}
.tc-price small { font-size: 13px; font-weight: 500; color: rgba(255,255,255,.35); }
.tc-desc { font-size: 12px; color: rgba(255,255,255,.38); margin-bottom: 16px; }
.tc-list {
    list-style: none; margin: 0 0 20px; padding: 0;
    display: flex; flex-direction: column; gap: 8px;
}
.tc-list li {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; color: rgba(255,255,255,.55);
}
.tc-list li i { color: #16a34a; font-size: 11px; }
.btn-publier-new {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; height: 40px; border-radius: 10px;
    background: #16a34a; border: none;
    color: #fff !important; font-size: 13.5px; font-weight: 700;
    text-decoration: none !important;
    font-family: 'DM Sans', sans-serif;
    box-shadow: 0 4px 14px rgba(22,163,74,.32);
    transition: all .18s; cursor: pointer;
}
.btn-publier-new:hover {
    background: #15803d; color: #fff !important;
    transform: translateY(-1px); box-shadow: 0 6px 18px rgba(22,163,74,.42);
}
</style>

{{-- ════════════════════ FOOTER ════════════════════ --}}
<footer class="ft">
    <div class="container">
        <div class="ft-grid">

            {{-- COL 1 : Brand --}}
            <div class="ft-col-brand">
                <div class="ft-brand-row">
                    <div>
                         <a href="{{ route('home') }}" class="nb-brand">
                            <img src="{{ asset('logo.png') }}" alt="IMMOLOC" class="nb-brand-img">
                        </a>  
                    </div>
                </div>
                <p class="ft-desc">Plateforme moderne pour trouver appartements, chambres, boutiques et terrains rapidement partout au Bénin.</p>
                <div class="ft-social">
                    <a href="#" title="Facebook"><i class="fa fa-facebook"></i></a>
                    <a href="#" title="WhatsApp"><i class="fa fa-whatsapp"></i></a>
                </div>
            </div>

            {{-- COL 2 : Liens rapides --}}
            <div>
                <div class="ft-title">Liens rapides</div>
                <ul class="ft-links">
                    <li><a href="{{ route('home') }}"><i class="fa fa-angle-right"></i> Accueil</a></li>
                    <li><a href="{{ route('annonce.all') }}"><i class="fa fa-angle-right"></i> Nos offres</a></li>
                    <li><a href="{{ route('contacte.create') }}"><i class="fa fa-angle-right"></i> Contact</a></li>
                    @auth
                    <li><a href="{{ route('entreprise.espace') }}"><i class="fa fa-angle-right"></i> Mon espace</a></li>
                    @endauth
                    @guest
                    <li><a href="{{ route('login') }}"><i class="fa fa-angle-right"></i> Connexion</a></li>
                    <li><a href="{{ route('user.registerEntreprise') }}"><i class="fa fa-angle-right"></i> S'inscrire</a></li>
                    @endguest
                </ul>
            </div>

            {{-- COL 3 : Tarification --}}
            <div>
                <div class="ft-title">Tarification</div>
                <ul class="ft-pricing-list">
                    
                    <li>
                        <i class="fa fa-star"></i>
                        Annonce 7 jours : <strong>5 000 FCFA</strong>
                    </li>
                    
                </ul>
                <button class="ft-btn-tarif" onclick="openTarif()" aria-haspopup="dialog">
                    <i class="fa fa-tags"></i> Voir les tarifs
                </button>
            </div>

        </div>
    </div>
</footer>

{{-- ════════════════════ MODAL TARIFS ════════════════════ --}}
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

/* MODAL */
function openTarif() { var bd=document.getElementById('tarifBackdrop'); bd.classList.add('open'); document.body.style.overflow='hidden'; }
function closeTarif() { var bd=document.getElementById('tarifBackdrop'); bd.classList.remove('open'); document.body.style.overflow=''; }
document.getElementById('tarifBackdrop').addEventListener('click', function(e){ if(e.target===this) closeTarif(); });
document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeTarif(); });
</script>