@extends('errors.layout')

@section('title', 'Erreur serveur - LocImmo')

@section('content')
    <div class="error-illustration" id="errorIllustration">
        <img src="" alt="Erreur serveur" style="opacity:0;width:100%;height:100%;object-fit:cover;">
        <div class="fallback-emoji" style="display:none;width:100%;height:100%;align-items:center;justify-content:center;font-size:80px;background:rgba(255,255,255,.05);">
            ⚡
        </div>
    </div>

    <div class="error-badge">
        <span class="dot"></span>
        Erreur 500
    </div>

    <div class="error-code">
        5<span class="accent">0</span>0
    </div>

    <h1 class="error-title">{{ $title ?? 'Erreur interne du serveur' }}</h1>

    <p class="error-message">
        {{ $message ?? "Quelque chose s'est mal passé. Notre équipe technique a été notifiée et travaille sur le problème." }}
    </p>

    <div class="error-actions">
        <a href="javascript:location.reload()" class="btn-error primary">
            <i class="fa fa-refresh"></i> Réessayer
        </a>
        <a href="{{ route('home') }}" class="btn-error secondary">
            <i class="fa fa-home"></i> Accueil
        </a>
        <a href="{{ route('annonce.all') }}" class="btn-error outline">
            <i class="fa fa-search"></i> Voir les annonces
        </a>
    </div>

    <div class="error-contact">
        <span><i class="fa fa-exclamation-triangle" style="color:var(--gold);margin-right:4px;"></i> Nous nous excusons pour la gêne</span>
        <span class="divider"></span>
        <span><i class="fa fa-envelope" style="margin-right:4px;"></i> <a href="mailto:support@locimmo.com">support@locimmo.com</a></span>
        <span class="divider"></span>
        <span><i class="fa fa-twitter" style="margin-right:4px;color:#1DA1F2;"></i> <a href="https://twitter.com/locimmo" target="_blank">@LocImmo</a></span>
    </div>
@endsection