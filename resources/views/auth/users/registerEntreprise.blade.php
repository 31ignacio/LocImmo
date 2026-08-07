@extends('layouts.master2')
@section('content')

<style>
/* ═══════════════════════════════════════════
   RESET
═══════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'DM Sans', sans-serif;
    background: #0b1929;
    min-height: 100vh;
    -webkit-font-smoothing: antialiased;
}

/* ═══════════════════════════════════════════
   LAYOUT — deux colonnes
═══════════════════════════════════════════ */
.rg-wrap {
    display: flex;
    min-height: 100vh;
}

/* ═══════════════════════════════════════════
   GAUCHE — image + branding
═══════════════════════════════════════════ */
.rg-left {
    flex: 1;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: flex-end;
    padding: 48px 52px;
}

.rg-left-bg {
    position: absolute; inset: 0;
    background: url('{{ asset("inscription.jpg") }}') center / cover no-repeat;
}

/* Overlay sombre-vert */
.rg-left-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(
        145deg,
        rgba(6,20,38,.90) 0%,
        rgba(8,38,18,.82) 55%,
        rgba(6,20,38,.72) 100%
    );
}

/* Grain */
.rg-left-noise {
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.04'/%3E%3C/svg%3E");
    opacity: .3; pointer-events: none;
}

/* Décos */
.rg-deco {
    position: absolute; border-radius: 50%; pointer-events: none;
}
.rg-deco-1 {
    width: 380px; height: 380px; top: -120px; right: -100px;
    background: radial-gradient(circle, rgba(22,163,74,.13) 0%, transparent 70%);
}
.rg-deco-2 {
    width: 240px; height: 240px; bottom: 80px; right: 20px;
    background: radial-gradient(circle, rgba(13,148,136,.1) 0%, transparent 70%);
}

.rg-left-content {
    position: relative; z-index: 2; max-width: 440px;
}

/* Badge */
.rg-badge {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(22,163,74,.15);
    border: 1px solid rgba(22,163,74,.3);
    border-radius: 30px; padding: 5px 14px;
    font-size: 11px; font-weight: 700;
    color: #4ade80; letter-spacing: .08em;
    text-transform: uppercase; margin-bottom: 20px;
}
.rg-badge-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: #16a34a;
    animation: pulseDot 2s ease-in-out infinite;
}
@keyframes pulseDot {
    0%,100%{ opacity:1; transform:scale(1); }
    50%{ opacity:.35; transform:scale(.6); }
}

