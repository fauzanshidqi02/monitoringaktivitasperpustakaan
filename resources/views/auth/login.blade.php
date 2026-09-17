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
            background:
                radial-gradient(circle at 12% 18%, rgba(255,255,255,0.45), transparent 24%),
                radial-gradient(circle at 88% 14%, rgba(20,184,166,0.26), transparent 28%),
                radial-gradient(circle at 80% 88%, rgba(37,99,235,0.18), transparent 30%),
                linear-gradient(135deg, #e0f7f4 0%, #eef6ff 45%, #f8fafc 100%);
            overflow-x: hidden;
            color: #111827;
        }

        .login-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            align-items: center;
            gap: 40px;
            padding: 50px 80px;
            position: relative;
        }

        .shape {
            position: absolute;
            z-index: 1;
            opacity: 0.55;
            animation: floatShape 7s ease-in-out infinite;
        }

        .shape::before,
        .shape::after {
            content: "";
            position: absolute;
            display: block;
        }

        .shape.one {
            width: 130px;
            height: 90px;
            left: 7%;
            top: 14%;
            border-radius: 16px;
            background: rgba(255,255,255,0.42);
            box-shadow: 0 18px 40px rgba(15,118,110,0.12);
            transform: rotate(-8deg);
        }

        .shape.one::before {
            width: 68px;
            height: 8px;
            left: 20px;
            top: 24px;
            border-radius: 999px;
            background: rgba(15,118,110,0.32);
            box-shadow: 0 20px 0 rgba(15,118,110,0.22);
        }

        .shape.two {
            width: 90px;
            height: 120px;
            left: 43%;
            top: 16%;
            border-radius: 12px;
            background: rgba(255,255,255,0.34);
            border-left: 10px solid rgba(37,99,235,0.35);
            transform: rotate(10deg);
            animation-delay: 1s;
        }

        .shape.two::before {
            width: 45px;
            height: 6px;
            left: 22px;
            top: 30px;
            border-radius: 999px;
            background: rgba(37,99,235,0.26);
            box-shadow:
                0 18px 0 rgba(37,99,235,0.18),
                0 36px 0 rgba(37,99,235,0.14);
        }

        .shape.three {
            width: 180px;
            height: 180px;
            right: 6%;
            top: 10%;
            border-radius: 50%;
            background: rgba(255,255,255,0.20);
            filter: blur(1px);
            animation-delay: 1.5s;
        }

        .shape.four {
            width: 120px;
            height: 76px;
            right: 12%;
            bottom: 16%;
            border-radius: 18px 18px 10px 10px;
            background: rgba(255,255,255,0.36);
            transform: rotate(7deg);
            animation-delay: 2s;
        }

        .shape.four::before {
            width: 50%;
            height: 100%;
            left: 0;
            top: 0;
            border-right: 2px solid rgba(15,118,110,0.25);
            background: rgba(20,184,166,0.18);
            border-radius: 18px 0 0 10px;
        }

        .shape.five {
            width: 80px;
            height: 80px;
            left: 30%;
            bottom: 12%;
            border-radius: 24px;
            background: rgba(255,255,255,0.28);
            transform: rotate(45deg);
            animation-delay: 2.5s;
        }

        @keyframes floatShape {
            0%, 100% {
                translate: 0 0;
            }

            50% {
                translate: 0 -18px;
            }
        }

        .left-content {
            position: relative;
            z-index: 5;
            color: #0f172a;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.7);
            border: 1px solid rgba(255,255,255,0.9);
            padding: 10px 16px;
            border-radius: 999px;
            font-weight: bold;
            margin-bottom: 22px;
            box-shadow: 0 10px 25px rgba(15,118,110,0.08);
            backdrop-filter: blur(8px);
        }

        .brand-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #0f766e;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .left-content h1 {
            font-size: 48px;
            line-height: 1.15;
            margin: 0 0 18px;
            max-width: 680px;
            color: #0f172a;
        }

        .left-content p {
            font-size: 17px;
            line-height: 1.7;
            max-width: 620px;
            margin: 0;
            color: #475569;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            margin-left: auto;
            position: relative;
            z-index: 5;
            background: rgba(255,255,255,0.82);
            border: 1px solid rgba(255,255,255,0.95);
            border-radius: 28px;
            padding: 32px;
            backdrop-filter: blur(18px);
            box-shadow: 0 25px 65px rgba(15,23,42,0.14);
            text-align: center;
            color: #111827;
        }

        .human-scene {
            height: 215px;
            position: relative;
            margin-bottom: 16px;
        }

        .human {
            position: absolute;
            left: 50%;
            bottom: 8px;
            width: 190px;
            height: 190px;
            transform: translateX(-50%);
            animation: humanFloat 3.4s ease-in-out infinite;
        }

        @keyframes humanFloat {
            0%, 100% {
                transform: translateX(-50%) translateY(0);
            }

            50% {
                transform: translateX(-50%) translateY(-8px);
            }
        }

        .hair {
            position: absolute;
            left: 61px;
            top: 5px;
            width: 66px;
            height: 38px;
            background: #111827;
            border-radius: 50px 50px 18px 18px;
            z-index: 3;
        }

        .head {
            position: absolute;
            left: 64px;
            top: 17px;
            width: 60px;
            height: 60px;
            background: #ffd7b5;
            border-radius: 50%;
            box-shadow: inset 0 -4px 0 rgba(0,0,0,0.06);
            z-index: 4;
        }

        .ear {
            position: absolute;
            top: 42px;
            width: 12px;
            height: 16px;
            background: #f5c39f;
            border-radius: 50%;
            z-index: 3;
        }

        .ear.left {
            left: 58px;
        }

        .ear.right {
            left: 119px;
        }

        .eye {
            position: absolute;
            top: 43px;
            width: 6px;
            height: 6px;
            background: #111827;
            border-radius: 50%;
            z-index: 5;
            animation: blink 4s infinite;
        }

        .eye.left {
            left: 81px;
        }

        .eye.right {
            left: 104px;
        }

        @keyframes blink {
            0%, 92%, 100% {
                transform: scaleY(1);
            }

            95% {
                transform: scaleY(0.15);
            }
        }

        .smile {
            position: absolute;
            left: 84px;
            top: 58px;
            width: 22px;
            height: 11px;
            border-bottom: 3px solid #111827;
            border-radius: 0 0 30px 30px;
            z-index: 5;
        }

        .neck {
            position: absolute;
            left: 84px;
            top: 72px;
            width: 22px;
            height: 20px;
            background: #f5c39f;
            border-radius: 0 0 8px 8px;
            z-index: 2;
        }

        .body {
            position: absolute;
            left: 48px;
            top: 88px;
            width: 94px;
            height: 76px;
            background: #ffffff;
            border-radius: 28px 28px 14px 14px;
            box-shadow: 0 10px 22px rgba(0,0,0,0.16);
            z-index: 2;
        }

        .body::before {
            content: "";
            position: absolute;
            left: 27px;
            bottom: 0;
            width: 40px;
            height: 52px;
            background: #0f766e;
            border-radius: 20px 20px 12px 12px;
        }

        .arm {
            position: absolute;
            top: 106px;
            width: 64px;
            height: 16px;
            background: #ffd7b5;
            border-radius: 999px;
            z-index: 4;
        }

        .arm.left {
            left: 16px;
            transform-origin: right center;
            transform: rotate(22deg);
            animation: armLeft 2.4s ease-in-out infinite;
        }

        .arm.right {
            right: 16px;
            transform-origin: left center;
            transform: rotate(-22deg);
            animation: armRight 2.4s ease-in-out infinite;
        }

        @keyframes armLeft {
            0%, 100% {
                transform: rotate(22deg);
            }

            50% {
                transform: rotate(13deg);
            }
        }

        @keyframes armRight {
            0%, 100% {
                transform: rotate(-22deg);
            }

            50% {
                transform: rotate(-13deg);
            }
        }

        .book {
            position: absolute;
            left: 42px;
            top: 118px;
            width: 106px;
            height: 58px;
            background: #1d4ed8;
            border-radius: 8px;
            box-shadow: 0 12px 24px rgba(0,0,0,0.2);
            overflow: hidden;
            z-index: 5;
            animation: bookMove 2.4s ease-in-out infinite;
        }

        @keyframes bookMove {
            0%, 100% {
                transform: rotate(0deg);
            }

            50% {
                transform: rotate(1.5deg);
            }
        }

        .book::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 50%;
            height: 100%;
            background: #2563eb;
            border-right: 2px solid rgba(255,255,255,0.55);
        }

        .book::after {
            content: "";
            position: absolute;
            right: 13px;
            top: 18px;
            width: 32px;
            height: 3px;
            background: rgba(255,255,255,0.78);
            box-shadow: 0 10px 0 rgba(255,255,255,0.68);
        }

        .desk {
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 235px;
            height: 22px;
            background: #ffffff;
            border-radius: 999px;
            transform: translateX(-50%);
            box-shadow: 0 13px 28px rgba(0,0,0,0.18);
        }

        .lamp {
            position: absolute;
            right: 18px;
            bottom: 20px;
            width: 58px;
            height: 96px;
        }

        .lamp-head {
            position: absolute;
            top: 0;
            width: 56px;
            height: 30px;
            background: #fbbf24;
            border-radius: 50px 50px 10px 10px;
            animation: lampGlow 2s ease-in-out infinite;
        }

        .lamp-stick {
            position: absolute;
            left: 24px;
            top: 27px;
            width: 8px;
            height: 63px;
            background: #ffffff;
            border-radius: 999px;
        }

        @keyframes lampGlow {
            0%, 100% {
                box-shadow: 0 0 0 rgba(251,191,36,0.2);
            }

            50% {
                box-shadow: 0 0 28px rgba(251,191,36,0.8);
            }
        }

        .login-card h2 {
            font-size: 30px;
            margin: 0 0 8px;
            color: #0f172a;
        }

        .login-card p {
            margin: 0 0 22px;
            color: #64748b;
            line-height: 1.6;
            font-size: 14px;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 14px;
            margin-bottom: 16px;
            text-align: left;
            line-height: 1.5;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .google-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: #ffffff;
            color: #1f2937;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 14px 18px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 10px 22px rgba(15,23,42,0.10);
            transition: 0.2s;
        }

        .google-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(15,23,42,0.16);
        }

        .google-icon {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #ffffff;
            background: conic-gradient(#4285F4, #34A853, #FBBC05, #EA4335, #4285F4);
        }

        .footer-text {
            margin-top: 22px;
            font-size: 13px;
            color: #64748b;
        }

        .footer-text strong {
            color: #0f766e;
        }

        @media (max-width: 950px) {
            body {
                overflow-y: auto;
            }

            .login-page {
                grid-template-columns: 1fr;
                padding: 34px 20px;
                gap: 30px;
                text-align: center;
            }

            .left-content h1 {
                font-size: 34px;
                margin-left: auto;
                margin-right: auto;
            }

            .left-content p {
                margin-left: auto;
                margin-right: auto;
            }

            .login-card {
                margin: 0 auto;
            }
        }

        @media (max-width: 480px) {
            .login-page {
                padding: 26px 15px;
            }

            .left-content h1 {
                font-size: 28px;
            }

            .left-content p {
                font-size: 14px;
            }

            .login-card {
                padding: 24px 18px;
                border-radius: 22px;
            }

            .human-scene {
                height: 195px;
                transform: scale(0.9);
                margin-bottom: 0;
            }

            .login-card h2 {
                font-size: 25px;
            }
        }
    </style>
</head>
<body>

<div class="shape one"></div>
<div class="shape two"></div>
<div class="shape three"></div>
<div class="shape four"></div>
<div class="shape five"></div>

<main class="login-page">
    <section class="left-content">
        <div class="brand-badge">
            <span class="brand-icon">📚</span>
            <span>Rumah Literasi</span>
        </div>

        <h1>
            Monitoring Aktivitas Perpustakaan
        </h1>

        <p>
            Bantu tim perpustakaan mencatat kegiatan, memantau progres,
            dan menyusun laporan dengan cara yang lebih praktis dan tertata.
        </p>
    </section>

    <section class="login-card">
        <div class="human-scene">
            <div class="human">
                <div class="hair"></div>
                <div class="head"></div>
                <div class="ear left"></div>
                <div class="ear right"></div>
                <div class="eye left"></div>
                <div class="eye right"></div>
                <div class="smile"></div>
                <div class="neck"></div>
                <div class="body"></div>
                <div class="arm left"></div>
                <div class="arm right"></div>
                <div class="book"></div>
            </div>

            <div class="lamp">
                <div class="lamp-head"></div>
                <div class="lamp-stick"></div>
            </div>

            <div class="desk"></div>
        </div>

        <h2>Selamat Datang</h2>

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

        <a href="{{ route('google.redirect') }}" class="google-btn">
            <span class="google-icon">G</span>
            <span>Login dengan Google</span>
        </a>

        <div class="footer-text">
            <span>© 2026 by <strong>Rumah Literasi</strong></span>
        </div>
    </section>
</main>

</body>
</html>
