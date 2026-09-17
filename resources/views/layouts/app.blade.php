<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Monitoring Aktivitas Perpustakaan')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #eef2f7;
            color: #1f2937;
        }

        .app-layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: #2563eb;
            color: #ffffff;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            overflow-y: auto;
            box-shadow: 4px 0 18px rgba(0,0,0,0.18);
            z-index: 1000;
            transition: width 0.25s ease, transform 0.25s ease;
        }

        .sidebar-brand {
            padding: 22px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.18);
            min-height: 86px;
        }

        .brand-icon {
            width: 36px;
            min-width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255,255,255,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .brand-text {
            font-size: 17px;
            font-weight: bold;
            line-height: 1.3;
            white-space: nowrap;
        }

        .sidebar-section {
            padding: 18px 14px 4px;
            font-size: 12px;
            font-weight: bold;
            color: rgba(255,255,255,0.75);
            text-transform: uppercase;
            white-space: nowrap;
        }

        .sidebar-menu {
            padding: 0 10px 10px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255,255,255,0.92);
            text-decoration: none;
            padding: 12px 13px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 5px;
            transition: 0.2s;
            width: 100%;
        }

        .sidebar-link:hover {
            background: rgba(255,255,255,0.16);
            color: #ffffff;
        }

        .sidebar-link.active {
            background: #0d6efd;
            color: #ffffff;
            font-weight: bold;
            box-shadow: inset 4px 0 0 #ffffff;
        }

        .sidebar-icon {
            width: 18px;
            min-width: 18px;
            text-align: center;
            font-size: 14px;
        }

        .sidebar-text {
            white-space: nowrap;
        }

        .main-wrapper {
            flex: 1;
            margin-left: 260px;
            min-width: 0;
            transition: margin-left 0.25s ease;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        body.sidebar-collapsed .sidebar {
            width: 78px;
        }

        body.sidebar-collapsed .main-wrapper {
            margin-left: 78px;
        }

        body.sidebar-collapsed .brand-text,
        body.sidebar-collapsed .sidebar-section,
        body.sidebar-collapsed .sidebar-text {
            display: none;
        }

        body.sidebar-collapsed .sidebar-brand {
            justify-content: center;
            padding-left: 10px;
            padding-right: 10px;
        }

        body.sidebar-collapsed .sidebar-link {
            justify-content: center;
            padding-left: 10px;
            padding-right: 10px;
        }

        body.sidebar-collapsed .sidebar-icon {
            font-size: 17px;
        }

        .topbar {
            height: 64px;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 4px 14px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 26px;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .hamburger {
            border: none;
            background: transparent;
            font-size: 24px;
            cursor: pointer;
            color: #374151;
            padding: 6px 8px;
            border-radius: 8px;
        }

        .hamburger:hover {
            background: #f3f4f6;
        }

        .topbar-title {
            font-size: 15px;
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

        .content {
            padding: 24px;
            flex: 1;
        }

        .page-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 26px;
            box-shadow: 0 14px 35px rgba(0,0,0,0.07);
        }

        .page-title {
            font-size: 30px;
            font-weight: bold;
            margin: 0 0 8px;
            color: #111827;
        }

        .page-subtitle {
            margin: 0 0 20px;
            color: #6b7280;
            line-height: 1.6;
        }

        .mobile-overlay {
            display: none;
        }

        @media (max-width: 850px) {
            body.sidebar-collapsed .sidebar {
                width: 260px;
            }

            body.sidebar-collapsed .main-wrapper {
                margin-left: 0;
            }

            body.sidebar-collapsed .brand-text,
            body.sidebar-collapsed .sidebar-section,
            body.sidebar-collapsed .sidebar-text {
                display: inline;
            }

            .sidebar {
                width: 260px;
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .mobile-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.35);
                z-index: 950;
            }
        }

        @media (max-width: 700px) {
            .topbar {
                height: auto;
                padding: 14px 16px;
                align-items: flex-start;
                gap: 12px;
            }

            .user-area {
                flex-wrap: wrap;
                justify-content: flex-end;
            }

            .user-email {
                max-width: 190px;
                word-break: break-word;
            }

            .content {
                padding: 16px;
            }

            .page-card {
                padding: 18px;
                border-radius: 14px;
            }

            .page-title {
                font-size: 24px;
            }
        }

        @yield('styles')
    </style>
</head>
<body>

@php
    $user = auth()->user();

    $roleObject = $user->role ?? null;

    $roleSlug = is_object($roleObject)
        ? ($roleObject->slug ?? null)
        : $roleObject;

    $roleName = is_object($roleObject)
        ? ($roleObject->name ?? '')
        : ($roleObject ?? '');

    $roleSlug = strtolower(str_replace([' ', '-'], '_', trim((string) $roleSlug)));
    $roleNameLower = strtolower(str_replace([' ', '-'], '_', trim((string) $roleName)));

    $isSuperAdmin = in_array($roleSlug, ['super_admin'])
        || in_array($roleNameLower, ['super_admin']);

    $isAdmin = in_array($roleSlug, ['admin'])
        || in_array($roleNameLower, ['admin']);

    $canManageMaster = $isSuperAdmin || $isAdmin;
@endphp

<div class="mobile-overlay" id="mobileOverlay" onclick="closeSidebar()"></div>

<div class="app-layout">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">📚</div>
            <div class="brand-text">
                Monitoring<br>Perpustakaan
            </div>
        </div>

        @if($canManageMaster || $isSuperAdmin)
            <div class="sidebar-section">Menu Master Data</div>
            <div class="sidebar-menu">
                @if($canManageMaster)
                    <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <span class="sidebar-icon">👤</span>
                        <span class="sidebar-text">Master User</span>
                    </a>
                @endif

                @if($isSuperAdmin)
                    <a href="{{ route('roles.index') }}" class="sidebar-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                        <span class="sidebar-icon">🔐</span>
                        <span class="sidebar-text">Role</span>
                    </a>
                @endif

                @if($canManageMaster)
                    <a href="{{ route('modules.index') }}" class="sidebar-link {{ request()->routeIs('modules.*') ? 'active' : '' }}">
                        <span class="sidebar-icon">🗂️</span>
                        <span class="sidebar-text">Modul Aktivitas</span>
                    </a>

                    <a href="{{ route('activity-categories.index') }}" class="sidebar-link {{ request()->routeIs('activity-categories.*') ? 'active' : '' }}">
                        <span class="sidebar-icon">🏷️</span>
                        <span class="sidebar-text">Jenis Aktivitas</span>
                    </a>
                @endif
            </div>
        @endif

        <div class="sidebar-section">Menu Aktivitas</div>
        <div class="sidebar-menu">
            <a href="{{ route('activities.index') }}" class="sidebar-link {{ request()->routeIs('activities.*') ? 'active' : '' }}">
                <span class="sidebar-icon">📝</span>
                <span class="sidebar-text">Aktivitas</span>
            </a>
        </div>

        <div class="sidebar-section">Menu Laporan</div>
        <div class="sidebar-menu">
            <a href="{{ route('reports.activities') }}" class="sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <span class="sidebar-icon">📄</span>
                <span class="sidebar-text">Laporan Aktivitas</span>
            </a>
        </div>

        <div class="sidebar-section">Menu Statistik</div>
        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="sidebar-icon">📊</span>
                <span class="sidebar-text">Statistik Aktivitas</span>
            </a>
        </div>

        <div class="sidebar-section">Setting</div>
        <div class="sidebar-menu">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link" style="border:none; cursor:pointer; background:transparent;">
                    <span class="sidebar-icon">🚪</span>
                    <span class="sidebar-text">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <section class="main-wrapper">
        <nav class="topbar">
            <div style="display:flex; align-items:center; gap:14px;">
                <button class="hamburger" type="button" onclick="toggleSidebar()">☰</button>
                <div class="topbar-title">
                    Monitoring Aktivitas Perpustakaan
                </div>
            </div>

            <div class="user-area">
                @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="Avatar" class="avatar">
                @endif

                <div>
                    <div class="user-name">
                        {{ $user->name }}
                    </div>
                    <div class="user-email">
                        {{ $user->email }}
                        @if($user->role)
                            | {{ $roleName ?: '-' }}
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

        <main class="content">
            @yield('content')
        </main>

        @include('partials.footer')
    </section>
</div>

<script>
    function isMobileScreen() {
        return window.innerWidth <= 850;
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobileOverlay');

        if (isMobileScreen()) {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
            return;
        }

        document.body.classList.toggle('sidebar-collapsed');

        if (document.body.classList.contains('sidebar-collapsed')) {
            localStorage.setItem('sidebar_status', 'collapsed');
        } else {
            localStorage.setItem('sidebar_status', 'open');
        }
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('mobileOverlay').classList.remove('show');
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (!isMobileScreen() && localStorage.getItem('sidebar_status') === 'collapsed') {
            document.body.classList.add('sidebar-collapsed');
        }
    });

    window.addEventListener('resize', function () {
        if (!isMobileScreen()) {
            closeSidebar();
        }
    });
</script>

@yield('scripts')

</body>
</html>
