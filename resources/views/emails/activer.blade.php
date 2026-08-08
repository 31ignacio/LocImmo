<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification d'activation de compte</title>

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

        .content a {
            color: #0d1f38;
            font-weight: bold;
            text-decoration: none;
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

    <div class="content"><br>

        <p>Bonjour <strong>{{ $user->name }}</strong>,</p>

        <p>Votre compte a été réactivé par l'administrateur.</p>

        <p>Vous pouvez maintenant vous connecter à votre compte et accéder à toutes ses fonctionnalités.</p>

        <p>Si vous avez des questions ou des préoccupations, n'hésitez pas à nous contacter via le formulaire de contact sur notre site.</p>

        <p>Merci et à bientôt sur notre plateforme !</p>

        <p style="margin-top: 25px;">
            Cordialement,<br>
            <strong>L'équipe de support</strong>
        </p>
    </div>

    <div class="footer">
        © {{ date('Y') }} LOCIMMO – Tous droits réservés
    </div>

</div>

</body>
</html>