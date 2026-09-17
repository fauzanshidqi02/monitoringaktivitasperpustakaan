<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('code', 'Error') - Monitoring Aktivitas Perpustakaan</title>
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
                radial-gradient(circle at 12% 18%, rgba(20,184,166,0.16), transparent 28%),
                radial-gradient(circle at 85% 15%, rgba(37,99,235,0.10), transparent 30%),
                linear-gradient(135deg, #ecfdf5 0%, #eff6ff 55%, #ffffff 100%);
            color: #0f172a;
            overflow-x: hidden;
        }

        .error-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 50px;
            padding: 55px 90px;
            position: relative;
        }

        .paper {
            position: absolute;
            width: 86px;
            height: 115px;
            border-radius: 12px;
            background: rgba(255,255,255,0.72);
            box-shadow: 0 18px 38px rgba(15,23,42,0.08);
            animation: paperFloat 5s ease-in-out infinite;
        }

        .paper::before {
            content: "";
            position: absolute;
            left: 18px;
            top: 26px;
            width: 48px;
            height: 6px;
            border-radius: 999px;
            background: rgba(15,118,110,0.28);
            box-shadow:
                0 18px 0 rgba(37,99,235,0.16),
                0 36px 0 rgba(15,118,110,0.13);
        }

        .paper.one {
            left: 7%;
            top: 15%;
            transform: rotate(-9deg);
        }

        .paper.two {
            right: 8%;
            bottom: 12%;
            transform: rotate(8deg);
            animation-delay: 1.2s;
        }

        @keyframes paperFloat {
            0%, 100% {
                translate: 0 0;
            }
            50% {
                translate: 0 -18px;
            }
        }

        .illustration {
            position: relative;
            height: 430px;
        }

        .ground {
            position: absolute;
            left: 50%;
            bottom: 72px;
            width: 430px;
            height: 26px;
            border-radius: 999px;
            background: #ffffff;
            transform: translateX(-50%);
            box-shadow: 0 15px 30px rgba(15,23,42,0.12);
        }

        .shadow {
            position: absolute;
            left: 50%;
            bottom: 95px;
            width: 260px;
            height: 28px;
            background: rgba(15,23,42,0.10);
            border-radius: 50%;
            transform: translateX(-50%);
            filter: blur(3px);
            animation: shadowMove 3s ease-in-out infinite;
        }

        @keyframes shadowMove {
            0%, 100% {
                transform: translateX(-50%) scale(1);
            }
            50% {
                transform: translateX(-50%) scale(.92);
            }
        }

        /* BOARD / SIGN */
        .warning-board {
            position: absolute;
            left: 50%;
            bottom: 130px;
            width: 200px;
            height: 150px;
            transform: translateX(-50%);
            animation: boardFloat 3s ease-in-out infinite;
        }

        @keyframes boardFloat {
            0%, 100% {
                transform: translateX(-50%) translateY(0);
            }
            50% {
                transform: translateX(-50%) translateY(-8px);
            }
        }

        .board-frame {
            width: 100%;
            height: 100%;
            background: #ffffff;
            border: 8px solid #f59e0b;
            border-radius: 20px;
            box-shadow: 0 18px 28px rgba(15,23,42,0.14);
            position: relative;
        }

        .board-frame::before,
        .board-frame::after {
            content: "";
            position: absolute;
            bottom: -45px;
            width: 10px;
            height: 45px;
            background: #64748b;
            border-radius: 6px;
        }

        .board-frame::before {
            left: 40px;
        }

        .board-frame::after {
            right: 40px;
        }

        .face {
            position: absolute;
            left: 50%;
            top: 28px;
            width: 90px;
            height: 90px;
            transform: translateX(-50%);
            border-radius: 50%;
            background: #fef3c7;
            border: 4px solid #f59e0b;
        }

        .face .eye {
            position: absolute;
            top: 28px;
            width: 8px;
            height: 8px;
            background: #111827;
            border-radius: 50%;
        }

        .face .eye.left {
            left: 24px;
        }

        .face .eye.right {
            right: 24px;
        }

        .face .mouth {
            position: absolute;
            left: 50%;
            bottom: 20px;
            width: 30px;
            height: 14px;
            transform: translateX(-50%);
            border-top: 4px solid #111827;
            border-radius: 20px 20px 0 0;
        }

        .face .brow {
            position: absolute;
            top: 20px;
            width: 18px;
            height: 4px;
            background: #111827;
            border-radius: 999px;
        }

        .face .brow.left {
            left: 18px;
            transform: rotate(-12deg);
        }

        .face .brow.right {
            right: 18px;
            transform: rotate(12deg);
        }

        /* CONES */
        .cone-group {
            position: absolute;
            left: 50%;
            bottom: 98px;
            width: 340px;
            transform: translateX(-50%);
            display: flex;
            justify-content: space-between;
            align-items: end;
        }

        .cone {
            position: relative;
            width: 68px;
            height: 92px;
            animation: coneBounce 2.8s ease-in-out infinite;
        }

        .cone:nth-child(2) {
            animation-delay: .35s;
        }

        .cone:nth-child(3) {
            animation-delay: .7s;
        }

        .cone-top {
            position: absolute;
            left: 50%;
            top: 0;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 26px solid transparent;
            border-right: 26px solid transparent;
            border-bottom: 66px solid #f97316;
        }

        .cone-top::before,
        .cone-top::after {
            content: "";
            position: absolute;
            left: -22px;
            width: 44px;
            height: 8px;
            background: #ffffff;
        }

        .cone-top::before {
            top: 18px;
        }

        .cone-top::after {
            top: 38px;
        }

        .cone-base {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 68px;
            height: 18px;
            background: #1f2937;
            border-radius: 8px;
        }

        @keyframes coneBounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* TOOLBOX */
        .toolbox {
            position: absolute;
            right: 65px;
            bottom: 120px;
            width: 96px;
            height: 58px;
            background: #2563eb;
            border-radius: 14px;
            box-shadow: 0 14px 24px rgba(37,99,235,0.20);
            animation: toolboxFloat 3s ease-in-out infinite;
        }

        .toolbox::before {
            content: "";
            position: absolute;
            left: 50%;
            top: -16px;
            transform: translateX(-50%);
            width: 42px;
            height: 18px;
            border: 6px solid #2563eb;
            border-bottom: none;
            border-radius: 14px 14px 0 0;
        }

        .toolbox::after {
            content: "";
            position: absolute;
            left: 50%;
            top: 22px;
            transform: translateX(-50%);
            width: 24px;
            height: 8px;
            background: rgba(255,255,255,0.9);
            border-radius: 999px;
        }

        @keyframes toolboxFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-6px);
            }
        }

        /* WRENCH */
        .wrench {
            position: absolute;
            left: 72px;
            bottom: 188px;
            width: 74px;
            height: 16px;
            background: #94a3b8;
            border-radius: 999px;
            transform: rotate(-30deg);
            animation: wrenchSwing 3s ease-in-out infinite;
        }

        .wrench::before {
            content: "";
            position: absolute;
            left: -6px;
            top: -8px;
            width: 22px;
            height: 22px;
            border: 6px solid #94a3b8;
            border-right-color: transparent;
            border-radius: 50%;
            transform: rotate(35deg);
        }

        .wrench::after {
            content: "";
            position: absolute;
            right: -4px;
            top: 4px;
            width: 16px;
            height: 8px;
            background: #64748b;
            border-radius: 999px;
        }

        @keyframes wrenchSwing {
            0%, 100% {
                transform: rotate(-30deg) translateY(0);
            }
            50% {
                transform: rotate(-18deg) translateY(-6px);
            }
        }

        /* SMALL FLOAT ICON */
        .mini-badge {
            position: absolute;
            left: 50%;
            top: 18px;
            transform: translateX(-50%);
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.72);
            color: #0f766e;
            font-weight: bold;
            box-shadow: 0 10px 24px rgba(15,23,42,0.08);
            font-size: 14px;
            animation: miniFloat 3.2s ease-in-out infinite;
        }

        @keyframes miniFloat {
            0%, 100% {
                transform: translateX(-50%) translateY(0);
            }
            50% {
                transform: translateX(-50%) translateY(-8px);
            }
        }

        .content-box {
            position: relative;
            z-index: 2;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 999px;
            background: #ffffff;
            color: #0f766e;
            font-weight: bold;
            box-shadow: 0 10px 24px rgba(15,23,42,0.08);
            margin-bottom: 20px;
        }

        .error-code {
            font-size: 96px;
            line-height: 1;
            font-weight: 900;
            margin: 0 0 12px;
            color: #0f172a;
            letter-spacing: -4px;
        }

        h1 {
            font-size: 34px;
            margin: 0 0 12px;
            color: #111827;
        }

        p {
            font-size: 16px;
            line-height: 1.7;
            color: #64748b;
            margin: 0 0 26px;
            max-width: 520px;
        }

        .button-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 17px;
            border-radius: 12px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #0f766e;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #0d665f;
        }

        .btn-secondary {
            background: #ffffff;
            color: #111827;
            border: 1px solid #e5e7eb;
        }

        .btn-secondary:hover {
            background: #f8fafc;
        }

        .footer-text {
            margin-top: 30px;
            font-size: 13px;
            color: #94a3b8;
        }

        .footer-text strong {
            color: #0f766e;
        }

        @media (max-width: 950px) {
            .error-page {
                grid-template-columns: 1fr;
                padding: 34px 22px;
                text-align: center;
            }

            .illustration {
                height: 330px;
                order: -1;
            }

            .content-box p {
                margin-left: auto;
                margin-right: auto;
            }

            .button-row {
                justify-content: center;
            }

            .error-code {
                font-size: 72px;
            }

            h1 {
                font-size: 28px;
            }

            .ground {
                width: 350px;
            }

            .cone-group {
                width: 290px;
            }
        }

        @media (max-width: 520px) {
            .error-page {
                padding: 28px 16px;
            }

            .illustration {
                height: 280px;
                transform: scale(.88);
            }

            .error-code {
                font-size: 60px;
            }

            h1 {
                font-size: 24px;
            }

            p {
                font-size: 14px;
            }

            .button-row {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .ground {
                width: 300px;
            }

            .warning-board {
                width: 170px;
                height: 130px;
            }

            .face {
                width: 76px;
                height: 76px;
            }

            .cone-group {
                width: 255px;
            }

            .cone {
                width: 56px;
                height: 82px;
            }

            .cone-top {
                border-left: 22px solid transparent;
                border-right: 22px solid transparent;
                border-bottom: 58px solid #f97316;
            }

            .cone-base {
                width: 58px;
            }

            .toolbox {
                width: 82px;
                height: 52px;
                right: 48px;
            }
        }
    </style>
</head>
<body>

@php
    $homeUrl = auth()->check() ? route('dashboard') : route('login');
    $homeText = auth()->check() ? 'Dashboard' : 'Login';
@endphp

<div class="paper one"></div>
<div class="paper two"></div>

<main class="error-page">
    <section class="illustration">
        <div class="mini-badge">⚠️ Sedang diperiksa</div>

        <div class="wrench"></div>

        <div class="warning-board">
            <div class="board-frame">
                <div class="face">
                    <div class="brow left"></div>
                    <div class="brow right"></div>
                    <div class="eye left"></div>
                    <div class="eye right"></div>
                    <div class="mouth"></div>
                </div>
            </div>
        </div>

        <div class="cone-group">
            <div class="cone">
                <div class="cone-top"></div>
                <div class="cone-base"></div>
            </div>

            <div class="cone">
                <div class="cone-top"></div>
                <div class="cone-base"></div>
            </div>

            <div class="cone">
                <div class="cone-top"></div>
                <div class="cone-base"></div>
            </div>
        </div>

        <div class="toolbox"></div>
        <div class="shadow"></div>
        <div class="ground"></div>
    </section>

    <section class="content-box">
        <div class="badge">
            📚 Rumah Literasi
        </div>

        <div class="error-code">
            @yield('code', 'Oops')
        </div>

        <h1>
            @yield('title_text', 'Halaman tidak tersedia')
        </h1>

        <p>
            @yield('message', 'Coba refresh atau kembali ke halaman utama.')
        </p>

        <div class="button-row">
            <a href="{{ $homeUrl }}" class="btn btn-primary">
                🏠 {{ $homeText }}
            </a>

            <button type="button" onclick="window.history.back()" class="btn btn-secondary">
                ← Kembali
            </button>

            <button type="button" onclick="window.location.reload()" class="btn btn-secondary">
                🔄 Refresh
            </button>
        </div>

        <div class="footer-text">
            © 2026 by <strong>Rumah Literasi</strong>
        </div>
    </section>
</main>

</body>
</html>
