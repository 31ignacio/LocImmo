
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LOC</title>
    <meta name="description" content="GARO is a real-estate template">
    <meta name="author" content="Kimarotec">
    <meta name="keyword" content="html5, css, bootstrap, property, real-estate theme , bootstrap template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Récupérer le jeton CSRF -->

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontello.css') }}">
    <link href="{{ asset('assets/fonts/icon-7-stroke/css/pe-icon-7-stroke.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fonts/icon-7-stroke/css/helper.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/animate.css" rel="stylesheet') }}" media="screen">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icheck.min_all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/price-range.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.css') }}">  
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.transitions.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lightslider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/wizard.css') }}"> 
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

    <body>

        <div id="preloader">
            <div id="status">&nbsp;</div>
        </div>

        <div>

        @yield('content')

        </div>

        <!-- Footer area-->


        <script src="{{ asset('assets/js/modernizr-2.6.2.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery-1.10.2.min.js') }}"></script>
        <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-hover-dropdown.js') }}"></script>
        <script src="{{ asset('assets/js/easypiechart.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.easypiechart.min.js') }}"></script>
        <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>   
        <script src="{{ asset('assets/js/wow.js') }}"></script>
        <script src="{{ asset('assets/js/icheck.min.js') }}"></script>
        <script src="{{ asset('assets/js/price-range.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/lightslider.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/wizard.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>


        <script>
            $(document).ready(function () {

                $('#image-gallery').lightSlider({
                    gallery: true,
                    item: 1,
                    thumbItem: 9,
                    slideMargin: 0,
                    speed: 500,
                    auto: true,
                    loop: true,
                    onSliderLoad: function () {
                        $('#image-gallery').removeClass('cS-hidden');
                    }
                });
            });
        </script>

        
        <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 14px;"></div>

        <style>
            .toast-modern {
                display: flex;
                align-items: flex-start;
                gap: 14px;
                min-width: 300px;
                max-width: 380px;
                padding: 16px 18px;
                border-radius: 16px;
                background: #ffffff;
                box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 10px 28px rgba(0,0,0,0.12);
                position: relative;
                overflow: hidden;
                opacity: 0;
            }

            .toast-modern.toast-show {
                animation: toastIn 0.55s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
            }

            .toast-modern.toast-hide {
                animation: toastOut 0.35s ease forwards;
            }

            @keyframes toastIn {
                0%   { opacity: 0; transform: translateX(50px) scale(0.96); }
                60%  { transform: translateX(-4px) scale(1.01); }
                100% { opacity: 1; transform: translateX(0) scale(1); }
            }

            @keyframes toastOut {
                to { opacity: 0; transform: translateX(50px) scale(0.96); }
            }

            .toast-modern .toast-icon {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                animation: iconPulse 0.5s ease 0.55s;
            }

            @keyframes iconPulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.12); }
            }

            .toast-success .toast-icon { background: #0d1f38; }
            .toast-error .toast-icon { background: #dc3545; }

            .toast-modern .toast-icon i {
                font-size: 17px;
                color: #fff;
            }

            .toast-modern .toast-body {
                flex: 1;
                min-width: 0;
                padding-top: 2px;
            }

            .toast-modern .toast-title {
                font-family: "Poppins", sans-serif;
                font-size: 14px;
                font-weight: 600;
                color: #1a1a1a;
                margin: 0 0 3px;
            }

            .toast-modern .toast-message {
                font-family: "Poppins", sans-serif;
                font-size: 13px;
                line-height: 1.5;
                color: #6b6b6b;
                margin: 0;
            }

            .toast-modern .toast-close {
                cursor: pointer;
                font-size: 16px;
                color: #c2c2c2;
                flex-shrink: 0;
                margin-top: 2px;
                transition: color 0.2s;
                line-height: 1;
                background: none;
                border: none;
            }

            .toast-modern .toast-close:hover {
                color: #6b6b6b;
            }

            .toast-modern .toast-bar-track {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 3px;
            }

            .toast-success .toast-bar-track { background: rgba(13, 31, 56, 0.08); }
            .toast-error .toast-bar-track { background: rgba(220, 53, 69, 0.1); }

            .toast-modern .toast-bar {
                height: 100%;
                width: 100%;
            }

            .toast-success .toast-bar { background: #0d1f38; }
            .toast-error .toast-bar { background: #dc3545; }

            .toast-modern.playing .toast-bar {
                animation: toastShrink 5s linear forwards;
            }

            @keyframes toastShrink {
                from { width: 100%; }
                to { width: 0%; }
            }
        </style>

        <script>
            function showToast(type, message, title = null) {
                const icons = {
                    success: 'fa-solid fa-check',       // remplace par 'ti ti-check' si Tabler est dispo
                    error: 'fa-solid fa-triangle-exclamation'
                };

                const titles = {
                    success: title || 'Succès',
                    error: title || 'Erreur'
                };

                const toast = document.createElement('div');
                toast.className = `toast-modern ${type === 'success' ? 'toast-success' : 'toast-error'}`;

                toast.innerHTML = `
                    <span class="toast-icon"><i class="${icons[type]}"></i></span>
                    <div class="toast-body">
                        <p class="toast-title">${titles[type]}</p>
                        <p class="toast-message">${message}</p>
                    </div>
                    <button class="toast-close" aria-label="Fermer">&times;</button>
                    <div class="toast-bar-track"><div class="toast-bar"></div></div>
                `;

                document.getElementById('toast-container').appendChild(toast);

                requestAnimationFrame(() => {
                    toast.classList.add('toast-show');
                    setTimeout(() => toast.classList.add('playing'), 50);
                });

                const dismiss = () => {
                    toast.classList.remove('toast-show');
                    toast.classList.add('toast-hide');
                    setTimeout(() => toast.remove(), 350);
                };

                const timer = setTimeout(dismiss, 5000);

                toast.querySelector('.toast-close').addEventListener('click', () => {
                    clearTimeout(timer);
                    dismiss();
                });
            }

            // Intégration Laravel
            $(document).ready(function() {
                @if (session('success'))
                    showToast('success', "{{ session('success') }}");
                @endif

                @if (session('error'))
                    showToast('error', "{{ session('error') }}");
                @endif
            });
        </script>

        <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
        <script>
        AOS.init({
            duration: 500,
            easing: 'ease-in-out',
            once: true
        });
        </script>

    </body>
</html>