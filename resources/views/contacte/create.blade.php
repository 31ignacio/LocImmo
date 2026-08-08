@extends('layouts.master')

@section('content')

<style>
/* ── PAGE HEADER ── */
.contact-hero {
    background: linear-gradient(135deg, #0b1929 0%, #0d1f38 60%, #16a34a 180%);
    padding: 60px 0 50px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.contact-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 240px; height: 240px;
    border-radius: 50%;
    background: rgba(22,163,74,0.10);
    pointer-events: none;
}
.contact-hero::after {
    content: '';
    position: absolute;
    bottom: -40px; left: -40px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: rgba(13,148,136,0.08);
    pointer-events: none;
}
.contact-hero h1 {
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    margin: 0 0 8px;
    letter-spacing: -0.03em;
    position: relative; z-index: 1;
}
.contact-hero h1 i {
    color: #4ade80;
    opacity: .85;
    margin-right: 10px;
    font-size: 1.6rem;
}
.contact-hero p {
    font-size: 15px;
    color: rgba(255,255,255,0.45);
    margin: 0;
    position: relative; z-index: 1;
}

/* ── LAYOUT ── */
.contact-section {
    background: #f0f2f7;
    padding: 50px 0 70px;
}
.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1.6fr;
    gap: 28px;
    align-items: start;
}

/* ── INFO CARD (reste en sombre pour le contraste) ── */
.contact-info-card {
    background: #0d1f38;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(11,25,41,0.22);
    border: 1px solid rgba(255,255,255,.07);
}
.contact-info-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
    opacity: .88;
}
.contact-info-body {
    padding: 24px;
}
.contact-info-body p {
    font-size: 13.5px;
    color: rgba(255,255,255,.42);
    line-height: 1.75;
    margin: 0 0 22px;
}
.contact-info-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 16px;
}
.contact-info-item:last-child { margin-bottom: 0; }
.contact-info-ico {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: rgba(22,163,74,.14);
    border: 1px solid rgba(22,163,74,.25);
    color: #4ade80;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}
.contact-info-txt strong {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: rgba(255,255,255,.38);
    text-transform: uppercase;
    letter-spacing: .07em;
    margin-bottom: 3px;
}
.contact-info-txt span {
    font-size: 13.5px;
    color: rgba(255,255,255,.75);
    font-weight: 500;
}

/* ── FORM CARD — fond clair ── */
.contact-form-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 32px;
    box-shadow: 0 4px 24px rgba(17,24,39,0.06);
    border: 1px solid #e8ecf1;
}
.contact-form-card h4 {
    font-size: 1.1rem;
    font-weight: 800;
    color: #0d1f38;
    margin: 0 0 5px;
    letter-spacing: -0.02em;
}
.contact-form-card .form-subtitle {
    font-size: 12.5px;
    color: #8a94a6;
    margin: 0 0 26px;
}

