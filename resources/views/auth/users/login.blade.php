@extends('layouts.master2')

@section('content')


<style>
/* ═══════════════════════════════════════════
   RESET
═══════════════════════════════════════════ */
*, *::before, *::after {
    box-sizing: border-box; margin: 0; padding: 0;
}

body {
    font-family: 'DM Sans', sans-serif;
    background: #0b1929;
    min-height: 100vh;
    -webkit-font-smoothing: antialiased;
}

/* ═══════════════════════════════════════════
   LAYOUT — deux colonnes
═══════════════════════════════════════════ */
.auth-wrap {
    display: flex;
    min-height: 100vh;
}

/* ═══════════════════════════════════════════
   GAUCHE — image + texte
═══════════════════════════════════════════ */
.auth-left {
    flex: 1.15;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: flex-end;
    padding: 52px 56px;
}

/* Photo de fond */
.auth-left-bg {
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1350&q=80') center / cover no-repeat;
}

/* Dégradé vert sombre par-dessus la photo */
.auth-left-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(
        135deg,
        rgba(6, 20, 38, .88) 0%,
        rgba(10, 40, 20, .78) 50%,
        rgba(6, 20, 38, .70) 100%
    );
}

/* Grain subtil */
.auth-left-noise {
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.04'/%3E%3C/svg%3E");
    opacity: .35; pointer-events: none;
}

/* Contenu gauche */
.auth-left-content {
    position: relative; z-index: 2;
    max-width: 480px;
}

/* Badge */
.auth-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(22,163,74,.15);
    border: 1px solid rgba(22,163,74,.3);
    border-radius: 30px;
    padding: 6px 16px;
    font-size: 11.5px; font-weight: 700;
    color: #4ade80; letter-spacing: .08em;
    text-transform: uppercase; margin-bottom: 22px;
}
.auth-badge-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: #16a34a;
    animation: pulseGreen 2s ease-in-out infinite;
}
@keyframes pulseGreen {
    0%,100%{ opacity:1; transform:scale(1); }
    50%{ opacity:.4; transform:scale(.6); }
}

.auth-left-h1 {
    font-family: sans-serif;
    font-size: clamp(2rem, 3.5vw, 3rem);
    font-weight: 800; line-height: 1.08;
    color: #fff; letter-spacing: -.03em;
    margin-bottom: 16px;
}
.auth-left-h1 em {
    font-style: normal; color: #4ade80;
}

.auth-left-desc {
    font-size: 14.5px; font-weight: 300;
    color: rgba(255,255,255,.5);
    line-height: 1.78; margin-bottom: 32px;
    max-width: 380px;
}

/* Stats inline */
.auth-stats {
    display: flex; gap: 28px; margin-bottom: 36px; flex-wrap: wrap;
}
.auth-stat {}
.auth-stat-val {
    font-family: sans-serif;
    font-size: 22px; font-weight: 800; color: #fff;
    display: block; line-height: 1;
    margin-bottom: 3px;
}
.auth-stat-lbl {
    font-size: 11px; font-weight: 500;
    color: rgba(255,255,255,.36);
    text-transform: uppercase; letter-spacing: .08em;
}

/* Bouton retour */
.auth-back {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 18px; border-radius: 10px;
    border: 1.5px solid rgba(255,255,255,.14);
    background: rgba(255,255,255,.06);
    color: rgba(255,255,255,.72) !important;
    font-size: 13px; font-weight: 600;
    text-decoration: none !important;
    transition: all .18s; backdrop-filter: blur(8px);
}
.auth-back:hover {
    background: rgba(255,255,255,.1);
    color: #fff !important;
    border-color: rgba(255,255,255,.25);
}

/* Décorations cercles */
.auth-deco {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}
.auth-deco-1 {
    width: 340px; height: 340px;
    top: -100px; right: -80px;
    background: radial-gradient(circle, rgba(22,163,74,.12) 0%, transparent 70%);
}
.auth-deco-2 {
    width: 220px; height: 220px;
    bottom: 60px; right: 40px;
    background: radial-gradient(circle, rgba(13,148,136,.1) 0%, transparent 70%);
}

