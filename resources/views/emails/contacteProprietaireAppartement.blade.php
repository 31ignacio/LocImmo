<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau message — LOCIMMO</title>
</head>
<body style="margin:0;padding:0;background-color:#EFF2F5;font-family:'Segoe UI',Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#EFF2F5;padding:48px 16px;">
    <tr>
        <td align="center">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:580px;">

                <!-- ══ CARTE PRINCIPALE ══ -->
                <tr>
                    <td style="background:#ffffff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,0.07);overflow:hidden;">

                        <!-- Barre top -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="background:linear-gradient(90deg,#0d1f38 0%,#1a3560 100%);height:5px;font-size:0;line-height:0;">&nbsp;</td>
                            </tr>
                        </table>

                        <!-- Icône + Titre -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" style="padding:36px 40px 0;">
                                    <div style="display:inline-block;width:64px;height:64px;background:#f0f4ff;border-radius:50%;text-align:center;line-height:64px;font-size:28px;">
                                        ✉️
                                    </div>
                                    <h1 style="margin:16px 0 6px;font-size:20px;font-weight:700;color:#0d1f38;letter-spacing:-0.3px;">
                                        Nouveau message client
                                    </h1>
                                    <p style="margin:0;font-size:12px;color:#8a94a6;text-transform:uppercase;letter-spacing:0.5px;font-weight:600;">
                                        Via la plateforme LOCIMMO
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

                        <!-- ══ ANNONCE CONCERNÉE ══ -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:24px 40px 0;">
                                    <p style="margin:0 0 14px;font-size:11px;font-weight:700;color:#8a94a6;text-transform:uppercase;letter-spacing:0.6px;">
                                        🏠 Annonce concernée
                                    </p>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="background:#fdf8ef;border-radius:10px;border:1px solid #f3e6c8;border-left:4px solid #e8a838;padding:16px 18px;">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td style="font-size:15px;font-weight:700;color:#0d1f38;padding-bottom:4px;">
                                                            {{ $appartement->type }} — {{ $appartement->quartier }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size:12.5px;color:#6b7280;padding-bottom:8px;">
                                                            {{ $appartement->commune }}, {{ $appartement->departement }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size:16px;font-weight:800;color:#e8a838;padding-bottom:6px;">
                                                            {{ number_format($appartement->prix ?? 0, 0, ',', ' ') }} FCFA
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size:11.5px;color:#9a9488;">
                                                            Référence : #{{ $appartement->id }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- ══ INFOS EXPÉDITEUR ══ -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:24px 40px 0;">
                                    <p style="margin:0 0 14px;font-size:11px;font-weight:700;color:#8a94a6;text-transform:uppercase;letter-spacing:0.6px;">
                                        Informations de l'expéditeur
                                    </p>

                                    <!-- Nom -->
                                    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:10px;">
                                        <tr>
                                            <td style="background:#f7f9fc;border-radius:10px;border:1px solid #e8ecf1;padding:13px 16px;">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td style="font-size:11px;color:#8a94a6;font-weight:600;text-transform:uppercase;letter-spacing:0.4px;padding-bottom:4px;">
                                                            👤 Nom complet
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size:14px;font-weight:700;color:#0d1f38;">
                                                            {{ $nom }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- Téléphone + Email côte à côte -->
                                    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:10px;">
                                        <tr>
                                            <td width="49%" style="background:#f7f9fc;border-radius:10px;border:1px solid #e8ecf1;padding:13px 16px;vertical-align:top;">
                                                <p style="margin:0 0 4px;font-size:11px;color:#8a94a6;font-weight:600;text-transform:uppercase;letter-spacing:0.4px;">📞 Téléphone</p>
                                                <p style="margin:0;font-size:14px;font-weight:700;color:#0d1f38;">{{ $telephone }}</p>
                                            </td>
                                            <td width="2%">&nbsp;</td>
                                            <td width="49%" style="background:#f7f9fc;border-radius:10px;border:1px solid #e8ecf1;padding:13px 16px;vertical-align:top;">
                                                <p style="margin:0 0 4px;font-size:11px;color:#8a94a6;font-weight:600;text-transform:uppercase;letter-spacing:0.4px;">📧 E-mail</p>
                                                <p style="margin:0;font-size:13px;font-weight:700;">
                                                    <a href="mailto:{{ $email }}" style="color:#0d1f38;text-decoration:none;">{{ $email }}</a>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- ══ MESSAGE ══ -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:16px 40px 0;">
                                    <p style="margin:0 0 10px;font-size:11px;font-weight:700;color:#8a94a6;text-transform:uppercase;letter-spacing:0.6px;">
                                        💬 Message
                                    </p>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="background:#f7f9fc;border-radius:10px;border:1px solid #e8ecf1;border-left:4px solid #0d1f38;padding:16px 18px;">
                                               <p style="margin:0;font-size:14px;color:#374151;line-height:1.75;white-space:pre-line;">{{ $messageContent }}</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- ══ BOUTONS D'ACTION ══ -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" style="padding:28px 40px 0;">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding-right:8px;">
                                                <a href="{{ route('appartement.detail', $appartement->id) }}"
                                                   style="display:inline-block;background:#e8a838;color:#ffffff;text-decoration:none;font-size:13px;font-weight:700;padding:13px 26px;border-radius:9px;letter-spacing:0.3px;">
                                                    🏠 Voir l'annonce
                                                </a>
                                            </td>
                                            <td style="padding-left:8px;">
                                                <a href="mailto:{{ $email }}"
                                                   style="display:inline-block;background:#0d1f38;color:#ffffff;text-decoration:none;font-size:13px;font-weight:700;padding:13px 26px;border-radius:9px;letter-spacing:0.3px;">
                                                    ↩ Répondre à {{ $nom }}
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- Séparateur bas -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:28px 40px 0;">
                                    <div style="height:1px;background:#f0f2f5;"></div>
                                </td>
                            </tr>
                        </table>

                        <!-- Signature -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:20px 40px 32px;">
                                    <p style="margin:0;font-size:13px;color:#6b7280;line-height:1.6;">
                                        Merci de prendre en charge cette demande dans les meilleurs délais.
                                    </p>
                                    <p style="margin:10px 0 0;font-size:13px;color:#8a94a6;">Cordialement,</p>
                                    <p style="margin:4px 0 0;font-size:14px;font-weight:700;color:#0d1f38;">
                                        L'équipe <span style="color:#e8a838;">LOCIMMO</span>
                                    </p>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>

                <!-- ══ FOOTER ══ -->
                <tr>
                    <td align="center" style="padding:28px 20px 0;font-size:12px;color:#a0aab4;line-height:1.7;">
                        <p style="margin:0 0 4px;">
                            Cet e-mail a été envoyé automatiquement depuis le formulaire de contact LOCIMMO.
                        </p>
                        <p style="margin:0;">
                            © {{ date('Y') }} LOCIMMO — Tous droits réservés.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>