.form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.cf-group { margin-bottom: 18px; }
.cf-group label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: #6b7280;
    margin-bottom: 7px;
}
.cf-inp-wrap {
    display: flex;
    align-items: center;
    background: #f7f9fc;
    border: 1.5px solid #e8ecf1;
    border-radius: 10px;
    overflow: hidden;
    transition: all .2s;
}
.cf-inp-wrap:focus-within {
    border-color: #16a34a;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(22,163,74,.12);
}
.cf-inp-wrap.border-danger {
    border-color: #f87171;
    background: #fff5f5;
}
.cf-ico {
    width: 38px;
    display: flex; align-items: center; justify-content: center;
    color: #b7c0cc;
    font-size: 13px;
    flex-shrink: 0;
}
.cf-inp-wrap:focus-within .cf-ico { color: #16a34a; }
.cf-inp {
    flex: 1;
    border: none;
    background: transparent;
    padding: 11px 10px 11px 0;
    font-size: 13.5px;
    color: #0d1f38;
    outline: none;
    font-family: inherit;
}
.cf-inp::placeholder { color: #b7c0cc; }
.cf-textarea {
    width: 100%;
    border: none;
    background: transparent;
    padding: 11px 14px;
    font-size: 13.5px;
    color: #0d1f38;
    outline: none;
    resize: vertical;
    min-height: 130px;
    font-family: inherit;
}
.cf-textarea::placeholder { color: #b7c0cc; }

/* Erreurs */
.cf-error {
    font-size: 11px;
    color: #dc2626;
    font-weight: 600;
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Bouton submit */
.btn-submit {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 12px;
    background: #16a34a;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    transition: all .2s;
    box-shadow: 0 4px 16px rgba(22,163,74,.28);
    font-family: inherit;
    margin-top: 6px;
}
.btn-submit:hover:not(:disabled) {
    background: #15803d;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(22,163,74,.38);
}
.btn-submit:disabled {
    opacity: .6;
    cursor: not-allowed;
    transform: none;
}
.btn-submit .btn-loader { display: none; }
.btn-submit.loading .btn-text   { display: none; }
.btn-submit.loading .btn-loader { display: flex; align-items: center; gap: 8px; }

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
    .contact-grid { grid-template-columns: 1fr; }
    .contact-form-card { padding: 22px 16px; }
}
@media (max-width: 500px) {
    .form-row-2 { grid-template-columns: 1fr; }
    .contact-hero { padding: 44px 0 36px; }
    .contact-hero h1 { font-size: 1.5rem; }
}
</style>

{{-- ══ HERO ══ --}}
<div class="contact-hero">
    <div class="container">
        <h1><i class="fa fa-envelope"></i>Contactez-nous</h1>
        <p>Notre équipe est là pour répondre à toutes vos questions</p>
    </div>
</div>

{{-- ══ SECTION ══ --}}
<div class="contact-section">
    <div class="container">
        <div class="contact-grid">

            {{-- ── COLONNE INFO ── --}}
            <div class="contact-info-card">
                <img src="{{ asset('contacte.jpg') }}" alt="Contact" class="contact-info-img">
                <div class="contact-info-body">
                    <p>
                        Nous sommes là pour vous aider ! N'hésitez pas à nous contacter pour toute question,
                        suggestion ou difficulté liée à l'utilisation du site. Notre équipe vous répondra dans les plus brefs délais.
                    </p>

                    <div class="contact-info-item">
                        <div class="contact-info-ico"><i class="fa fa-map-marker"></i></div>
                        <div class="contact-info-txt">
                            <strong>Adresse</strong>
                            <span>Cotonou, Bénin</span>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-ico"><i class="fa fa-envelope"></i></div>
                        <div class="contact-info-txt">
                            <strong>Email</strong>
                            <span>contact@immoloc.bj</span>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-ico"><i class="fa fa-phone"></i></div>
                        <div class="contact-info-txt">
                            <strong>Téléphone</strong>
                            <span>+229 00 00 00 00</span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ── FORMULAIRE ── --}}
            <div class="contact-form-card">
                <h4>Envoyez-nous un message</h4>
                <p class="form-subtitle">Tous les champs sont obligatoires</p>

                <form id="contactForm" method="POST" action="{{ route('contacte.store') }}">
                    @csrf

                    <div class="form-row-2">
                        <div class="cf-group">
                            <label>Nom</label>
                            <div class="cf-inp-wrap @error('nom') border-danger @enderror">
                                <div class="cf-ico"><i class="fa fa-user"></i></div>
                                <input type="text" name="nom" class="cf-inp"
                                    placeholder="Votre nom" value="{{ old('nom') }}" required>
                            </div>
                            @error('nom')
                                <div class="cf-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="cf-group">
                            <label>Prénom</label>
                            <div class="cf-inp-wrap @error('prenom') border-danger @enderror">
                                <div class="cf-ico"><i class="fa fa-user"></i></div>
                                <input type="text" name="prenom" class="cf-inp"
                                    placeholder="Votre prénom" value="{{ old('prenom') }}" required>
                            </div>
                            @error('prenom')
                                <div class="cf-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="cf-group">
                            <label>Email</label>
                            <div class="cf-inp-wrap @error('email') border-danger @enderror">
                                <div class="cf-ico"><i class="fa fa-envelope"></i></div>
                                <input type="email" name="email" class="cf-inp"
                                    placeholder="votre@email.com" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <div class="cf-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="cf-group">
                            <label>Sujet</label>
                            <div class="cf-inp-wrap @error('sujet') border-danger @enderror">
                                <div class="cf-ico"><i class="fa fa-tag"></i></div>
                                <input type="text" name="sujet" class="cf-inp"
                                    placeholder="Objet du message" value="{{ old('sujet') }}" required>
                            </div>
                            @error('sujet')
                                <div class="cf-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="cf-group">
                        <label>Message</label>
                        <div class="cf-inp-wrap @error('message') border-danger @enderror"
                            style="align-items:flex-start;padding-top:4px">
                            <div class="cf-ico" style="padding-top:8px">
                                <i class="fa fa-comment"></i>
                            </div>
                            <textarea name="message" class="cf-textarea"
                                placeholder="Écrivez votre message ici..." required>{{ old('message') }}</textarea>
                        </div>
                        @error('message')
                            <div class="cf-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="btn-text">
                            <i class="fa fa-paper-plane"></i> Envoyer le message
                        </span>
                        <span class="btn-loader">
                            <i class="fa fa-spinner fa-spin"></i> Envoi en cours...
                        </span>
                    </button>

                </form>
            </div>

        </div>
    </div>
</div>

<script>
document.getElementById('contactForm').addEventListener('submit', function () {
    var btn = document.getElementById('submitBtn');
    btn.classList.add('loading');
    btn.disabled = true;
});
</script>

@endsection