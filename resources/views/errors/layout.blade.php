<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LocImmo - Erreur')</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* ════════ BASE ════════ */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0d1f38;
            --primary-light: #1a3355;
            --primary-dark: #081528;
            --accent: #FF385C;
            --accent2: #E31C5F;
            --gold: #F59E0B;
            --gold-light: #FEF3C7;
            --white: #FFFFFF;
            --ink: #1A1A2E;
            --ink2: #2D2D44;
            --ink3: #6B7280;
            --ink4: #9CA3AF;
            --border: rgba(255, 255, 255, .12);
            --bg: #F4F6FA;
            --shadow: 0 20px 60px rgba(13, 31, 56, .25);
            --r: 12px;
            --r-xl: 24px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--white);
            -webkit-font-smoothing: antialiased;
            overflow: hidden;
        }

        /* ════ FOND ANIMÉ ════ */
        .error-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            background: var(--primary);
        }

        .error-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255, 56, 92, .08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(245, 158, 11, .06) 0%, transparent 40%),
                radial-gradient(circle at 50% 80%, rgba(255, 56, 92, .05) 0%, transparent 50%);
            animation: pulseBg 8s ease-in-out infinite alternate;
        }

        @keyframes pulseBg {
            0% { opacity: .5; transform: scale(1); }
            100% { opacity: 1; transform: scale(1.1); }
        }

        /* ════ PARTICULES ════ */
        .particles {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, .06);
            border-radius: 50%;
            animation: floatParticle 20s infinite linear;
        }

        .particle:nth-child(1) { left: 5%; animation-duration: 22s; animation-delay: 0s; width: 6px; height: 6px; }
        .particle:nth-child(2) { left: 15%; animation-duration: 18s; animation-delay: 2s; }
        .particle:nth-child(3) { left: 25%; animation-duration: 25s; animation-delay: 4s; width: 8px; height: 8px; opacity: .04; }
        .particle:nth-child(4) { left: 35%; animation-duration: 20s; animation-delay: 1s; }
        .particle:nth-child(5) { left: 45%; animation-duration: 23s; animation-delay: 3s; width: 5px; height: 5px; }
        .particle:nth-child(6) { left: 55%; animation-duration: 19s; animation-delay: 5s; }
        .particle:nth-child(7) { left: 65%; animation-duration: 24s; animation-delay: 2.5s; width: 7px; height: 7px; opacity: .04; }
        .particle:nth-child(8) { left: 75%; animation-duration: 21s; animation-delay: 4.5s; }
        .particle:nth-child(9) { left: 85%; animation-duration: 17s; animation-delay: 1.5s; width: 5px; height: 5px; }
        .particle:nth-child(10) { left: 95%; animation-duration: 26s; animation-delay: 3.5s; }
        .particle:nth-child(11) { left: 10%; animation-duration: 20s; animation-delay: 6s; width: 9px; height: 9px; opacity: .03; }
        .particle:nth-child(12) { left: 40%; animation-duration: 22s; animation-delay: 7s; }
        .particle:nth-child(13) { left: 70%; animation-duration: 18s; animation-delay: 4s; width: 6px; height: 6px; }
        .particle:nth-child(14) { left: 90%; animation-duration: 24s; animation-delay: 5.5s; }
        .particle:nth-child(15) { left: 50%; animation-duration: 21s; animation-delay: 8s; width: 7px; height: 7px; opacity: .04; }

        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) rotate(0deg) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
                transform: translateY(90vh) rotate(36deg) scale(1);
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-10vh) rotate(360deg) scale(0);
                opacity: 0;
            }
        }

        /* ════ CONTAINER ════ */
        .error-wrap {
            position: relative;
            z-index: 1;
            max-width: 640px;
            width: 100%;
            background: rgba(255, 255, 255, .05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--r-xl);
            padding: 48px 40px 40px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, .08);
            box-shadow: var(--shadow);
            animation: slideUp .5s cubic-bezier(.16, 1, .3, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px) scale(.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ════ LOGO ════ */
        .error-logo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 20px;
            font-weight: 800;
            color: var(--white);
            text-decoration: none;
            margin-bottom: 24px;
            letter-spacing: -.02em;
        }

        .error-logo i {
            color: var(--accent);
            font-size: 22px;
        }

        .error-logo span {
            color: var(--accent);
        }

        /* ════ ILLUSTRATION ════ */
        .error-illustration {
            width: 200px;
            height: 200px;
            margin: 0 auto 20px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            border: 3px solid rgba(255, 255, 255, .1);
            box-shadow: 0 0 60px rgba(255, 56, 92, .1);
            transition: all .4s ease;
        }

        .error-illustration:hover {
            transform: scale(1.02);
            border-color: rgba(255, 56, 92, .3);
            box-shadow: 0 0 80px rgba(255, 56, 92, .15);
        }

        .error-illustration img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .6s ease;
        }

        .error-illustration:hover img {
            transform: scale(1.05);
        }

        .error-illustration .fallback-emoji {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
            background: rgba(255, 255, 255, .05);
        }

        /* ════ BADGE ERREUR ════ */
        .error-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 16px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .1em;
            background: rgba(255, 56, 92, .15);
            color: var(--accent);
            border: 1px solid rgba(255, 56, 92, .2);
            margin-bottom: 12px;
        }

        .error-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent);
            animation: pulseDot 1.5s ease-in-out infinite;
        }

        @keyframes pulseDot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .3; transform: scale(.6); }
        }

        /* ════ CODE ════ */
        .error-code {
            font-size: 88px;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -.06em;
            line-height: 1;
            margin-bottom: 4px;
            text-shadow: 0 4px 40px rgba(0, 0, 0, .2);
        }

        .error-code .accent {
            color: var(--accent);
            background: linear-gradient(135deg, var(--accent), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ════ TITRE ════ */
        .error-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--white);
            margin: 8px 0 6px;
        }

        .error-message {
            font-size: 15px;
            color: rgba(255, 255, 255, .6);
            line-height: 1.7;
            max-width: 440px;
            margin: 0 auto 24px;
        }

        /* ════ ACTIONS ════ */
        .error-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-top: 4px;
        }

        .btn-error {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: var(--r);
            font-size: 14px;
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
            text-decoration: none;
            transition: all .25s cubic-bezier(.16, 1, .3, 1);
            border: none;
            cursor: pointer;
        }

        .btn-error:hover {
            transform: translateY(-3px);
        }

        .btn-error:active {
            transform: scale(.96);
        }

        .btn-error.primary {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #fff;
            box-shadow: 0 4px 20px rgba(255, 56, 92, .3);
        }

        .btn-error.primary:hover {
            box-shadow: 0 8px 32px rgba(255, 56, 92, .45);
        }

        .btn-error.secondary {
            background: rgba(255, 255, 255, .08);
            color: var(--white);
            border: 1.5px solid rgba(255, 255, 255, .12);
            backdrop-filter: blur(10px);
        }

        .btn-error.secondary:hover {
            background: rgba(255, 255, 255, .15);
            border-color: rgba(255, 255, 255, .25);
        }

        .btn-error.outline {
            background: transparent;
            color: var(--white);
            border: 1.5px solid rgba(255, 255, 255, .15);
        }

        .btn-error.outline:hover {
            background: rgba(255, 255, 255, .05);
            border-color: rgba(255, 255, 255, .3);
        }

        /* ════ CONTACT ════ */
        .error-contact {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, .06);
            font-size: 13px;
            color: rgba(255, 255, 255, .4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .error-contact a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: color .2s;
        }

        .error-contact a:hover {
            color: var(--gold);
            text-decoration: underline;
        }

        .error-contact .divider {
            width: 1px;
            height: 16px;
            background: rgba(255, 255, 255, .08);
        }

        /* ════ COUNTDOWN ════ */
        .countdown-ring {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, .1);
            font-size: 14px;
            font-weight: 700;
            color: var(--gold);
            margin-right: 4px;
        }

        /* ════ RESPONSIVE ════ */
        @media (max-width: 640px) {
            .error-wrap {
                padding: 32px 20px 28px;
                margin: 10px;
            }

            .error-code {
                font-size: 60px;
            }

            .error-illustration {
                width: 140px;
                height: 140px;
            }

            .error-illustration .fallback-emoji {
                font-size: 56px;
            }

            .error-title {
                font-size: 20px;
            }

            .error-message {
                font-size: 14px;
            }

            .btn-error {
                padding: 10px 20px;
                font-size: 13px;
                width: 100%;
                justify-content: center;
            }

            .error-logo {
                font-size: 17px;
            }

            .error-contact {
                flex-direction: column;
                gap: 8px;
            }

            .error-contact .divider {
                display: none;
            }
        }

        @media (max-width: 400px) {
            .error-wrap {
                padding: 24px 16px 20px;
            }

            .error-code {
                font-size: 48px;
            }

            .error-illustration {
                width: 120px;
                height: 120px;
            }

            .error-illustration .fallback-emoji {
                font-size: 48px;
            }

            .error-title {
                font-size: 17px;
            }
        }

        /* ════ SCROLLBAR ════ */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .15);
            border-radius: 2px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, .25);
        }
    </style>
