@extends('layouts.master2')

@section('content')

<div class="reset-wrapper">

    <div class="reset-card">

        <!-- Retour accueil DANS le formulaire -->
        <a href="{{ url('/') }}" class="back-link inside">
             ⟵ Retour à l’accueil
        </a>

        <h2 class="title">Définissez vos nouveaux accès</h2><br>
        {{-- <p class="subtitle">
            Sécurisez votre compte en définissant un nouveau mot de passe.
        </p> --}}

        <form action="{{ route('submitDefineAccessMail', $email) }}" method="POST" id="resetForm">
            @csrf

            @error('code')
                    <marquee class="text-danger" style="">{{ $message }}</marquee>
            @enderror

            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" value="{{ $email }}" readonly>
            </div>

            <input type="hidden" name="code" value="{{ $code }}">

            <div class="form-group">
                <label>Nouveau mot de passe</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password">
                    <span class="input-group-addon eye" onclick="togglePassword('password', this)">
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Confirmation du mot de passe</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confirm_password" name="confirme_password">
                    <span class="input-group-addon eye" onclick="togglePassword('confirm_password', this)">
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
                @error('confirme_password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-loc btn-block" id="submitBtn">
                <span class="btn-text">Valider</span>
                <span class="btn-loader"></span>
            </button>
        </form>

    </div>
</div>

    {{-- STYLE --}}
    <style>
        .reset-wrapper{
            min-height: 100vh;
            background: #f9fafb;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reset-card{
            background: #fff;
            width: 100%;
            max-width: 420px;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            position: relative;
        }

        /* lien retour dans la carte */
        .back-link.inside{
            display: inline-block;
            font-size: 13px;
            color: #0d1f38;           /* même couleur que le bouton */
            text-decoration: none;    /* pas de soulignement */
            font-weight: 600;
            margin-bottom: 15px;
        }

        .back-link.inside:hover{
            color: #0d1f38;           /* même hover que le bouton */
        }


        .title{
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .subtitle{
            text-align: center;
            font-size: 13px;
            color: #777;
            margin-bottom: 22px;
        }

        .form-control{
            height: 44px;
            font-size: 14px;
        }

        .input-group-addon.eye{
            background: #fff;
            cursor: pointer;
        }

        .btn-loc{
            background: #0d1f38;
            border: none;
            height: 44px;
            font-weight: 600;
            font-size: 15px;
            border-radius: 6px;
            position: relative;
            overflow: hidden;
        }

        .btn-loc:hover{
            background: #0d1f38;
        }

        .btn-loader{
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255,255,255,.6);
            border-top-color: white;
            border-radius: 50%;
            animation: spin .6s linear infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes spin{
            to{ transform: rotate(360deg); }
        }
    </style>

    {{-- SCRIPT --}}
    <script>
        function togglePassword(id, el){
            const input = document.getElementById(id);
            const icon = el.querySelector('i');
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }

        document.getElementById('resetForm').addEventListener('submit', function(){
            document.querySelector('.btn-text').style.visibility = 'hidden';
            document.querySelector('.btn-loader').style.display = 'block';
            document.getElementById('submitBtn').disabled = true;
        });
    </script>

@endsection
