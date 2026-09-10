<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de senha | UniForma</title>
</head>
<body style="margin:0;background:#f1f5f9;font-family:Arial,sans-serif;color:#1e293b;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f1f5f9;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:600px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 8px 24px rgba(15,23,42,.08);">
                    <tr>
                        <td style="background:#16385b;padding:28px 40px;text-align:center;">
                            <div style="font-size:28px;font-weight:700;color:#ffffff;letter-spacing:.5px;">UniForma</div>
                            <div style="margin-top:6px;font-size:13px;color:#bfdbfe;">Formação construída em comunidade</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;">
                            <h1 style="margin:0 0 20px;font-size:24px;line-height:1.3;color:#0f172a;">Redefinição de senha</h1>
                            <p style="margin:0 0 16px;font-size:16px;line-height:1.6;">Olá, {{ $userName }}!</p>
                            <p style="margin:0 0 28px;font-size:16px;line-height:1.6;color:#475569;">
                                Recebemos uma solicitação para redefinir sua senha de acesso à UniForma.
                            </p>
                            <table role="presentation" cellspacing="0" cellpadding="0" style="margin:0 auto 28px;">
                                <tr>
                                    <td style="border-radius:8px;background:#0040a1;">
                                        <a href="{{ $url }}" style="display:inline-block;padding:14px 28px;color:#ffffff;text-decoration:none;font-size:16px;font-weight:700;">Redefinir senha</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:0 0 12px;font-size:14px;line-height:1.6;color:#64748b;">
                                Este link expira em {{ $expire }} minutos.
                            </p>
                            <p style="margin:0 0 24px;font-size:14px;line-height:1.6;color:#64748b;">
                                Se você não solicitou a alteração, ignore este e-mail. Sua senha permanecerá segura.
                            </p>
                            <p style="margin:0;font-size:12px;line-height:1.6;color:#94a3b8;word-break:break-all;">
                                Se o botão não funcionar, copie e cole este endereço no navegador:<br>{{ $url }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top:1px solid #e2e8f0;padding:20px 40px;text-align:center;font-size:12px;color:#94a3b8;">
                            Mensagem automática da plataforma UniForma.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
