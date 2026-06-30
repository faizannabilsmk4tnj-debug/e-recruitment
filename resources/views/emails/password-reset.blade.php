<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            line-height: 1.6;
        }
        .wrapper {
            max-width: 600px;
            margin: 40px auto;
            padding: 0 16px 40px;
        }
        /* Header */
        .header {
            background: #15803d;
            border-radius: 16px 16px 0 0;
            padding: 32px 40px;
            text-align: center;
        }
        .header-logo {
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
        }
        .header-logo span {
            color: #86efac;
        }
        .header-subtitle {
            font-size: 13px;
            color: #bbf7d0;
            margin-top: 4px;
        }
        /* Body Card */
        .card {
            background: #ffffff;
            padding: 40px;
            border-left: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
        }
        .icon-wrap {
            width: 64px;
            height: 64px;
            background: #f0fdf4;
            border: 2px solid #86efac;
            border-radius: 16px;
            margin: 0 auto 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .icon-wrap svg {
            width: 32px;
            height: 32px;
            color: #15803d;
            stroke: #15803d;
        }
        h1 {
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            color: #0f172a;
            margin-bottom: 8px;
        }
        .greeting {
            font-size: 15px;
            color: #475569;
            text-align: center;
            margin-bottom: 24px;
        }
        .divider {
            border: none;
            border-top: 1px dashed #e2e8f0;
            margin: 24px 0;
        }
        .body-text {
            font-size: 14px;
            color: #475569;
            margin-bottom: 12px;
        }
        .btn-wrap {
            text-align: center;
            margin: 32px 0;
        }
        .btn-reset {
            display: inline-block;
            background: #15803d;
            color: #ffffff !important;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            padding: 14px 36px;
            border-radius: 10px;
            letter-spacing: 0.3px;
        }
        .url-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
            margin-top: 16px;
        }
        .url-box p {
            font-size: 12px;
            color: #94a3b8;
            margin-bottom: 4px;
        }
        .url-box a {
            font-size: 12px;
            color: #15803d;
            word-break: break-all;
        }
        .note-box {
            background: #fef9c3;
            border: 1px solid #fde047;
            border-radius: 10px;
            padding: 14px 18px;
            margin-top: 24px;
        }
        .note-box p {
            font-size: 13px;
            color: #713f12;
        }
        /* Footer */
        .footer {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-top: none;
            border-radius: 0 0 16px 16px;
            padding: 24px 40px;
            text-align: center;
        }
        .footer p {
            font-size: 12px;
            color: #94a3b8;
            margin-bottom: 4px;
        }
        .footer a {
            color: #15803d;
            text-decoration: none;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Header -->
        <div class="header">
            <div class="header-logo">Ecogreen <span>Recruit</span></div>
            <div class="header-subtitle">PT Ecogreen Oleochemicals — E-Recruitment System</div>
        </div>

        <!-- Card -->
        <div class="card">
            <!-- Icon -->
            <div class="icon-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 9.9-1"/>
                    <line x1="12" x2="12" y1="15" y2="17"/>
                </svg>
            </div>

            <h1>Reset Password Anda</h1>
            <p class="greeting">Halo, <strong>{{ $userName }}</strong>!</p>

            <hr class="divider">

            <p class="body-text">
                Kami menerima permintaan untuk mereset password akun Anda di sistem E-Recruitment PT Ecogreen Oleochemicals.
            </p>
            <p class="body-text">
                Klik tombol di bawah ini untuk membuat password baru. Link ini hanya berlaku selama <strong>60 menit</strong>.
            </p>

            <div class="btn-wrap">
                <a href="{{ $resetUrl }}" class="btn-reset">
                    🔑 &nbsp; Reset Password Saya
                </a>
            </div>

            <p class="body-text" style="font-size:13px; color:#94a3b8;">
                Atau salin tautan berikut ke browser Anda:
            </p>
            <div class="url-box">
                <p>Tautan Reset Password</p>
                <a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
            </div>

            <div class="note-box">
                <p>⚠️ <strong>Penting:</strong> Jika Anda tidak meminta reset password, abaikan email ini. Akun Anda tetap aman dan tidak ada perubahan yang dilakukan.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem E-Recruitment</p>
            <p>PT Ecogreen Oleochemicals — Jl. Pelita Baru, Batam, Kepulauan Riau</p>
            <br>
            <a href="{{ url('/') }}">Kunjungi Portal Rekrutmen</a>
        </div>
    </div>
</body>
</html>
