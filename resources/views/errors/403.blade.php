@extends('errors.layout')

@section('title', 'Accès interdit - LocImmo')

@section('content')
    <div class="error-illustration" id="errorIllustration">
        <img src="" alt="Accès interdit" style="opacity:0;width:100%;height:100%;object-fit:cover;">
        <div class="fallback-emoji" style="display:none;width:100%;height:100%;align-items:center;justify-content:center;font-size:80px;background:rgba(255,255,255,.05);">
            🚫
        </div>
    </div>

    <div class="error-badge">
        <span class="dot"></span>
        Erreur 403
    </div>

    <div class="error-code">
        4<span class="accent">0</span>3
    </div>

    <h1 class="error-title">{{ $title ?? 'Accès interdit' }}</h1>

    <p class="error-message">
        {{ $message ?? "Vous n'avez pas l'autorisation d'accéder à cette page." }}
    </p>

    <div class="error-actions">
        <a href="{{ route('home') }}" class="btn-error primary">
            <i class="fa fa-home"></i> Accueil
        </a>
        @auth
            <a href="{{ route('entreprise.espace') }}" class="btn-error secondary">
                <i class="fa fa-dashboard"></i> Mon espace
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-error secondary">
                <i class="fa fa-sign-in"></i> Se connecter
            </a>
        @endauth
        <a href="javascript:history.back()" class="btn-error outline">
            <i class="fa fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="error-contact">
        <span><i class="fa fa-lock" style="margin-right:4px;"></i> <a href="mailto:support@locimmo.com">support@locimmo.com</a></span>
        <span class="divider"></span>
        <span><i class="fa fa-info-circle" style="margin-right:4px;"></i> <a href="">Nous contacter</a></span>
    </div>
@endsection