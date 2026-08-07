@extends('layouts.master2')

@section('content')
    <div class="forgot-wrapper">

        <div class="forgot-card">

            <!-- Retour accueil -->
            <a href="{{ url('/') }}" class="back-home">
                ⟵ Retour à l’accueil
            </a>

            <h2 class="forgot-title">Mot de passe oublié</h2>
            <p class="forgot-text">
                Entrez votre adresse e-mail.
                Nous vous enverrons un lien pour réinitialiser votre mot de passe.
            </p>

            <!-- Formulaire -->
            <form action="{{ route('password.email') }}" method="post" id="forgotForm">
                @csrf

                <div class="form-group">
                    <label>Adresse e-mail</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" id="submitBtn" class="btn-submit">
                    <span id="btnText">Envoyer le lien</span>
                    <span class="loader" id="loader"></span>
                </button>
            </form>

        </div>
    </div>

    <style>
        /* PAGE */
        .forgot-wrapper {
            min-height: 100vh;
            background: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* CARD */
        .forgot-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        /* RETOUR */
        .back-home {
            display: inline-block;
            font-size: 14px;
            color: #0d1f38;
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 12px;
        }

        .back-home:hover {
            color: #0d1f38;
            text-decoration: none;
            /* PAS DE SOULIGNEMENT */
        }

        /* TITRES */
        .forgot-title {
            text-align: center;
            font-size: 20px;
            /* TAILLE RÉDUITE */
            margin: 10px 0 8px;
            font-weight: 700;
            color: #333;
        }

        .forgot-text {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-bottom: 25px;
        }

        /* INPUT */
        .form-control {
            height: 46px;
            border-radius: 8px;
        }

        /* BOUTON */
        .btn-submit {
            width: 100%;
            height: 46px;
            background: #0d1f38;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            position: relative;
        }

        /* LOADER */
        .loader {
            display: none;
            width: 18px;
            height: 18px;
            border: 3px solid #ffffff;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin .7s linear infinite;
            margin-left: 8px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* MOBILE */
        @media(max-width:480px) {
            .forgot-card {
                padding: 28px 22px;
            }

            .forgot-title {
                font-size: 18px;
            }
        }
    </style>

    <script>
        document.getElementById("forgotForm").addEventListener("submit", function() {
            document.getElementById("btnText").style.display = "none";
            document.getElementById("loader").style.display = "inline-block";
            document.getElementById("submitBtn").disabled = true;
        });
    </script>
@endsection
