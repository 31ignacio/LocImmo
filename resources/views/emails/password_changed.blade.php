<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe modifié — LOCIMMO</title>
</head>
<body style="margin:0;padding:0;background-color:#EFF2F5;font-family:'Segoe UI',Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#EFF2F5;padding:48px 16px;">
    <tr>
        <td align="center">

            <!-- Wrapper max-width -->
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;">

                <!-- ══ MAIN CARD ══ -->
                <tr>
                    <td style="background:#ffffff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,0.07);overflow:hidden;">

                        <!-- Barre top colorée -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="background:linear-gradient(90deg,#0d1f38 0%,#1a3560 100%);height:5px;font-size:0;line-height:0;">&nbsp;</td>
                            </tr>
                        </table>

                        <!-- Icône centrale -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" style="padding:40px 40px 0;">
                                    <div style="display:inline-block;width:72px;height:72px;background:#f0f4ff;border-radius:50%;text-align:center;line-height:72px;font-size:32px;">
                                        🔐
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <!-- Titre -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" style="padding:20px 40px 8px;">
                                    <h1 style="margin:0;font-size:22px;font-weight:700;color:#0d1f38;letter-spacing:-0.3px;">
                                        Mot de passe modifié
                                    </h1>
                                    <p style="margin:8px 0 0;font-size:13px;color:#8a94a6;letter-spacing:0.3px;text-transform:uppercase;font-weight:600;">
                                        Confirmation de sécurité
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <!-- Séparateur -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:20px 40px 0;">
                                    <div style="height:1px;background:#f0f2f5;"></div>
                                </td>
                            </tr>
                        </table>

                        <!-- Corps du message -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:28px 40px 0;color:#374151;font-size:15px;line-height:1.7;">
                                    <p style="margin:0 0 14px;">
                                        Bonjour <strong style="color:#0d1f38;">{{ $user->name }}</strong>,
                                    </p>
                                    <p style="margin:0 0 20px;">
                                        Nous vous confirmons que votre mot de passe a été
                                        <strong style="color:#0d1f38;">modifié avec succès</strong>
                                        sur votre compte LOCIMMO.
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <!-- Bloc info date / heure (statique, à rendre dynamique si besoin) -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:0 40px;">
                                    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f7f9fc;border-radius:10px;border:1px solid #e8ecf1;">
                                        <tr>
                                            <td style="padding:16px 20px;">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td style="font-size:12px;color:#8a94a6;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;padding-bottom:10px;" colspan="2">
                                                            Détails de la modification
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size:13px;color:#6b7280;padding:4px 0;width:50%;">📅 Date</td>
                                                        <td style="font-size:13px;color:#0d1f38;font-weight:600;text-align:right;">{{ now()->format('d/m/Y') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size:13px;color:#6b7280;padding:4px 0;">🕐 Heure</td>
                                                        <td style="font-size:13px;color:#0d1f38;font-weight:600;text-align:right;">{{ now()->format('H:i') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size:13px;color:#6b7280;padding:4px 0;">📧 Compte</td>
                                                        <td style="font-size:13px;color:#0d1f38;font-weight:600;text-align:right;">{{ $user->email }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- Alerte sécurité -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:20px 40px 0;">
                                    <table width="100%" cellpadding="0" cellspacing="0" style="background:#fff8ed;border-radius:10px;border-left:4px solid #e8a838;">
                                        <tr>
                                            <td style="padding:16px 18px;font-size:13.5px;color:#0d1f38;line-height:1.6;">
                                                <strong>⚠️ Ce n'était pas vous ?</strong><br>
                                                Si vous n'êtes pas à l'origine de cette modification, contactez-nous immédiatement via notre formulaire de support afin de sécuriser votre compte.
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- Conseil sécurité -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:20px 40px 32px;font-size:13.5px;color:#6b7280;line-height:1.7;">
                                    <p style="margin:0;">
                                        🛡️ Pour votre sécurité, ne partagez jamais vos identifiants avec qui que ce soit.
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <!-- Séparateur bas -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:0 40px;">
                                    <div style="height:1px;background:#f0f2f5;"></div>
                                </td>
                            </tr>
                        </table>

                        <!-- Signature -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:24px 40px 32px;">
                                    <p style="margin:0;font-size:13px;color:#8a94a6;">Cordialement,</p>
                                    <p style="margin:4px 0 0;font-size:14px;font-weight:700;color:#0d1f38;">
                                        L'équipe <span style="color:#0d1f38;">LOCIMMO</span>
                                    </p>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>

                <!-- ══ FOOTER ══ -->
                <tr>
                    <td align="center" style="padding:28px 20px 0;font-size:12px;color:#a0aab4;line-height:1.6;">
                        <p style="margin:0 0 4px;">
                            Cet e-mail a été envoyé automatiquement, merci de ne pas y répondre.
                        </p>
                        <p style="margin:0;">
                            © {{ date('Y') }} LOCIMMO — Tous droits réservés.
                        </p>
                    </td>
                </tr>

            </table>
            <!-- End Wrapper -->

        </td>
    </tr>
</table>

</body>
</html>