<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Monitoring Aktivitas Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7f6;
            color: #1f2937;
        }

        .navbar {
            background: #ffffff;
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }

        .brand {
            font-size: 18px;
            font-weight: bold;
            color: #0f766e;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #0f766e;
        }

        .user-name {
            font-weight: bold;
            font-size: 14px;
        }

        .user-email {
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
        }

        .btn-logout {
            border: none;
            background: #ef4444;
            color: #ffffff;
            padding: 9px 14px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-logout:hover {
            background: #dc2626;
        }

        .container {
            padding: 32px;
        }

        .welcome-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 10px 28px rgba(0,0,0,0.06);
            margin-bottom: 24px;
        }

        .welcome-card h1 {
            margin: 0 0 8px;
            font-size: 26px;
        }

        .welcome-card p {
            color: #6b7280;
            margin: 0;
            line-height: 1.6;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 8px 22px rgba(0,0,0,0.05);
            border-left: 5px solid #0f766e;
        }

        .stat-label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #111827;
        }

        .menu-card {
            margin-top: 24px;
            background: #ffffff;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 8px 22px rgba(0,0,0,0.05);
        }

        .menu-card h2 {
            margin-top: 0;
            font-size: 20px;
        }

        .menu-list {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 14px;
            margin-top: 16px;
        }

        .menu-item {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            font-weight: bold;
            color: #0f766e;
            background: #f9fafb;
        }

        @media (max-width: 900px) {
            .grid,
            .menu-list {
                grid-template-columns: 1fr;
            }

            .navbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .user-area {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="brand">
        Monitoring Aktivitas Perpustakaan
    </div>

    <div class="user-area">
        @if(auth()->user()->avatar)
            <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="avatar">
        @endif

        <div>
            <div class="user-name">
                {{ auth()->user()->name }}
            </div>
            <div class="user-email">
                {{ auth()->user()->email }}
                @if(auth()->user()->role)
                    | {{ auth()->user()->role->name }}
                @endif
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                Logout
            </button>
        </form>
    </div>
</nav>

<main class="container">
    <section class="welcome-card">
        <h1>Dashboard</h1>
        <p>
            Login berhasil. Ini halaman awal sistem monitoring aktivitas perpustakaan.
            Setelah ini kita lanjutkan ke CRUD user, role, modul aktivitas, dan input aktivitas manual.
        </p>
    </section>

    <section class="grid">
        <div class="stat-card">
            <div class="stat-label">Status Akun</div>
            <div class="stat-value">Aktif</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Role</div>
            <div class="stat-value">
                {{ auth()->user()->role->name ?? '-' }}
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Login Terakhir</div>
            <div class="stat-value">
                {{ auth()->user()->last_login_at ? auth()->user()->last_login_at->format('d-m-Y H:i') : '-' }}
            </div>
        </div>
    </section>

    <section class="menu-card">
        <h2>Menu Sistem</h2>

        <div class="menu-list">
            <a href="{{ route('users.index') }}" class="menu-item" style="text-decoration: none;">
                Master User
            </a>
            <a href="{{ route('roles.index') }}" class="menu-item" style="text-decoration: none;">
                Role
            </a>
            <a href="{{ route('modules.index') }}" class="menu-item" style="text-decoration: none;">
                 Modul Aktivitas
            </a>
            <a href="{{ route('activity-categories.index') }}" class="menu-item" style="text-decoration: none;">
                Jenis Aktivitas
            </a>
            <div class="menu-item">Laporan</div>
        </div>
    </section>
</main>

</body>
</html>