/* ═══════════════════════════════════════════
   DROITE — formulaire
═══════════════════════════════════════════ */
.auth-right {
    flex: 0.85;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 32px 24px;
    background: #f2f4f9;
    position: relative;
}

/* Motif subtil */
.auth-right::before {
    content: '';
    position: absolute; inset: 0;
    background-image: radial-gradient(rgba(22,163,74,.04) 1px, transparent 1px);
    background-size: 28px 28px;
    pointer-events: none;
}

/* Carte formulaire */
.auth-card {
    position: relative; z-index: 1;
    width: 100%; max-width: 420px;
    background: #fff;
    border-radius: 22px;
    border: 1px solid rgba(14,16,34,.07);
    box-shadow: 0 4px 24px rgba(14,16,34,.07), 0 24px 64px rgba(14,16,34,.09);
    overflow: hidden;

    /* Animation entrée */
    animation: cardIn .55s cubic-bezier(.16,1,.3,1) forwards;
    opacity: 0;
}
@keyframes cardIn {
    from { opacity:0; transform:translateY(20px); }
    to   { opacity:1; transform:none; }
}

/* Bande verte en haut */
.auth-card-top {
    height: 4px;
    background: linear-gradient(90deg, #16a34a, #0d9488, #16a34a);
    background-size: 200% 100%;
    animation: shimmer 3s linear infinite;
}
@keyframes shimmer {
    0%   { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

.auth-card-body { padding: 36px 36px 32px; }

/* En-tête card */
.auth-card-head { text-align: center; margin-bottom: 30px; }

.auth-card-ico {
    width: 56px; height: 56px; border-radius: 16px;
    background: linear-gradient(135deg, #16a34a, #0d9488);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    font-size: 22px; color: #fff;
    box-shadow: 0 8px 22px rgba(22,163,74,.35);
}

.auth-card-title {
    font-family: sans-serif;
    font-size: 22px; font-weight: 800;
    color: #0c0e17; letter-spacing: -.03em;
    margin-bottom: 5px;
}

.auth-card-sub {
    font-size: 13.5px; color: #8c90a8; font-weight: 400;
}

/* ── Champs ── */
.af-group { margin-bottom: 18px; }

.af-label {
    display: block;
    font-size: 11px; font-weight: 700;
    color: #7c809a; text-transform: uppercase;
    letter-spacing: .09em; margin-bottom: 7px;
}

.af-field {
    position: relative;
    display: flex; align-items: center;
}

.af-icon {
    position: absolute; left: 14px;
    font-size: 14px; color: #b0b4c8;
    pointer-events: none; z-index: 1;
    transition: color .18s;
}

.af-input {
    width: 100%;
    height: 48px;
    padding: 0 48px 0 42px;
    border: 1.5px solid #dde1ef;
    border-radius: 12px;
    background: #f8f9fc;
    font-size: 14px; font-weight: 500;
    color: #0c0e17;
    font-family: 'DM Sans', sans-serif;
    outline: none;
    transition: border-color .2s, background .2s, box-shadow .2s;
    -webkit-appearance: none;
}

.af-input:focus {
    border-color: #16a34a;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(22,163,74,.1);
}

.af-input:focus ~ .af-icon,
.af-field:focus-within .af-icon { color: #16a34a; }

.af-input::placeholder { color: #b8bccf; font-weight: 400; }

/* Erreur Laravel */
.af-error {
    display: flex; align-items: center; gap: 5px;
    margin-top: 5px;
    font-size: 12px; font-weight: 600; color: #dc2626;
}
.af-error i { font-size: 11px; }

/* Œil mot de passe */
.af-eye {
    position: absolute; right: 14px;
    font-size: 15px; color: #b0b4c8;
    cursor: pointer; z-index: 2;
    transition: color .18s;
}
.af-eye:hover { color: #16a34a; }

/* ── Bouton submit ── */
.af-submit {
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
.af-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 26px rgba(22,163,74,.45);
}
.af-submit:active { transform: translateY(0); }

/* Spinner dans le bouton */
.af-spinner {
    width: 18px; height: 18px;
    border: 2.5px solid rgba(255,255,255,.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin .75s linear infinite;
    display: none;
}
@keyframes spin {
    to { transform: rotate(360deg); }
}
.af-submit.loading .af-btn-txt { opacity: .3; }
.af-submit.loading .af-spinner { display: block; }

/* Ripple */
.af-submit::after {
    content: '';
    position: absolute; inset: 0;
    background: rgba(255,255,255,.12);
    opacity: 0; transition: opacity .3s;
}
.af-submit:hover::after { opacity: 1; }

/* ── Séparateur ── */
.af-divider {
    display: flex; align-items: center; gap: 12px;
    margin: 20px 0;
}
.af-divider-line {
    flex: 1; height: 1px;
    background: #eceef6;
}
.af-divider-txt {
    font-size: 11.5px; font-weight: 600;
    color: #b0b4c8; white-space: nowrap;
}

/* ── Liens ── */
.af-links {
    text-align: center;
    font-size: 13.5px; color: #8c90a8; font-weight: 400;
}
.af-links a {
    color: #16a34a; font-weight: 700;
    text-decoration: none !important;
    transition: color .18s;
}
.af-links a:hover { color: #15803d; }

/* Mot de passe oublié */
.af-forgot {
    display: flex; justify-content: flex-end;
    margin-top: -6px; margin-bottom: 18px;
}
.af-forgot a {
    font-size: 12.5px; font-weight: 600;
    color: #16a34a; text-decoration: none !important;
    transition: color .18s;
}
.af-forgot a:hover { color: #15803d; }

/* ── Footer card ── */
.auth-card-footer {
    padding: 16px 36px 20px;
    border-top: 1px solid #eceef6;
    text-align: center;
    font-size: 13px; color: #8c90a8;
}
.auth-card-footer a {
    color: #16a34a; font-weight: 700;
    text-decoration: none !important;
}
.auth-card-footer a:hover { color: #15803d; }

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media (max-width: 900px) {
    .auth-wrap { flex-direction: column; min-height: 100vh; }

    .auth-left {
        flex: none;
        height: 240px;
        padding: 28px 24px;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .auth-left-content { max-width: 100%; }
    .auth-stats { justify-content: center; }
    .auth-back { display: none; }
    .auth-left-h1 { font-size: 1.7rem; }
    .auth-left-desc { display: none; }

    .auth-right { flex: 1; padding: 32px 16px; align-items: flex-start; }
    .auth-card { max-width: 100%; }
}

@media (max-width: 480px) {
    .auth-card-body { padding: 28px 22px 24px; }
    .auth-card-footer { padding: 14px 22px 18px; }
    .auth-left { height: 200px; }
    .auth-badge { display: none; }
}
</style>

<div class="auth-wrap">

    {{-- ════ GAUCHE — image + branding ════ --}}
    <div class="auth-left">
        <div class="auth-left-bg"></div>
        <div class="auth-left-overlay"></div>
        <div class="auth-left-noise"></div>
        <div class="auth-deco auth-deco-1"></div>
        <div class="auth-deco auth-deco-2"></div>

        <div class="auth-left-content">

            <div class="auth-badge">
                <span class="auth-badge-dot"></span>
                Plateforme immobilière Bénin
            </div>

            <h1 class="auth-left-h1">
                Votre espace<br>
                <em>immobilier</em> en ligne
            </h1>

            <p class="auth-left-desc">
                Gérez vos appartements, boutiques et chambres en toute simplicité.
                Suivez vos locataires, paiements et contrats via une interface intuitive.
            </p>

            <div class="auth-stats">
                <div class="auth-stat">
                    <span class="auth-stat-val">500+</span>
                    <span class="auth-stat-lbl">Annonces actives</span>
                </div>
                <div class="auth-stat">
                    <span class="auth-stat-val">12</span>
                    <span class="auth-stat-lbl">Départements</span>
                </div>
                <div class="auth-stat">
                    <span class="auth-stat-val">98%</span>
                    <span class="auth-stat-lbl">Satisfaction</span>
                </div>
            </div>

            <a href="{{ url('/') }}" class="auth-back">
                <i class="fa fa-arrow-left"></i> Retour à l'accueil
            </a>

        </div>
    </div>

    {{-- ════ DROITE — formulaire ════ --}}
    <div class="auth-right">

        <div class="auth-card">
            <div class="auth-card-top"></div>

            <div class="auth-card-body">

                {{-- En-tête --}}
                <div class="auth-card-head">
                    <div class="auth-card-ico">
                        <i class="fa fa-home"></i>
                    </div>
                    <div class="auth-card-title">Connexion</div>
                    <div class="auth-card-sub">Bienvenue sur IMMOLOC</div>
                </div>

                {{-- Formulaire --}}
                <form action="{{ route('login') }}" method="POST" id="loginForm" novalidate>
                    @csrf

                    {{-- Email --}}
                    <div class="af-group">
                        <label class="af-label" for="emailInput">Adresse e-mail</label>
                        <div class="af-field">
                            <i class="fa fa-envelope af-icon"></i>
                            <input
                                type="email"
                                name="email"
                                id="emailInput"
                                class="af-input"
                                value="{{ old('email') }}"
                                placeholder="vous@exemple.com"
                                autocomplete="email"
                                required>
                        </div>
                        @error('email')
                            <div class="af-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Mot de passe --}}
                    <div class="af-group">
                        <label class="af-label" for="passwordInput">Mot de passe</label>
                        <div class="af-field">
                            <i class="fa fa-lock af-icon"></i>
                            <input
                                type="password"
                                name="password"
                                id="passwordInput"
                                class="af-input"
                                placeholder="••••••••"
                                autocomplete="current-password"
                                required>
                            <i class="fa fa-eye-slash af-eye" id="togglePwd" title="Afficher / Masquer"></i>
                        </div>
                        @error('password')
                            <div class="af-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Mot de passe oublié --}}
                    <div class="af-forgot">
                        <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                    </div>

                    {{-- Bouton --}}
                    <button type="submit" class="af-submit" id="loginBtn">
                        <span class="af-btn-txt"><i class="fa fa-sign-in" style="margin-right:6px;"></i>Se connecter</span>
                        <span class="af-spinner"></span>
                    </button>

                </form>

            </div>

            {{-- Footer carte --}}
            <div class="auth-card-footer">
                Pas encore de compte ?
                <a href="{{ route('user.registerEntreprise') }}">Créer un compte</a>
            </div>

        </div>

    </div>

</div>

<script>
(function () {
    /* Toggle afficher/masquer le mot de passe */
    var toggleBtn = document.getElementById('togglePwd');
    var pwdInput  = document.getElementById('passwordInput');

    if (toggleBtn && pwdInput) {
        toggleBtn.addEventListener('click', function () {
            var isHidden = pwdInput.type === 'password';
            pwdInput.type = isHidden ? 'text' : 'password';
            toggleBtn.classList.toggle('fa-eye',      isHidden);
            toggleBtn.classList.toggle('fa-eye-slash', !isHidden);
        });
    }

    /* Loader sur le bouton à la soumission */
    var form = document.getElementById('loginForm');
    var btn  = document.getElementById('loginBtn');

    if (form && btn) {
        form.addEventListener('submit', function () {
            btn.classList.add('loading');
            btn.disabled = true;
        });
    }
})();
</script>

@endsection