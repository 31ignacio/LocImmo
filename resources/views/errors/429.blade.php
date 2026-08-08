@extends('errors.layout')

@section('title', 'Trop de requêtes - LocImmo')

@section('content')
    <div class="error-illustration" id="errorIllustration">
        <img src="" alt="Trop de requêtes" style="opacity:0;width:100%;height:100%;object-fit:cover;">
        <div class="fallback-emoji" style="display:none;width:100%;height:100%;align-items:center;justify-content:center;font-size:80px;background:rgba(255,255,255,.05);">
            🐢
        </div>
    </div>

    <div class="error-badge">
        <span class="dot"></span>
        Erreur 429
    </div>

    <div class="error-code">
        4<span class="accent">2</span>9
    </div>

    <h1 class="error-title">{{ $title ?? 'Trop de requêtes' }}</h1>

    <p class="error-message">
        {{ $message ?? "Vous avez effectué trop de requêtes. Veuillez patienter avant de réessayer." }}
    </p>

    <div class="error-actions">
        <a href="javascript:setTimeout(() => location.reload(), 30000)" class="btn-error primary">
            <i class="fa fa-clock-o"></i> Réessayer
            <span class="countdown-ring" id="countdownRing">30</span>
        </a>
        <a href="{{ route('home') }}" class="btn-error secondary">
            <i class="fa fa-home"></i> Accueil
        </a>
    </div>

    <div class="error-contact">
        <span><i class="fa fa-hourglass-half" style="color:var(--gold);margin-right:4px;"></i> Attendez <span id="countdownText">30</span> secondes</span>
        <span class="divider"></span>
        <span><i class="fa fa-support" style="margin-right:4px;"></i> <a href="mailto:support@locimmo.com">support@locimmo.com</a></span>
    </div>

    <script>
        (function() {
            let seconds = 30;
            const ring = document.getElementById('countdownRing');
            const text = document.getElementById('countdownText');

            if (ring && text) {
                const interval = setInterval(() => {
                    seconds--;
                    ring.textContent = seconds;
                    text.textContent = seconds;

                    // Animation du cercle
                    const circumference = 2 * Math.PI * 14;
                    const offset = circumference - (seconds / 30) * circumference;
                    ring.style.strokeDasharray = circumference;
                    ring.style.strokeDashoffset = offset;

                    if (seconds <= 0) {
                        clearInterval(interval);
                        ring.textContent = '✓';
                        text.textContent = '0';
                    }
                }, 1000);
            }
        })();
    </script>
@endsection