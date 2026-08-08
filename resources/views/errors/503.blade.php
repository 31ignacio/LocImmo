@extends('errors.layout')

@section('title', 'Maintenance - LocImmo')

@section('content')
    <div class="error-illustration" id="errorIllustration">
        <img src="" alt="Maintenance" style="opacity:0;width:100%;height:100%;object-fit:cover;">
        <div class="fallback-emoji" style="display:none;width:100%;height:100%;align-items:center;justify-content:center;font-size:80px;background:rgba(255,255,255,.05);">
            🔧
        </div>
    </div>

    <div class="error-badge">
        <span class="dot"></span>
        Erreur 503
    </div>

    <div class="error-code">
        5<span class="accent">0</span>3
    </div>

    <h1 class="error-title">{{ $title ?? 'Site en maintenance' }}</h1>

    <p class="error-message">
        {{ $message ?? "Nous effectuons actuellement une maintenance pour améliorer votre expérience. Nous serons de retour dans quelques instants." }}
    </p>

    <div class="error-actions">
        <a href="javascript:setTimeout(() => location.reload(), 60000)" class="btn-error primary">
            <i class="fa fa-clock-o"></i> Vérifier dans 1 min
        </a>
        <a href="{{ route('home') }}" class="btn-error secondary">
            <i class="fa fa-home"></i> Accueil
        </a>
        <a href="https://twitter.com/locimmo" target="_blank" class="btn-error outline">
            <i class="fa fa-twitter"></i> Suivre @LocImmo
        </a>
    </div>

    <div class="error-contact">
        <span><i class="fa fa-clock-o" style="color:var(--gold);margin-right:4px;"></i> Maintenance en cours</span>
        <span class="divider"></span>
        <span><i class="fa fa-envelope" style="margin-right:4px;"></i> <a href="mailto:support@locimmo.com">support@locimmo.com</a></span>
        <span class="divider"></span>
        <span><i class="fa fa-whatsapp" style="margin-right:4px;color:#25D366;"></i> <a href="https://wa.me/22990000000" target="_blank">WhatsApp</a></span>
    </div>
@endsection