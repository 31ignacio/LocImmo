<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur LOCIMMO</title>
</head>

<body style="margin:0; padding:0; background:#f3f4f6; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6; padding:30px 16px;">
    <tr>
        <td align="center">

            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; background:#ffffff; border-radius:14px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.12);">

                <!-- HEADER -->
                <tr>
                    <td style="background:#0d1f38; padding:42px 40px; text-align:center;">
                        <h1 style="margin:0; font-size:26px; font-weight:700; color:#ffffff; letter-spacing:0.3px;">
                            Bienvenue sur LOCIMMO
                        </h1>
                        <p style="margin:12px 0 0; font-size:15px; color:#ffffff; opacity:0.85;">
                            Votre espace est prêt
                        </p>
                    </td>
                </tr>

                <!-- CONTENT -->
                <tr>
                    <td style="padding:40px;">

                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="font-size:15px; line-height:1.8; color:#333333;">

                                    <p style="margin:0 0 16px;">
                                        Bonjour <strong style="color:#0d1f38;">{{ $user->name }}</strong>,
                                    </p>

                                    <p style="margin:0 0 16px;">
                                        Félicitations, votre compte a été créé avec succès et vous faites désormais
                                        partie de notre communauté.
                                    </p>

                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8f9fb; border-radius:8px; margin:20px 0 26px;">
                                        <tr>
                                            <td style="border-left:3px solid #0d1f38; padding:20px 24px;">
                                                <p style="margin:0 0 12px; font-size:13px; font-weight:600; color:#0d1f38; text-transform:uppercase; letter-spacing:0.5px;">
                                                    Avec votre espace, vous pouvez
                                                </p>
                                                <table role="presentation" cellpadding="0" cellspacing="0">
                                                    <tr><td style="padding:0 0 8px; font-size:15px; color:#333333;">• Publier des biens immobiliers (appartements, bureaux)</td></tr>
                                                    <tr><td style="padding:0 0 8px; font-size:15px; color:#333333;">• Publier des chambres à louer</td></tr>
                                                    <tr><td style="padding:0 0 8px; font-size:15px; color:#333333;">• Gérer vos annonces et suivre les demandes reçues</td></tr>
                                                    <tr><td style="padding:0; font-size:15px; color:#333333;">• Échanger directement avec les personnes intéressées</td></tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                    <p style="margin:0 0 16px;">
                                        Besoin d'aide ou une idée à partager ? Notre équipe est toujours disponible
                                        pour vous accompagner.
                                    </p>

                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:28px 0 20px;">
                                        <tr>
                                            <td align="center">
                                                <a href="{{ url('/') }}" style="display:inline-block; padding:14px 36px; background:#0d1f38; color:#ffffff; text-decoration:none; border-radius:8px; font-weight:600; font-size:15px;">
                                                    Accéder à mon espace
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                    <p style="margin:0 0 16px;">
                                        Merci de nous faire confiance. Nous sommes ravis de vous compter parmi nous.
                                    </p>

                                    <p style="margin:0;">
                                        À très bientôt,<br>
                                        <strong>L'équipe LOCIMMO</strong>
                                    </p>

                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>

                <!-- FOOTER -->
                <tr>
                    <td style="text-align:center; padding:18px 10px 22px; font-size:12px; color:#9ca3af;">
                        © {{ date('Y') }} LOCIMMO — Tous droits réservés.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>