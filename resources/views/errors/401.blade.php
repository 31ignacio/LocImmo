@extends('errors.layout')

@section('title', 'Non authentifié - LocImmo')

@section('content')
    <div class="error-illustration" id="errorIllustration">
        <img src="" alt="Non authentifié" style="opacity:0;width:100%;height:100%;object-fit:cover;">
        <div class="fallback-emoji" style="display:none;width:100%;height:100%;align-items:center;justify-content:center;font-size:80px;background:rgba(255,255,255,.05);">
            🔐
        </div>
    </div>

    <div class="error-badge">
        <span class="dot"></span>
        Erreur 401
    </div>

    <div class="error-code">
        4<span class="accent">0</span>1
    </div>

    <h1 class="error-title">{{ $title ?? 'Session expirée' }}</h1>

    <p class="error-message">
        {{ $message ?? "Votre session a expiré ou vous devez vous connecter pour accéder à cette page." }}
    </p>

    <div class="error-actions">
        <a href="{{ route('login') }}" class="btn-error primary">
            <i class="fa fa-sign-in"></i> Se connecter
        </a>
        <a href="{{ route('home') }}" class="btn-error secondary">
            <i class="fa fa-home"></i> Accueil
        </a>
        <a href="" class="btn-error outline">
            <i class="fa fa-user-plus"></i> S'inscrire
        </a>
    </div>

    <div class="error-contact">
        <span><i class="fa fa-user-circle" style="margin-right:4px;"></i> <a href="">Créer un compte</a></span>
        <span class="divider"></span>
        <span><i class="fa fa-question-circle" style="margin-right:4px;"></i> <a href="mailto:support@locimmo.com">support@locimmo.com</a></span>
    </div>
@endsection