.rg-left-h1 {
    font-family:  sans-serif;
    font-size: clamp(1.8rem, 3vw, 2.7rem);
    font-weight: 800; line-height: 1.1;
    color: #fff; letter-spacing: -.03em;
    margin-bottom: 14px;
}
.rg-left-h1 em { font-style: normal; color: #4ade80; }

.rg-left-desc {
    font-size: 14px; font-weight: 300;
    color: rgba(255,255,255,.46);
    line-height: 1.78; margin-bottom: 28px;
    max-width: 360px;
}

/* Features */
.rg-features {
    display: flex; flex-direction: column; gap: 10px;
    margin-bottom: 32px;
}
.rg-feat {
    display: flex; align-items: center; gap: 11px;
    font-size: 13.5px; color: rgba(255,255,255,.7); font-weight: 500;
}
.rg-feat-ico {
    width: 28px; height: 28px; border-radius: 8px; flex-shrink: 0;
    background: rgba(22,163,74,.16);
    border: 1px solid rgba(22,163,74,.28);
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; color: #4ade80;
}

/* Bouton retour */
.rg-back {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 16px; border-radius: 9px;
    border: 1.5px solid rgba(255,255,255,.13);
    background: rgba(255,255,255,.06);
    color: rgba(255,255,255,.7) !important;
    font-size: 12.5px; font-weight: 600;
    text-decoration: none !important;
    transition: all .18s; backdrop-filter: blur(8px);
}
.rg-back:hover {
    background: rgba(255,255,255,.1);
    color: #fff !important; border-color: rgba(255,255,255,.24);
}

/* ═══════════════════════════════════════════
   DROITE — formulaire
═══════════════════════════════════════════ */
.rg-right {
    flex: 1.1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 32px 28px;
    background: #f2f4f9;
    position: relative;
    overflow-y: auto;
}

/* Motif de fond */
.rg-right::before {
    content: '';
    position: absolute; inset: 0;
    background-image: radial-gradient(rgba(22,163,74,.04) 1px, transparent 1px);
    background-size: 28px 28px;
    pointer-events: none;
}

/* Carte formulaire */
.rg-card {
    position: relative; z-index: 1;
    width: 100%; max-width: 520px;
    background: #fff;
    border-radius: 22px;
    border: 1px solid rgba(14,16,34,.07);
    box-shadow: 0 4px 24px rgba(14,16,34,.07), 0 24px 64px rgba(14,16,34,.09);
    overflow: hidden;
    animation: cardIn .55s cubic-bezier(.16,1,.3,1) forwards;
    opacity: 0;
}
@keyframes cardIn {
    from { opacity:0; transform:translateY(18px); }
    to   { opacity:1; transform:none; }
}

/* Barre animée en haut */
.rg-card-bar {
    height: 4px;
    background: linear-gradient(90deg, #16a34a, #0d9488, #16a34a);
    background-size: 200% 100%;
    animation: shimmer 3s linear infinite;
}
@keyframes shimmer {
    0%   { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

.rg-card-body { padding: 32px 36px 28px; }

/* En-tête */
.rg-card-head { text-align: center; margin-bottom: 26px; }
.rg-card-ico {
    width: 52px; height: 52px; border-radius: 14px;
    background: linear-gradient(135deg, #16a34a, #0d9488);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
    font-size: 20px; color: #fff;
    box-shadow: 0 8px 22px rgba(22,163,74,.35);
}
.rg-card-title {
    font-family:  sans-serif;
    font-size: 21px; font-weight: 800;
    color: #0c0e17; letter-spacing: -.03em; margin-bottom: 4px;
}
.rg-card-sub { font-size: 13px; color: #8c90a8; font-weight: 400; }

/* ── Champs ── */
.rf-group { margin-bottom: 16px; }
.rf-row { display: flex; gap: 14px; margin-bottom: 16px; }
.rf-row .rf-group { flex: 1; margin-bottom: 0; }

.rf-label {
    display: block;
    font-size: 10.5px; font-weight: 700;
    color: #7c809a; text-transform: uppercase;
    letter-spacing: .09em; margin-bottom: 6px;
}

.rf-field { position: relative; display: flex; align-items: center; }

.rf-icon {
    position: absolute; left: 13px;
    font-size: 13px; color: #b0b4c8;
    pointer-events: none; z-index: 1;
    transition: color .18s;
}

.rf-input, .rf-select {
    width: 100%; height: 46px;
    padding: 0 14px 0 38px;
    border: 1.5px solid #dde1ef;
    border-radius: 11px;
    background: #f8f9fc;
    font-size: 13.5px; font-weight: 500;
    color: #0c0e17;
    font-family: 'DM Sans', sans-serif;
    outline: none;
    transition: border-color .2s, background .2s, box-shadow .2s;
    -webkit-appearance: none;
}
.rf-input:focus, .rf-select:focus {
    border-color: #16a34a;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(22,163,74,.1);
}
.rf-field:focus-within .rf-icon { color: #16a34a; }
.rf-input::placeholder { color: #b8bccf; font-weight: 400; }

/* Erreur */
.rf-error {
    display: flex; align-items: center; gap: 5px;
    margin-top: 4px;
    font-size: 11.5px; font-weight: 600; color: #dc2626;
}

/* ── Bouton submit ── */
.rg-submit {
    width: 100%; height: 50px;
    border: none; border-radius: 12px;
    background: linear-gradient(135deg, #16a34a, #0d9488);
    color: #fff; font-size: 15px; font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer; position: relative; overflow: hidden;
    box-shadow: 0 6px 18px rgba(22,163,74,.35);
    transition: transform .18s, box-shadow .18s;
    margin-top: 6px;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.rg-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 26px rgba(22,163,74,.45);
}
.rg-submit:active { transform: translateY(0); }
.rg-submit::after {
    content: ''; position: absolute; inset: 0;
    background: rgba(255,255,255,.1); opacity: 0; transition: opacity .28s;
}
.rg-submit:hover::after { opacity: 1; }

/* Spinner */
.rg-spinner {
    width: 18px; height: 18px;
    border: 2.5px solid rgba(255,255,255,.28);
    border-top-color: #fff; border-radius: 50%;
    animation: spin .75s linear infinite; display: none;
}
@keyframes spin { to { transform: rotate(360deg); } }
.rg-submit.loading .rg-btn-txt { opacity: .28; }
.rg-submit.loading .rg-spinner { display: block; }

/* Footer carte */
.rg-card-footer {
    padding: 15px 36px 18px;
    border-top: 1px solid #eceef6;
    text-align: center;
    font-size: 13px; color: #8c90a8;
}
.rg-card-footer a {
    color: #16a34a; font-weight: 700;
    text-decoration: none !important; transition: color .18s;
}
.rg-card-footer a:hover { color: #15803d; }

/* Section header dans le form */
.rf-section {
    font-size: 10px; font-weight: 800;
    color: #b0b4c8; text-transform: uppercase;
    letter-spacing: .12em;
    display: flex; align-items: center; gap: 10px;
    margin: 18px 0 14px;
}
.rf-section::before, .rf-section::after {
    content: ''; flex: 1; height: 1px; background: #eceef6;
}

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media (max-width: 960px) {
    .rg-wrap { flex-direction: column; }
    .rg-left {
        flex: none; height: 260px;
        padding: 28px 24px;
        align-items: center; justify-content: center; text-align: center;
    }
    .rg-left-content { max-width: 100%; }
    .rg-left-desc { display: none; }
    .rg-features { display: none; }
    .rg-back { display: none; }
    .rg-left-h1 { font-size: 1.65rem; }

    .rg-right { padding: 28px 14px; align-items: flex-start; }
    .rg-card { max-width: 100%; }
}

@media (max-width: 560px) {
    .rf-row { flex-direction: column; gap: 0; }
    .rf-row .rf-group { margin-bottom: 16px; }
    .rg-card-body { padding: 26px 20px 22px; }
    .rg-card-footer { padding: 13px 20px 17px; }
    .rg-left { height: 210px; }
    .rg-badge { display: none; }
}
</style>

<div class="rg-wrap">

    {{-- ════ GAUCHE ════ --}}
    <div class="rg-left">
        <div class="rg-left-bg"></div>
        <div class="rg-left-overlay"></div>
        <div class="rg-left-noise"></div>
        <div class="rg-deco rg-deco-1"></div>
        <div class="rg-deco rg-deco-2"></div>

        <div class="rg-left-content">
            <div class="rg-badge">
                <span class="rg-badge-dot"></span>
                Inscription gratuite
            </div>

            <h1 class="rg-left-h1">
                Publiez vos biens.<br>
                <em>Attirez</em> plus de clients.
            </h1>

            <p class="rg-left-desc">
                Rejoignez notre plateforme et augmentez votre visibilité
                en quelques clics. Simple, rapide, efficace.
            </p>

            <div class="rg-features">
                <div class="rg-feat">
                    <div class="rg-feat-ico"><i class="fa fa-check"></i></div>
                    Publication simple et rapide
                </div>
                <div class="rg-feat">
                    <div class="rg-feat-ico"><i class="fa fa-whatsapp"></i></div>
                    Contacts directs WhatsApp
                </div>
                <div class="rg-feat">
                    <div class="rg-feat-ico"><i class="fa fa-shield"></i></div>
                    Tableau de bord sécurisé
                </div>
                <div class="rg-feat">
                    <div class="rg-feat-ico"><i class="fa fa-bar-chart"></i></div>
                    Suivi de vos annonces
                </div>
            </div>

            <a href="{{ url('/') }}" class="rg-back">
                <i class="fa fa-arrow-left"></i> Retour à l'accueil
            </a>
        </div>
    </div>

    {{-- ════ DROITE — formulaire ════ --}}
    <div class="rg-right">
        <div class="rg-card">
            <div class="rg-card-bar"></div>

            <div class="rg-card-body">

                {{-- En-tête --}}
                <div class="rg-card-head">
                    <div class="rg-card-ico"><i class="fa fa-user-plus"></i></div>
                    <div class="rg-card-title">Créer votre compte</div>
                    <div class="rg-card-sub">Moins d'une minute — c'est gratuit</div>
                </div>

                <form action="{{ route('handleEntrepriseRegister') }}" method="POST" id="registerForm" novalidate>
                    @csrf

                    {{-- Profil --}}
                    <div class="rf-group">
                        <label class="rf-label" for="typeSelect">Profil utilisateur</label>
                        <div class="rf-field">
                            <i class="fa fa-user rf-icon"></i>
                            <select name="profil" id="typeSelect" class="rf-select" required>
                                <option value="">— Sélectionner votre profil —</option>
                                <option value="proprietaire" {{ old('profil')=='proprietaire'?'selected':'' }}>Propriétaire</option>
                                <option value="agence"       {{ old('profil')=='agence'      ?'selected':'' }}>Agence immobilière</option>
                            </select>
                        </div>
                        @error('profil')<div class="rf-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>

                    {{-- Identité --}}
                    <div class="rf-section">Identité</div>
                    <div class="rf-row">
                        <div class="rf-group">
                            <label class="rf-label" for="nomInput">Nom</label>
                            <div class="rf-field">
                                <i class="fa fa-id-card-o rf-icon"></i>
                                <input type="text" name="nom" id="nomInput" class="rf-input"
                                       value="{{ old('nom') }}" placeholder="Votre nom" required>
                            </div>
                            @error('nom')<div class="rf-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                        </div>
                        <div class="rf-group">
                            <label class="rf-label" for="prenomInput">Prénom</label>
                            <div class="rf-field">
                                <i class="fa fa-id-card-o rf-icon"></i>
                                <input type="text" name="prenom" id="prenomInput" class="rf-input"
                                       value="{{ old('prenom') }}" placeholder="Votre prénom" required>
                            </div>
                            @error('prenom')<div class="rf-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Localisation --}}
                    <div class="rf-section">Localisation</div>
                    <div class="rf-row">
                        <div class="rf-group">
                            <label class="rf-label" for="villeInput">Ville</label>
                            <div class="rf-field">
                                <i class="fa fa-map-marker rf-icon"></i>
                                <input type="text" name="ville" id="villeInput" class="rf-input"
                                       value="{{ old('ville') }}" placeholder="Ex : Cotonou" required>
                            </div>
                            @error('ville')<div class="rf-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                        </div>
                        <div class="rf-group">
                            <label class="rf-label" for="quartierInput">Quartier</label>
                            <div class="rf-field">
                                <i class="fa fa-map-pin rf-icon"></i>
                                <input type="text" name="quatier" id="quartierInput" class="rf-input"
                                       value="{{ old('quatier') }}" placeholder="Ex : Akpakpa" required>
                            </div>
                            @error('quatier')<div class="rf-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Contact --}}
                    <div class="rf-section">Contact</div>
                    <div class="rf-row">
                        <div class="rf-group">
                            <label class="rf-label" for="telInput">Téléphone</label>
                            <div class="rf-field">
                                <i class="fa fa-phone rf-icon"></i>
                                <input type="tel" name="telephone" id="telInput" class="rf-input"
                                       value="{{ old('telephone') }}" placeholder="+229 00 00 00 00" required>
                            </div>
                            @error('telephone')<div class="rf-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                        </div>
                        <div class="rf-group">
                            <label class="rf-label" for="emailInput">E-mail</label>
                            <div class="rf-field">
                                <i class="fa fa-envelope rf-icon"></i>
                                <input type="email" name="email" id="emailInput" class="rf-input"
                                       value="{{ old('email') }}" placeholder="vous@exemple.com" required>
                            </div>
                            @error('email')<div class="rf-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="rg-submit" id="rgBtn">
                        <span class="rg-btn-txt">
                            <i class="fa fa-user-plus" style="margin-right:7px;"></i>Créer mon compte gratuitement
                        </span>
                        <span class="rg-spinner"></span>
                    </button>

                </form>
            </div>

            {{-- Footer carte --}}
            <div class="rg-card-footer">
                Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a>
            </div>
        </div>
    </div>

</div>

<script>
    (function () {
        var form    = document.getElementById('registerForm');
        var btn     = document.getElementById('rgBtn');

        if (form && btn) {
            form.addEventListener('submit', function () {
                btn.classList.add('loading');
                btn.disabled = true;
            });
        }
    })();
</script>

@endsection