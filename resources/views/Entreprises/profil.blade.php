@extends('layouts.master')

@section('content')

<style>
    /* ═══════════════════════════════════════════
    TOKENS — palette header #0b1929 / #16a34a
    ═══════════════════════════════════════════ */
    :root {
        --bg-deep:   #0b1929;
        --bg-card:   #0d1f38;
        --bg-input:  rgba(255,255,255,.05);
        --bg-input-f:rgba(22,163,74,.06);
        --bord:      rgba(255,255,255,.09);
        --bord-f:    #16a34a;

        --gr:        #16a34a;
        --gr-dk:     #15803d;
        --gr-lt:     rgba(22,163,74,.12);
        --gr-glow:   rgba(22,163,74,.32);
        --gr-text:   #4ade80;

        --red:       #ef4444;
        --amber:     #f59e0b;

        --ink:       #ffffff;
        --ink2:      rgba(255,255,255,.72);
        --ink3:      rgba(255,255,255,.38);
        --ink4:      rgba(255,255,255,.18);

        --r-sm:  8px;
        --r:     12px;
        --r-lg:  16px;
        --r-xl:  20px;

        --sh-card: 0 8px 32px rgba(0,0,0,.28), 0 2px 8px rgba(0,0,0,.18);
        --sh-card-hover: 0 12px 40px rgba(0,0,0,.34), 0 4px 12px rgba(0,0,0,.22);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    body {
        font-family: 'Inter', sans-serif;
        color: var(--ink);
        -webkit-font-smoothing: antialiased;
    }

    .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

    /* ═══════════════════════════════════════════
    PAGE HEADER BAND
    ═══════════════════════════════════════════ */
    .ph-band {
        background: var(--bg-deep);
        border-bottom: 1px solid var(--bord);
        padding: 34px 0 30px;
        position: relative;
        overflow: hidden;
    }
    .ph-band::before {
        content: '';
        position: absolute; top: -90px; right: -70px;
        width: 320px; height: 320px; border-radius: 50%;
        background: radial-gradient(circle, rgba(22,163,74,.10), transparent 70%);
        pointer-events: none;
    }
    .ph-band::after {
        content: '';
        position: absolute; bottom: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--gr), var(--gr-text), var(--gr), transparent);
    }
    .ph-inner {
        display: flex; align-items: center; gap: 18px; flex-wrap: wrap;
        position: relative; z-index: 1;
    }
    .ph-avatar {
        width: 62px; height: 62px; border-radius: 17px;
        background: linear-gradient(135deg, var(--gr), #0d9488);
        color: #fff;
        font-size: 24px; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 6px 20px var(--gr-glow);
        border: 1.5px solid rgba(22,163,74,.35);
        position: relative;
    }
    .ph-avatar::after {
        content: '';
        position: absolute; bottom: -3px; right: -3px;
        width: 14px; height: 14px; border-radius: 50%;
        background: var(--gr-text);
        border: 3px solid var(--bg-deep);
    }
    .ph-crumb {
        font-size: 11.5px; font-weight: 500;
        color: var(--ink3); margin-bottom: 6px;
    }
    .ph-crumb a { color: var(--ink3); text-decoration: none; transition: color .18s; }
    .ph-crumb a:hover { color: var(--gr-text); }
    .ph-crumb .sep { margin: 0 6px; opacity: .5; }
    .ph-name {
        font-size: 21px; font-weight: 800;
        color: #fff; letter-spacing: -.02em; margin-bottom: 3px;
    }
    .ph-email {
        font-size: 12.5px; color: var(--ink3); font-weight: 400;
        display: flex; align-items: center; gap: 6px;
    }
    .ph-email i { font-size: 11px; opacity: .7; }
    .ph-badge {
        margin-left: auto;
        display: inline-flex; align-items: center; gap: 7px;
        padding: 7px 15px; border-radius: 30px;
        background: rgba(22,163,74,.15);
        color: var(--gr-text);
        border: 1px solid rgba(74,222,128,.22);
        font-size: 11.5px; font-weight: 700; letter-spacing: .03em;
    }
    .ph-badge .dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: var(--gr-text);
        box-shadow: 0 0 0 3px rgba(74,222,128,.18);
    }

    /* ═══════════════════════════════════════════
    PAGE BODY
    ═══════════════════════════════════════════ */
    .profil-page { padding: 34px 0 72px; }
    .row-gap { display: flex; gap: 24px; flex-wrap: wrap; align-items: flex-start; }
    .col-main { flex: 1 1 62%; min-width: 320px; }
    .col-side { flex: 1 1 34%; min-width: 300px; }

    /* ═══════════════════════════════════════════
    CARD
    ═══════════════════════════════════════════ */
    .pc {
        background: var(--bg-card);
        border-radius: var(--r-xl);
        border: 1px solid var(--bord);
        box-shadow: var(--sh-card);
        overflow: hidden;
        animation: pcIn .45s cubic-bezier(.16,1,.3,1) both;
        transition: box-shadow .25s;
    }
    .pc:hover { box-shadow: var(--sh-card-hover); }
    .pc.d1 { animation-delay: .04s; }
    .pc.d2 { animation-delay: .12s; }
    @keyframes pcIn {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: none; }
    }

    .pc-head {
        padding: 19px 24px 17px;
        border-bottom: 1px solid var(--bord);
        display: flex; align-items: center; gap: 13px;
        background: rgba(0,0,0,.15);
    }
    .pc-head .h-ico {
        width: 38px; height: 38px; border-radius: var(--r-sm);
        background: var(--gr-lt);
        border: 1px solid rgba(22,163,74,.25);
        color: var(--gr-text);
        display: flex; align-items: center; justify-content: center;
        font-size: 15px; flex-shrink: 0;
    }
    .pc-head .h-title { font-size: 14.5px; font-weight: 700; color: #fff; margin: 0; }
    .pc-head .h-sub   { font-size: 11.5px; color: var(--ink3); font-weight: 400; margin-top: 2px; }

    .pc-body { padding: 26px 26px 28px; }

    /* ═══════════════════════════════════════════
    SECTION LABEL
    ═══════════════════════════════════════════ */
    .sec-lbl {
        display: flex; align-items: center; gap: 8px;
        font-size: 10.5px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .1em;
        color: var(--ink3);
        margin: 24px 0 14px;
    }
    .sec-lbl i { color: var(--gr-text); }
    .sec-lbl::after {
        content: ''; flex: 1; height: 1px;
        background: var(--bord);
    }
    .sec-lbl:first-child { margin-top: 0; }

    /* ═══════════════════════════════════════════
    FORM GROUP
    ═══════════════════════════════════════════ */
    .fg { margin-bottom: 18px; }
    .fg:last-of-type { margin-bottom: 26px; }
    .fg label {
        display: block;
        font-size: 10.5px; font-weight: 700;
        color: var(--ink3);
        text-transform: uppercase; letter-spacing: .08em;
        margin-bottom: 7px;
    }
    .fg input[type="text"],
    .fg input[type="email"],
    .fg input[type="password"],
    .fg input[type="number"],
    .fg select,
    .fg textarea {
        display: block; width: 100%;
        padding: 11px 14px;
        border-radius: var(--r);
        border: 1.5px solid rgba(255,255,255,.1);
        background: var(--bg-input);
        font-size: 13.5px; font-weight: 500;
        font-family: 'Inter', sans-serif;
        color: #fff;
        outline: none;
        transition: border-color .2s, background .2s, box-shadow .2s;
        -webkit-appearance: none;
        appearance: none;
    }
    .fg input::placeholder,
    .fg textarea::placeholder { color: var(--ink4); }
    .fg input:focus,
    .fg select:focus,
    .fg textarea:focus {
        border-color: var(--gr);
        background: var(--bg-input-f);
        box-shadow: 0 0 0 3px rgba(22,163,74,.15);
    }
    .fg textarea { min-height: 100px; resize: vertical; }
    .fg .err {
        font-size: 11.5px; color: #f87171;
        font-weight: 600; margin-top: 5px;
        display: flex; align-items: center; gap: 4px;
    }

    /* Select personnalisé (flèche custom, cohérent avec le thème sombre) */
    .select-wrap { position: relative; }
    .select-wrap select {
        padding-right: 36px;
        cursor: pointer;
    }
    .select-wrap::after {
        content: '';
        position: absolute; top: 50%; right: 15px;
        transform: translateY(-60%) rotate(45deg);
        width: 7px; height: 7px;
        border-right: 1.5px solid var(--ink3);
        border-bottom: 1.5px solid var(--ink3);
        pointer-events: none;
        transition: border-color .2s;
    }
    .select-wrap:focus-within::after { border-color: var(--gr-text); }
    .select-wrap select option { background: var(--bg-card); color: #fff; }

    /* Input icône */
    .fi-wrap { position: relative; }
    .fi-wrap .fi-ico {
        position: absolute; top: 50%; left: 13px;
        transform: translateY(-50%);
        color: var(--ink4); font-size: 12px;
        pointer-events: none; transition: color .2s;
    }
    .fi-wrap input { padding-left: 38px; }
    .fi-wrap:focus-within .fi-ico { color: var(--gr-text); }

    /* Mot de passe */
    .pwd-wrap { position: relative; }
    .pwd-wrap input { padding-right: 42px; }
    .pwd-eye {
        position: absolute; top: 50%; right: 12px;
        transform: translateY(-50%);
        background: none; border: none;
        color: var(--ink3); font-size: 13px;
        cursor: pointer; padding: 0; line-height: 1;
        transition: color .2s;
    }
    .pwd-eye:hover { color: var(--gr-text); }

    /* ═══════════════════════════════════════════
    FORCE MOT DE PASSE
    ═══════════════════════════════════════════ */
    .str-bars {
        display: flex; gap: 5px; margin-top: 8px;
    }
    .str-bar {
        height: 4px; border-radius: 3px; flex: 1;
        background: rgba(255,255,255,.1);
        transition: background .25s;
    }
    .str-weak   .str-bar:nth-child(1)                                { background: var(--red); }
    .str-medium .str-bar:nth-child(1),
    .str-medium .str-bar:nth-child(2)                                { background: var(--amber); }
    .str-strong .str-bar:nth-child(1),
    .str-strong .str-bar:nth-child(2),
    .str-strong .str-bar:nth-child(3)                                { background: var(--gr); }

    .str-label {
        font-size: 11px; font-weight: 700;
        margin-top: 5px; display: block;
        color: var(--ink3); transition: color .2s;
    }
    .str-label.weak   { color: var(--red); }
    .str-label.medium { color: var(--amber); }
    .str-label.strong { color: var(--gr-text); }

    /* ═══════════════════════════════════════════
    BOUTONS
    ═══════════════════════════════════════════ */
    .btn-gr {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 12px 26px; border-radius: var(--r);
        border: 1.5px solid var(--gr);
        background: var(--gr); color: #fff;
        font-size: 13.5px; font-weight: 700;
        font-family: 'Inter', sans-serif;
        cursor: pointer; transition: all .2s;
        box-shadow: 0 4px 14px var(--gr-glow);
        letter-spacing: -.01em;
    }
    .btn-gr:hover {
        background: var(--gr-dk); border-color: var(--gr-dk);
        transform: translateY(-2px);
        box-shadow: 0 8px 22px var(--gr-glow);
        color: #fff; text-decoration: none;
    }
    .btn-gr-full { width: 100%; justify-content: center; }

    .btn-outline-gr {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; padding: 12px;
        border-radius: var(--r);
        border: 1.5px solid rgba(22,163,74,.45);
        background: transparent; color: var(--gr-text);
        font-size: 13.5px; font-weight: 700;
        font-family: 'Inter', sans-serif;
        cursor: pointer; transition: all .2s;
        letter-spacing: -.01em;
    }
    .btn-outline-gr:hover {
        background: var(--gr); border-color: var(--gr); color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 22px var(--gr-glow);
    }

    /* ═══════════════════════════════════════════
    ALERTES
    ═══════════════════════════════════════════ */
    .a-ok, .a-warn {
        display: flex; align-items: center; gap: 10px;
        border-radius: var(--r);
        padding: 12px 16px;
        font-size: 13px; font-weight: 600;
        margin-bottom: 20px;
    }
    .a-ok {
        background: rgba(22,163,74,.1);
        border: 1px solid rgba(74,222,128,.25);
        color: var(--gr-text);
    }
    .a-warn {
        background: rgba(245,158,11,.1);
        border: 1px solid rgba(245,158,11,.28);
        color: #fbbf24;
    }

    /* ═══════════════════════════════════════════
    TIPS SÉCURITÉ
    ═══════════════════════════════════════════ */
    .tips-box {
        background: rgba(0,0,0,.2);
        border: 1px solid var(--bord);
        border-radius: var(--r);
        padding: 15px 16px;
        margin-bottom: 20px;
    }
    .tips-head {
        font-size: 10.5px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .09em;
        color: var(--ink3);
        margin-bottom: 11px;
        display: flex; align-items: center; gap: 6px;
    }
    .tips-head i { color: var(--gr-text); }
    .tips-list { list-style: none; padding: 0; margin: 0; }
    .tips-list li {
        display: flex; align-items: flex-start; gap: 9px;
        font-size: 12px; color: var(--ink2); font-weight: 500;
        padding: 6px 0;
        border-bottom: 1px solid rgba(255,255,255,.05);
        line-height: 1.45;
    }
    .tips-list li:last-child { border-bottom: none; padding-bottom: 0; }
    .tips-list li i { color: var(--gr-text); font-size: 10px; margin-top: 2px; flex-shrink: 0; }

    /* ═══════════════════════════════════════════
    RESPONSIVE
    ═══════════════════════════════════════════ */
    @media (max-width: 991px) {
        .row-gap { flex-direction: column; }
        .col-main, .col-side { flex: 1 1 100%; width: 100%; }
    }
    @media (max-width: 767px) {
        .ph-band { padding: 22px 0 18px; }
        .ph-avatar { width: 50px; height: 50px; font-size: 20px; border-radius: 12px; }
        .ph-name { font-size: 17px; }
        .ph-badge { padding: 5px 10px; font-size: 10px; }
        .ph-badge span.txt { display: none; }
        .pc-body { padding: 20px 16px 22px; }
        .pc-head { padding: 15px 16px 13px; }
        .profil-page { padding: 22px 0 50px; }
        .container { padding: 0 14px; }
    }
</style>

{{-- ═══════════════ PAGE HEADER ═══════════════ --}}
<div class="ph-band">
    <div class="container">
        <div class="ph-inner">
            <div class="ph-avatar">
                {{ strtoupper(substr($entreprise->entreprise ?? 'U', 0, 1)) }}
            </div>
            <div class="ph-text">
                <div class="ph-crumb">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Accueil</a>
                    <span class="sep">/</span>
                    <span>Mon profil</span>
                </div>
                <div class="ph-name">{{ $entreprise->entreprise }}</div>
                <div class="ph-email"><i class="fa fa-envelope"></i> {{ $entreprise->user->email }}</div>
            </div>
            <span class="ph-badge">
                <span class="dot"></span> <span class="txt">Compte actif</span>
            </span>
        </div>
    </div>
</div>

<div class="profil-page">
    <div class="container">
        <div class="row-gap">

            {{-- ════════ GAUCHE — Infos profil ════════ --}}
            <div class="col-main">
                <div class="pc d1">

                    <div class="pc-head">
                        <div class="h-ico"><i class="fa fa-user"></i></div>
                        <div>
                            <div class="h-title">Informations du profil</div>
                            <div class="h-sub">Modifiez vos informations personnelles</div>
                        </div>
                    </div>

                    <div class="pc-body">

                        <form action="{{ route('profil.update', ['entreprise' => $entreprise->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $entreprise->id }}">

                            <div class="sec-lbl"><i class="fa fa-user-tag"></i> Profil</div>
                            <div class="fg">
                                <label>Type de profil</label>
                                <div class="select-wrap">
                                    <select name="profil" class="form-control">
                                        <option value="proprietaire" {{ $entreprise->profil == 'proprietaire' ? 'selected' : '' }}>
                                            Propriétaire
                                        </option>
                                        <option value="agence immobiliere" {{ $entreprise->profil == 'agence immobiliere' ? 'selected' : '' }}>
                                            Agence immobilière
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="sec-lbl"><i class="fa fa-briefcase"></i> Représentant</div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fg">
                                        <label>Nom</label>
                                        <div class="fi-wrap">
                                            <i class="fa fa-user fi-ico"></i>
                                            <input type="text" name="nom" value="{{ $entreprise->nom }}" placeholder="Votre nom">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="fg">
                                        <label>Prénom</label>
                                        <div class="fi-wrap">
                                            <i class="fa fa-user fi-ico"></i>
                                            <input type="text" name="prenom" value="{{ $entreprise->prenom }}" placeholder="Votre prénom">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sec-lbl"><i class="fa fa-map-marker"></i> Localisation</div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fg">
                                        <label>Ville</label>
                                        <div class="fi-wrap">
                                            <i class="fa fa-map fi-ico"></i>
                                            <input type="text" name="ville" value="{{ $entreprise->ville }}" placeholder="Cotonou…">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="fg">
                                        <label>Quartier</label>
                                        <div class="fi-wrap">
                                            <i class="fa fa-map-marker fi-ico"></i>
                                            <input type="text" name="quatier" value="{{ $entreprise->quatier }}" placeholder="Quartier">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sec-lbl"><i class="fa fa-address-card"></i> Coordonnées</div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fg">
                                        <label>Téléphone</label>
                                        <div class="fi-wrap">
                                            <i class="fa fa-phone fi-ico"></i>
                                            <input type="number" name="telephone" value="{{ $entreprise->telephone }}" placeholder="+229 00 00 00 00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="fg">
                                        <label>Adresse e-mail</label>
                                        <div class="fi-wrap">
                                            <i class="fa fa-envelope fi-ico"></i>
                                            <input type="email" name="email" value="{{ $entreprise->user->email }}" placeholder="vous@email.com">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            

                            <button type="submit" class="btn-gr">
                                <i class="fa fa-check"></i> Enregistrer les modifications
                            </button>

                        </form>
                    </div>
                </div>
            </div>

            {{-- ════════ DROITE — Mot de passe ════════ --}}
            <div class="col-side">
                <div class="pc d2">

                    <div class="pc-head">
                        <div class="h-ico"><i class="fa fa-lock"></i></div>
                        <div>
                            <div class="h-title">Mot de passe</div>
                            <div class="h-sub">Sécurisez votre compte</div>
                        </div>
                    </div>

                    <div class="pc-body">
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf

                            <div class="fg">
                                <label>Ancien mot de passe</label>
                                <div class="pwd-wrap">
                                    <input type="password" name="old_password" id="f_old"
                                           placeholder="Mot de passe actuel">
                                    <button type="button" class="pwd-eye" onclick="togglePwd('f_old',this)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                @error('old_password')
                                    <div class="err"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="fg">
                                <label>Nouveau mot de passe</label>
                                <div class="pwd-wrap">
                                    <input type="password" name="password" id="f_new"
                                           placeholder="Minimum 8 caractères"
                                           oninput="checkStrength(this.value)">
                                    <button type="button" class="pwd-eye" onclick="togglePwd('f_new',this)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                <div class="str-bars" id="strBars">
                                    <div class="str-bar"></div>
                                    <div class="str-bar"></div>
                                    <div class="str-bar"></div>
                                </div>
                                <span class="str-label" id="strLabel">Saisissez un mot de passe</span>
                                @error('password')
                                    <div class="err"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="fg">
                                <label>Confirmer</label>
                                <div class="pwd-wrap">
                                    <input type="password" name="password_confirmation" id="f_confirm"
                                           placeholder="Répétez le mot de passe">
                                    <button type="button" class="pwd-eye" onclick="togglePwd('f_confirm',this)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <div class="err"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="tips-box">
                                <div class="tips-head">
                                    <i class="fa fa-shield"></i> Conseils de sécurité
                                </div>
                                <ul class="tips-list">
                                    <li><i class="fa fa-check"></i> Minimum 8 caractères</li>
                                    <li><i class="fa fa-check"></i> Mélangez lettres et chiffres</li>
                                    <li><i class="fa fa-check"></i> Ajoutez un symbole (!, @, #…)</li>
                                </ul>
                            </div>

                            <button type="submit" class="btn-outline-gr">
                                <i class="fa fa-lock"></i> Changer le mot de passe
                            </button>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    /* ── Toggle mot de passe ── */
    function togglePwd(id, btn) {
        var inp  = document.getElementById(id);
        var icon = btn.querySelector('i');
        if (inp.type === 'password') {
            inp.type = 'text';
            icon.className = 'fa fa-eye-slash';
        } else {
            inp.type = 'password';
            icon.className = 'fa fa-eye';
        }
    }

    /* ── Force mot de passe (logique corrigée) ──
    score 1 → Faible  (1 barre rouge)
    score 2 → Moyen   (2 barres orange)
    score 3 → Fort    (3 barres vertes)
    ──────────────────────────────────────────── */
    function checkStrength(val) {
        var bars  = document.getElementById('strBars');
        var label = document.getElementById('strLabel');

        var score = 0;
        if (val.length >= 8)                              score++;
        if (/[0-9]/.test(val) && /[a-zA-Z]/.test(val))  score++;
        if (/[^a-zA-Z0-9]/.test(val))                    score++;

        bars.className  = 'str-bars';
        label.className = 'str-label';

        if (val.length === 0) {
            label.textContent = 'Saisissez un mot de passe';
        } else if (score <= 1) {
            bars.classList.add('str-weak');
            label.classList.add('weak');
            label.textContent = '🔴 Faible — trop court ou trop simple';
        } else if (score === 2) {
            bars.classList.add('str-medium');
            label.classList.add('medium');
            label.textContent = '🟡 Moyen — ajoutez un symbole';
        } else {
            bars.classList.add('str-strong');
            label.classList.add('strong');
            label.textContent = '🟢 Fort — excellent mot de passe !';
        }
    }
</script>

@endsection