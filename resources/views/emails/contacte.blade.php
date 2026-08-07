<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau message de contact</title>
</head>
<body style="margin:0; padding:0; background-color:#f2f4f3; font-family: Arial, Helvetica, sans-serif;">

    <!-- Wrapper -->
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f2f4f3; padding:32px 16px;">
        <tr>
            <td align="center">

                <!-- Card -->
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(11,25,41,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:#0b1929; padding:28px 32px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="vertical-align:middle;">
                                        <span style="display:inline-block; width:8px; height:8px; background-color:#4ade80; border-radius:50%; margin-right:8px;"></span>
                                        <span style="color:#9ca3af; font-size:12px; letter-spacing:1px; text-transform:uppercase; font-weight:600;">Nouveau message</span>
                                        <h1 style="margin:8px 0 0 0; color:#ffffff; font-size:22px; font-weight:700;">Formulaire de contact</h1>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:32px;">

                            <!-- Sender info -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f9fafb; border-radius:8px; padding:4px;">
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding:6px 0; font-size:13px; color:#6b7280; width:110px; vertical-align:top;">Nom complet</td>
                                                <td style="padding:6px 0; font-size:14px; color:#111827; font-weight:600;">{{ $nom }} {{ $prenom }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:6px 0; font-size:13px; color:#6b7280; vertical-align:top; border-top:1px solid #e5e7eb;">Email</td>
                                                <td style="padding:6px 0; font-size:14px; border-top:1px solid #e5e7eb;">
                                                    <a href="mailto:{{ $email }}" style="color:#0b1929; text-decoration:none; font-weight:600;">{{ $email }}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:6px 0; font-size:13px; color:#6b7280; vertical-align:top; border-top:1px solid #e5e7eb;">Sujet</td>
                                                <td style="padding:6px 0; font-size:14px; color:#111827; font-weight:600; border-top:1px solid #e5e7eb;">{{ $sujet }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Message -->
                            <div style="margin-top:24px;">
                                <p style="margin:0 0 8px 0; font-size:12px; letter-spacing:0.5px; text-transform:uppercase; color:#9ca3af; font-weight:700;">Message</p>
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0fdf4; border-left:4px solid #16a34a; border-radius:0 8px 8px 0;">
                                    <tr>
                                        <td style="padding:18px 20px; font-size:15px; line-height:1.6; color:#1f2937; white-space:pre-wrap;">{{ $message }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- CTA -->
                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin-top:28px;">
                                <tr>
                                    <td style="border-radius:8px; background-color:#0b1929;">
                                        <a href="mailto:{{ $email }}" style="display:inline-block; padding:12px 24px; font-size:14px; font-weight:700; color:#ffffff; text-decoration:none;">Répondre à {{ $prenom }}</a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin-top:24px; font-size:13px; color:#6b7280;">Merci de prendre en charge cette demande rapidement.</p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f9fafb; padding:20px 32px; text-align:center; border-top:1px solid #e5e7eb;">
                            <p style="margin:0; font-size:12px; color:#9ca3af;">Message envoyé automatiquement depuis le formulaire de contact du site.</p>
                        </td>
                    </tr>

                </table>
                <!-- /Card -->

            </td>
        </tr>
    </table>

</body>
</html>