@extends('layouts.master2')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
:root {
    --navy:      #0d1f38;
    --navy-hov:  #162c4a;
    --navy-glow: rgba(13,31,56,.12);
    --blue-soft: #7fb3ff;
    --gr:        #16a34a;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.da-wrap {
    display: flex;
    min-height: 100vh;
    overflow: hidden;
}

/* ── Côté gauche — image immobilière ── */
.da-left {
    flex: 1;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 2.5rem;
    overflow: hidden;
}

.da-left-bg {
    position: absolute;
    inset: 0;
    z-index: 0;
}
.da-left-bg img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
}
.da-left-overlay {
    position: absolute;
    inset: 0;
    z-index: 1;
    background: linear-gradient(
        180deg,
        rgba(13,31,56,.55) 0%,
        rgba(13,31,56,.65) 50%,
        rgba(13,31,56,.92) 100%
    );
}

.da-deco-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,.05);
    pointer-events: none;
    z-index: 2;
}
.da-deco-1 { width: 340px; height: 340px; top: -100px; right: -100px; }
.da-deco-2 { width: 200px; height: 200px; bottom: 60px; left: -60px; }
.da-deco-3 { width: 80px;  height: 80px;  top: 40%;    right: 10%; }

.da-dots {
    display: flex;
    gap: 7px;
    position: absolute;
    top: 2rem;
    left: 2.5rem;
    z-index: 3;
}
.da-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: rgba(255,255,255,.18);
}
.da-dot.on { background: var(--blue-soft); }

.da-left-content {
    position: relative;
    z-index: 3;
}

.da-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.16);
    border-radius: 20px;
    padding: 7px 16px;
    color: rgba(255,255,255,.75);
    font-size: 12px;
    font-weight: 500;
    margin-bottom: 1.5rem;
    width: fit-content;
    backdrop-filter: blur(4px);
}
.da-badge i { color: var(--blue-soft); font-size: 15px; }

.da-left h1 {
    font-size: 32px;
    font-weight: 700;
    color: #fff;
    line-height: 1.25;
    letter-spacing: -.03em;
    margin-bottom: 14px;
}
.da-left p {
    font-size: 14px;
    color: rgba(255,255,255,.65);
    line-height: 1.7;
    max-width: 300px;
    margin-bottom: 2rem;
}

.da-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: rgba(255,255,255,.7);
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    border: 1px solid rgba(255,255,255,.18);
    border-radius: 8px;
    padding: 9px 16px;
    transition: background .18s;
    width: fit-content;
    backdrop-filter: blur(4px);
}
.da-back:hover { background: rgba(255,255,255,.1); color: #fff; }
.da-back i { font-size: 14px; }

/* ── Côté droit ── */
.da-right {
    flex: 1;
    background: #f5f6f8;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2.5rem 2rem;
}

.da-card {
    width: 100%;
    max-width: 400px;
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e8eaed;
    padding: 2rem 2rem 1.75rem;
}

.da-card-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: var(--navy);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.25rem;
}
.da-card-icon i { color: var(--blue-soft); font-size: 20px; }

.da-card-title {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    letter-spacing: -.02em;
    margin-bottom: 5px;
}
.da-card-sub {
    font-size: 13px;
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 1.75rem;
}

/* ── Champs ── */
.da-field { margin-bottom: 1.1rem; }

.da-label {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-bottom: 6px;
}
.da-label-tag {
    font-size: 11px;
    font-weight: 500;
    color: var(--navy);
    background: rgba(13,31,56,.07);
    border-radius: 4px;
    padding: 2px 7px;
    text-transform: none;
    letter-spacing: 0;
}

.da-input-wrap { position: relative; }

.da-input {
    width: 100%;
    padding: 10px 14px;
    border-radius: 8px;
    border: 1.5px solid #e5e7eb;
    background: #fafafa;
    font-size: 14px;
    color: #111827;
    outline: none;
    transition: border-color .18s, box-shadow .18s, background .18s;
    font-family: inherit;
}
.da-input:focus {
    border-color: var(--navy);
    background: #fff;
    box-shadow: 0 0 0 3px var(--navy-glow);
}
.da-input[readonly] {
    background: #f3f4f6;
    color: #9ca3af;
    cursor: default;
}
.da-input.pad-r { padding-right: 42px; }

