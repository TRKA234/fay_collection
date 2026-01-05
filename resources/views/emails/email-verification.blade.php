<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #6366f1;
        }
        .header h1 {
            color: #6366f1;
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin-bottom: 30px;
        }
        .otp-box {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #6366f1;
            letter-spacing: 8px;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #666;
            font-size: 12px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #6366f1;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Fay Collection</h1>
        </div>

        <div class="content">
            <h2>Verifikasi Email Anda</h2>
            <p>Halo <strong>{{ $user->name }}</strong>,</p>
            <p>Terima kasih telah mendaftar di Fay Collection. Untuk melanjutkan, silakan verifikasi alamat email Anda dengan kode OTP berikut:</p>

            <div class="otp-box">
                <p style="margin: 0 0 10px 0; color: #666;">Kode Verifikasi Anda:</p>
                <div class="otp-code">{{ $code }}</div>
                <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">Kode ini berlaku selama 15 menit</p>
            </div>

            <div class="warning">
                <strong>⚠️ Penting:</strong> Jangan bagikan kode ini kepada siapapun. Fay Collection tidak akan pernah meminta kode verifikasi Anda.
            </div>

            <p>Jika Anda tidak melakukan pendaftaran ini, silakan abaikan email ini.</p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Fay Collection. All rights reserved.</p>
            <p>Email ini dikirim secara otomatis, mohon jangan membalas email ini.</p>
        </div>
    </div>
</body>
</html>

