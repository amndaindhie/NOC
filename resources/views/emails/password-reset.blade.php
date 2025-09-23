<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - NOC System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            margin: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px 20px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            margin: 20px 0;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            transition: all 0.3s ease;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
            color: white;
            text-decoration: none;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
        .highlight {
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="bi bi-shield-lock" style="margin-right: 10px;"></i>NOC System</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Network Operation Center</p>
        </div>

        <div class="content">
            <h2 style="color: #007bff; margin-bottom: 20px;">Reset Password Anda</h2>

            <p>Halo,</p>

            <p>Anda menerima email ini karena ada permintaan reset password untuk akun Anda di sistem NOC.</p>

            <div class="highlight">
                <p><strong>Detail Permintaan:</strong></p>
                <p>📧 Email: {{ $email }}</p>
                <p>⏰ Waktu: {{ now()->format('d M Y, H:i') }}</p>
            </div>

            <p>Jika Anda yang meminta reset password, silakan klik tombol di bawah ini untuk melanjutkan:</p>

            <div style="text-align: center;">
                <a href="{{ $url }}" class="button">
                    <i class="bi bi-key" style="margin-right: 8px;"></i>
                    Reset Password Saya
                </a>
            </div>

            <div class="warning">
                <strong>⚠️ Peringatan Keamanan:</strong><br>
                • Link ini akan kadaluarsa dalam 60 menit<br>
                • Jangan bagikan link ini dengan siapapun<br>
                • Jika Anda tidak meminta reset password, abaikan email ini
            </div>

            <p>Jika tombol di atas tidak berfungsi, Anda dapat menyalin dan menempelkan link berikut ke browser Anda:</p>
            <p style="word-break: break-all; background-color: #f8f9fa; padding: 10px; border-radius: 5px; font-family: monospace;">
                {{ $url }}
            </p>

            <p>Terima kasih,<br>
            <strong>Tim NOC System</strong></p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} NOC System - Network Operation Center</p>
            <p style="margin: 5px 0 0 0; font-size: 12px;">
                Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>
