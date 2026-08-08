@extends('errors.layout')

@section('title', 'Session expirée - LocImmo')

@section('content')
    <div class="error-illustration" id="errorIllustration">
        <img src="" alt="Session expirée" style="opacity:0;width:100%;height:100%;object-fit:cover;">
        <div class="fallback-emoji" style="display:none;width:100%;height:100%;align-items:center;justify-content:center;font-size:80px;background:rgba(255,255,255,.05);">
            ⏰
        </div>
    </div>

    <div class="error-badge">
        <span class="dot"></span>
        Erreur 419
    </div>

    <div class="error-code">
        4<span class="accent">1</span>9
    </div>

    <h1 class="error-title">{{ $title ?? 'Session expirée' }}</h1>

    <p class="error-message">
        {{ $message ?? "Votre session a expiré pour des raisons de sécurité. Veuillez rafraîchir la page et réessayer." }}
    </p>

    <div class="error-actions">
        <a href="javascript:location.reload()" class="btn-error primary">
            <i class="fa fa-refresh"></i> Rafraîchir
        </a>
        <a href="{{ route('home') }}" class="btn-error secondary">
            <i class="fa fa-home"></i> Accueil
        </a>
        <a href="{{ route('login') }}" class="btn-error outline">
            <i class="fa fa-sign-in"></i> Se reconnecter
        </a>
    </div>

    <div class="error-contact">
        <span><i class="fa fa-exclamation-triangle" style="color:var(--gold);margin-right:4px;"></i> <a href="mailto:support@locimmo.com">support@locimmo.com</a></span>
        <span class="divider"></span>
        <span><i class="fa fa-shield" style="margin-right:4px;"></i> Sécurité renforcée</span>
    </div>
@endsection