</head>
<body>

    {{-- FOND --}}
    <div class="error-bg">
        <div class="particles">
            <div class="particle"></div><div class="particle"></div><div class="particle"></div>
            <div class="particle"></div><div class="particle"></div><div class="particle"></div>
            <div class="particle"></div><div class="particle"></div><div class="particle"></div>
            <div class="particle"></div><div class="particle"></div><div class="particle"></div>
            <div class="particle"></div><div class="particle"></div><div class="particle"></div>
        </div>
    </div>

    {{-- CONTENU --}}
    <div class="error-wrap">

        {{-- LOGO --}}
        <a href="{{ route('home') }}" class="error-logo">
            <i class="fa fa-home"></i>
            Loc<span>Immo</span>
        </a>

        @yield('content')
    </div>

    {{-- SCRIPTS POUR IMAGES DYNAMIQUES --}}
    <script>
        (function() {
            'use strict';

            // ══════════════════════════════════════
            // BANQUE D'IMAGES IMMOBILIÈRES
            // ══════════════════════════════════════
            const REAL_ESTATE_IMAGES = [
                // Maisons / Villas
                'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800&q=80',
                'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&q=80',
                'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=800&q=80',
                'https://images.unsplash.com/photo-1576941089067-2de3c901e126?w=800&q=80',
                'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&q=80',
                'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&q=80',
                
                // Appartements / Intérieurs
                'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&q=80',
                'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800&q=80',
                'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=800&q=80',
                'https://images.unsplash.com/photo-1600607687644-c7171b42498f?w=800&q=80',
                'https://images.unsplash.com/photo-1618220179428-22790b461013?w=800&q=80',
                'https://images.unsplash.com/photo-1616137466211-f939a420be84?w=800&q=80',
                
                // Terrains / Extérieurs
                'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800&q=80',
                'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800&q=80',
                'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=800&q=80',
                'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=800&q=80',
                
                // Bureaux / Commerces
                'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80',
                'https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=800&q=80',
                'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800&q=80',
                
                // Luxe / Premium
                'https://images.unsplash.com/photo-1616137466211-f939a420be84?w=800&q=80',
                'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800&q=80',
            ];

            // ══════════════════════════════════════
            // FONCTION POUR OBTENIR UNE IMAGE ALÉATOIRE
            // ══════════════════════════════════════
            function getRandomImage() {
                return REAL_ESTATE_IMAGES[Math.floor(Math.random() * REAL_ESTATE_IMAGES.length)];
            }

            // ══════════════════════════════════════
            // CHARGER L'IMAGE DANS L'ILLUSTRATION
            // ══════════════════════════════════════
            function loadErrorImage() {
                const illustration = document.querySelector('.error-illustration');
                if (!illustration) return;

                const img = illustration.querySelector('img');
                const fallback = illustration.querySelector('.fallback-emoji');

                // Si une image est déjà présente, la remplacer
                if (img) {
                    // Ajouter un effet de transition
                    img.style.opacity = '0';
                    img.style.transition = 'opacity .6s ease';

                    // Charger la nouvelle image
                    const newSrc = getRandomImage();
                    const tempImg = new Image();
                    tempImg.onload = function() {
                        img.src = newSrc;
                        img.style.opacity = '1';
                        if (fallback) fallback.style.display = 'none';
                    };
                    tempImg.onerror = function() {
                        // Fallback sur l'emoji
                        if (fallback) {
                            fallback.style.display = 'flex';
                            img.style.display = 'none';
                        }
                    };
                    tempImg.src = newSrc;
                } else if (fallback) {
                    // Si pas d'img, afficher l'emoji
                    fallback.style.display = 'flex';
                }
            }

            // ══════════════════════════════════════
            // CHARGER UNE NOUVELLE IMAGE À INTERVALLES
            // ══════════════════════════════════════
            let intervalId = null;

            function startImageRotation() {
                // Changer l'image toutes les 8 secondes
                intervalId = setInterval(function() {
                    loadErrorImage();
                }, 8000);
            }

            function stopImageRotation() {
                if (intervalId) {
                    clearInterval(intervalId);
                    intervalId = null;
                }
            }

            // ══════════════════════════════════════
            // INITIALISATION
            // ══════════════════════════════════════
            document.addEventListener('DOMContentLoaded', function() {
                // Charger une première image
                setTimeout(function() {
                    loadErrorImage();
                }, 300);

                // Démarrer la rotation
                startImageRotation();

                // Arrêter la rotation au survol
                const illustration = document.querySelector('.error-illustration');
                if (illustration) {
                    illustration.addEventListener('mouseenter', stopImageRotation);
                    illustration.addEventListener('mouseleave', function() {
                        // Redémarrer après un court délai
                        setTimeout(startImageRotation, 2000);
                    });
                }

                // Rafraîchir l'image quand l'utilisateur revient sur la page
                document.addEventListener('visibilitychange', function() {
                    if (!document.hidden) {
                        loadErrorImage();
                    }
                });
            });

            // ══════════════════════════════════════
            // EXPOSER LA FONCTION GLOBALEMENT
            // ══════════════════════════════════════
            window.refreshErrorImage = loadErrorImage;
            window.getRandomRealEstateImage = getRandomImage;

        })();
    </script>

</body>
</html>