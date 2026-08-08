@extends('errors.layout')

@section('title', 'Page non trouvée - LocImmo')

@section('content')
    {{-- ILLUSTRATION --}}
    <div class="error-illustration" id="errorIllustration">
        <img src="" alt="Page non trouvée" style="opacity:0;width:100%;height:100%;object-fit:cover;">
        <div class="fallback-emoji" style="display:none;width:100%;height:100%;align-items:center;justify-content:center;font-size:80px;background:rgba(255,255,255,.05);">
            🔍
        </div>
    </div>

    {{-- BADGE --}}
    <div class="error-badge">
        <span class="dot"></span>
        Erreur 404
    </div>

    {{-- CODE --}}
    <div class="error-code">
        4<span class="accent">0</span>4
    </div>

    {{-- TITRE --}}
    <h1 class="error-title">{{ $title ?? 'Page non trouvée' }}</h1>

    {{-- MESSAGE --}}
    <p class="error-message">
        {{ $message ?? "Désolé, la page que vous cherchez n'existe pas ou a été déplacée." }}
    </p>

    {{-- ACTIONS --}}
    <div class="error-actions">
        <a href="{{ route('home') }}" class="btn-error primary">
            <i class="fa fa-home"></i> Accueil
        </a>
        <a href="javascript:history.back()" class="btn-error secondary">
            <i class="fa fa-arrow-left"></i> Retour
        </a>
        <a href="{{ route('annonce.all') }}" class="btn-error outline">
            <i class="fa fa-search"></i> Voir les annonces
        </a>
    </div>

    {{-- CONTACT --}}
    <div class="error-contact">
        <span><i class="fa fa-envelope" style="margin-right:4px;"></i> <a href="mailto:support@locimmo.com">support@locimmo.com</a></span>
        <span class="divider"></span>
        <span><i class="fa fa-phone" style="margin-right:4px;"></i> <a href="tel:+22990000000">+229 90 00 00 00</a></span>
        <span class="divider"></span>
        <span><i class="fa fa-whatsapp" style="margin-right:4px;color:#25D366;"></i> <a href="https://wa.me/22990000000" target="_blank">WhatsApp</a></span>
    </div>
@endsection