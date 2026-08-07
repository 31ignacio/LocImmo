<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
</head>

<body style="margin:0; padding:0; background:#f3f4f6; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6; padding:30px 16px;">
    <tr>
        <td align="center">

            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; background:#ffffff; border-radius:14px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.12);">

                <!-- HEADER -->
                <tr>
                    <td style="background:#0d1f38; padding:42px 40px; text-align:center;">
                        <h1 style="margin:0; font-size:24px; font-weight:700; color:#ffffff; letter-spacing:0.3px;">
                            Réinitialisation du mot de passe
                        </h1>
                    </td>
                </tr>

                <!-- CONTENU -->
                <tr>
                    <td style="padding:40px;">

                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="font-size:15px; line-height:1.8; color:#333333;">

                                    <p style="margin:0 0 16px;">
                                        Bonjour <strong style="color:#0d1f38;">{{ $name }}</strong>,
                                    </p>

                                    <p style="margin:0 0 16px;">
                                        Vous recevez cet e-mail car vous avez demandé la réinitialisation de votre
                                        mot de passe sur notre plateforme <strong>LOCIMMO</strong>.
                                    </p>

                                    <p style="margin:0 0 24px;">
                                        Veuillez cliquer sur le bouton ci-dessous pour définir un nouveau mot de
                                        passe.
                                    </p>

                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center">
                                                <a href="{{ url('/validate-mail/' . $email . '/' . $code) }}" style="display:inline-block; padding:14px 36px; background:#0d1f38; color:#ffffff; text-decoration:none; border-radius:8px; font-weight:600; font-size:15px;">
                                                    Réinitialiser mon mot de passe
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8f9fb; border-radius:8px; margin:28px 0 8px;">
                                        <tr>
                                            <td style="border-left:3px solid #d1d5db; padding:14px 20px; font-size:13px; color:#6b7280;">
                                                Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer
                                                cet e-mail en toute sécurité.
                                            </td>
                                        </tr>
                                    </table>

                                    <p style="margin:28px 0 0;">
                                        Cordialement,<br>
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