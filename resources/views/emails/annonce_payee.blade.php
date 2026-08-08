<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Annonce publiée — LocImmo</title>
</head>
<body style="margin:0;padding:0;background-color:#F4F6F9;font-family:Arial,Helvetica,sans-serif;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F4F6F9;padding:30px 0;">
<tr>
<td align="center">

    <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(17,24,39,.06);max-width:600px;width:100%;">

        {{-- HEADER --}}
        <tr>
            <td style="background-color:#0d1f38;padding:28px 32px;text-align:center;">
                <span style="font-size:22px;font-weight:800;color:#ffffff;letter-spacing:-.5px;">Loc<span style="color:#dcfce7;">Immo</span></span>
            </td>
        </tr>

        {{-- ICÔNE SUCCÈS --}}
        <tr>
            <td style="padding:36px 32px 0;text-align:center;">
                <table role="presentation" cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td style="width:64px;height:64px;border-radius:50%;background-color:#f0fdf4;border:2px solid #bbf7d0;text-align:center;vertical-align:middle;font-size:28px;color:#0d1f38;">
                            &#10003;
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- TITRE --}}
        <tr>
            <td style="padding:18px 32px 6px;text-align:center;">
                <h1 style="margin:0;font-size:20px;font-weight:800;color:#111827;">Votre annonce est en ligne !</h1>
            </td>
        </tr>

        <tr>
            <td style="padding:0 32px 26px;text-align:center;">
                <p style="margin:0;font-size:14px;color:#6B7280;line-height:1.6;">
                    Bonjour, votre annonce a été publiée avec succès sur LocImmo et est désormais visible par tous les visiteurs de la plateforme.
                </p>
            </td>
        </tr>

        {{-- CARTE ANNONCE --}}
        <tr>
            <td style="padding:0 32px 26px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#FAFBFC;border:1.5px solid #E5E7EB;border-radius:12px;">
                    <tr>
                        <td style="padding:18px 20px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="font-size:11px;font-weight:700;color:#9CA3AF;text-transform:uppercase;letter-spacing:.06em;padding-bottom:4px;">Type de bien</td>
                                </tr>
                                <tr>
                                    <td style="font-size:15px;font-weight:700;color:#111827;padding-bottom:12px;">
                                        {{ $appartement->type }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:11px;font-weight:700;color:#9CA3AF;text-transform:uppercase;letter-spacing:.06em;padding-bottom:4px;">Localisation</td>
                                </tr>
                                <tr>
                                    <td style="font-size:15px;font-weight:700;color:#111827;padding-bottom:12px;">
                                        {{ \Illuminate\Support\Str::limit($appartement->quartier, 40) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:1px dashed #E5E7EB;padding-top:12px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="font-size:12px;color:#6B7280;">Référence</td>
                                                <td style="font-size:12px;color:#111827;font-weight:700;text-align:right;">#{{ $appartement->id }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- BOUTON CTA --}}
        <tr>
            <td style="padding:0 32px 28px;text-align:center;">
                <table role="presentation" cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td style="border-radius:10px;background-color:#0d1f38;">
                            <a href="{{ route('entreprise.espace') }}" target="_blank" style="display:inline-block;padding:13px 32px;font-size:14px;font-weight:700;color:#ffffff;text-decoration:none;border-radius:10px;">
                                Voir mes annonces &rarr;
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- INFO DURÉE --}}
        <tr>
            <td style="padding:0 32px 30px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;">
                    <tr>
                        <td style="padding:14px 16px;font-size:12.5px;color:#1e3a8a;line-height:1.6;">
                            <strong>&#128337; Durée de visibilité :</strong> votre annonce restera active et visible pendant <strong>7 jours</strong>. Vous pourrez la renouveler ou la modifier à tout moment depuis votre espace personnel.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- SÉPARATEUR --}}
        <tr>
            <td style="padding:0 32px;">
                <div style="height:1px;background-color:#F1F5F9;"></div>
            </td>
        </tr>

        {{-- FOOTER --}}
        <tr>
            <td style="padding:24px 32px 32px;text-align:center;">
                <p style="margin:0 0 6px;font-size:12px;color:#9CA3AF;">
                    Merci d'avoir choisi LocImmo pour la publication de votre annonce.
                </p>
                <p style="margin:0;font-size:12px;color:#9CA3AF;">
                    Une question ? Contactez notre support depuis votre espace personnel.
                </p>
            </td>
        </tr>

    </table>

    {{-- MENTION LÉGALE / MARQUE --}}
    <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">
        <tr>
            <td style="padding:20px 32px;text-align:center;">
                <p style="margin:0;font-size:11px;color:#9CA3AF;">
                    &copy; {{ date('Y') }} LocImmo — Tous droits réservés.
                </p>
            </td>
        </tr>
    </table>

</td>
</tr>
</table>

</body>
</html>