<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Monitoring Aktivitas Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e8f5f1, #f7f8fb);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 18px;
            padding: 35px 32px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #0f766e;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            font-weight: bold;
            margin: 0 auto 20px;
        }

        h1 {
            margin: 0;
            font-size: 24px;
            color: #1f2937;
            line-height: 1.3;
        }

        p {
            margin: 12px 0 26px;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
        }

        .btn-google {
            display: block;
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #111827;
            text-decoration: none;
            font-weight: bold;
            transition: 0.2s;
        }

        .btn-google:hover {
            background: #f3f4f6;
            transform: translateY(-1px);
        }

        .alert {
            padding: 12px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 16px;
            text-align: left;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .footer {
            margin-top: 24px;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="logo">P</div>

    <h1>Monitoring Aktivitas Perpustakaan</h1>

    <p>
        Silakan login menggunakan akun Gmail yang sudah terdaftar di sistem.
    </p>

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('google.redirect') }}" class="btn-google">
        Login dengan Google
    </a>

    <div class="footer">
        By: Rumah Literasi 2026
    </div>
</div>

</body>
</html>
