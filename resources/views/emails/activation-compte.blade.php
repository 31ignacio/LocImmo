<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 0;
            margin: 0;
        }

        .email-container {
            max-width: 600px;
            background: #ffffff;
            margin: 30px auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .header {
            background: #0d1f38;
            color: white;
            padding: 25px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .content {
            padding: 25px;
            font-size: 15px;
            line-height: 1.7;
            color: #333;
        }

        .code-box {
            background: #f0f0ff;
            border-left: 5px solid #0d1f38;
            padding: 15px;
            margin: 20px 0;
            font-size: 20px;
            text-align: center;
            font-weight: bold;
            letter-spacing: 3px;
        }

        .btn {
            display: inline-block;
            background: #0d1f38;
            color: white !important;
            padding: 12px 25px;
            margin-top: 25px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 8px;
        }

        .footer {
            text-align: center;
            color: #999;
            padding: 15px;
            font-size: 13px;
        }
    </style>
</head>

<body>

<div class="email-container">

    <div class="header">
        Activation de votre compte
    </div>

    <div class="content">

        <p>Bonjour <strong>{{ $prenom }}</strong>,</p>

        <p>Bienvenue sur <strong>LOCIMMO</strong> ! Nous sommes ravis de vous accueillir.</p>

        <p>Pour activer votre compte, veuillez utiliser le code suivant :</p>

        <div class="code-box">
            {{ $code }}
        </div>

        <p>Ce code est <strong>strictement confidentiel</strong>. Ne le partagez avec personne.</p>

        <center>
            <a href="{{ url('/validate-account/' . $email) }}" class="btn">
                Activer mon compte
            </a>
        </center>

        <p style="margin-top: 25px;">
            Merci de rejoindre notre communauté !<br>
            <strong>L'équipe LOCIMMO</strong>
        </p>
    </div>

    <div class="footer">
        © {{ date('Y') }} LOCIMMO – Tous droits réservés
    </div>

</div>

</body>
</html>