.da-eye {
    position: absolute;
    right: 11px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #9ca3af;
    font-size: 16px;
    display: flex;
    align-items: center;
    padding: 0;
    transition: color .15s;
}
.da-eye:hover { color: #374151; }

/* Barre force mot de passe */
.da-strength {
    height: 3px;
    border-radius: 2px;
    background: #e5e7eb;
    margin-top: 7px;
    overflow: hidden;
}
.da-strength-fill {
    height: 100%;
    width: 0;
    border-radius: 2px;
    transition: width .3s ease, background .3s ease;
}

/* Erreurs Laravel */
.da-err { font-size: 12px; color: #dc2626; margin-top: 5px; font-weight: 500; }

/* ── Bouton ── */
.da-btn {
    width: 100%;
    padding: 12px;
    border-radius: 9px;
    border: none;
    background: var(--navy);
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: background .2s, transform .1s;
    margin-top: 1.25rem;
    font-family: inherit;
}
.da-btn:hover { background: var(--navy-hov); }
.da-btn:active { transform: scale(.98); }
.da-btn:disabled { opacity: .55; cursor: not-allowed; transform: none; }

.da-spinner {
    display: none;
    width: 16px; height: 16px;
    border: 2px solid rgba(255,255,255,.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: da-spin .6s linear infinite;
}
@keyframes da-spin { to { transform: rotate(360deg); } }

/* ── Footer sécurité ── */
.da-divider {
    border: none;
    border-top: 1px solid #f1f1f1;
    margin: 1.5rem 0 1.1rem;
}
.da-secure {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: 11.5px;
    color: #9ca3af;
}
.da-secure i { font-size: 13px; }

/* ── Responsive ── */
@media (max-width: 992px) {
    .da-wrap { flex-direction: column; }
    .da-left { min-height: 280px; justify-content: flex-end; }
    .da-left h1 { font-size: 24px; }
    .da-left p { max-width: 100%; }
    .da-right { padding: 2rem 1.25rem; }
    .da-card { max-width: 100%; border-radius: 12px; }
}

@media (max-width: 576px) {
    .da-left { min-height: 230px; padding: 1.75rem 1.25rem; }
    .da-dots  { left: 1.25rem; }
    .da-badge { font-size: 11px; }
    .da-left h1 { font-size: 20px; }
    .da-card { padding: 1.5rem 1.25rem; }
    .da-card-title { font-size: 18px; }
}
</style>

<div class="da-wrap">

    {{-- ── Gauche — image immobilière ── --}}
    <div class="da-left">
        <div class="da-left-bg">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1200&q=85"
                 alt="Immobilier"
                 onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1200&q=85'">
        </div>
        <div class="da-left-overlay"></div>

        <div class="da-deco-circle da-deco-1"></div>
        <div class="da-deco-circle da-deco-2"></div>
        <div class="da-deco-circle da-deco-3"></div>

        <div class="da-dots">
            <div class="da-dot on"></div>
            <div class="da-dot"></div>
            <div class="da-dot"></div>
        </div>

        <div class="da-left-content">
            <div class="da-badge">
                <i class="fas fa-shield-alt"></i>
                Sécurité du compte
            </div>

            <h1>Protégez vos<br>accès en toute<br>confiance</h1>
            <p>Définissez un mot de passe robuste pour sécuriser votre espace personnel et vos données.</p>

            <a href="{{ url('/') }}" class="da-back">
                <i class="fas fa-arrow-left"></i>
                Retour à l'accueil
            </a>
        </div>
    </div>

    {{-- ── Droite ── --}}
    <div class="da-right">
        <div class="da-card">

            <div class="da-card-icon">
                <i class="fas fa-key"></i>
            </div>
            <h2 class="da-card-title">Définissez vos accès</h2>
            <p class="da-card-sub">Renseignez les informations ci-dessous pour finaliser la configuration de votre compte.</p>

            <form action="{{ route('submitDefineAccess', $email) }}" method="POST" id="accessForm">
                @csrf

                {{-- Email --}}
                <div class="da-field">
                    <div class="da-label">
                        <span>Email</span>
                        <span class="da-label-tag">Verrouillé</span>
                    </div>
                    <input type="text" class="da-input" value="{{ $email }}" readonly name="email">
                    @error('email')
                        <p class="da-err">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Code --}}
                <div class="da-field">
                    <div class="da-label"><span>Code de vérification</span></div>
                    <input type="text" class="da-input" name="code" value="{{ old('code') }}" placeholder="Entrez votre code">
                    @error('code')
                        <p class="da-err">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div class="da-field">
                    <div class="da-label"><span>Nouveau mot de passe</span></div>
                    <div class="da-input-wrap">
                        <input type="password" class="da-input pad-r" id="password" name="password"
                               placeholder="••••••••" oninput="daStrength(this.value)">
                        <button type="button" class="da-eye" onclick="daToggle('password', this)" aria-label="Afficher">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="da-strength">
                        <div class="da-strength-fill" id="daBar"></div>
                    </div>
                    @error('password')
                        <p class="da-err">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmation --}}
                <div class="da-field">
                    <div class="da-label"><span>Confirmer le mot de passe</span></div>
                    <div class="da-input-wrap">
                        <input type="password" class="da-input pad-r" id="confirm_password"
                               name="confirme_password" placeholder="••••••••">
                        <button type="button" class="da-eye" onclick="daToggle('confirm_password', this)" aria-label="Afficher">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('confirme_password')
                        <p class="da-err">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="da-btn" id="daBtn">
                    <span id="daBtnTxt">Valider</span>
                    <div class="da-spinner" id="daSpinner"></div>
                </button>

            </form>

            <hr class="da-divider">
            <div class="da-secure">
                <i class="fas fa-lock"></i>
                Connexion sécurisée par chiffrement TLS
            </div>

        </div>
    </div>

</div>

<script>
function daToggle(id, btn) {
    var inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
    btn.querySelector('i').className = inp.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
}

function daStrength(val) {
    var score = 0;
    if (val.length >= 8)          score++;
    if (/[A-Z]/.test(val))        score++;
    if (/[0-9]/.test(val))        score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    var widths = ['0%', '28%', '54%', '78%', '100%'];
    var colors = ['#dc2626', '#d97706', '#16a34a', '#0d9488', '#0d1f38'];
    var bar = document.getElementById('daBar');
    bar.style.width      = widths[score];
    bar.style.background = colors[score];
}

document.getElementById('accessForm').addEventListener('submit', function () {
    document.getElementById('daBtnTxt').textContent   = 'Validation…';
    document.getElementById('daSpinner').style.display = 'block';
    document.getElementById('daBtn').disabled          = true;
});
</script>

@endsection