<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Modul Aktivitas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * { box-sizing: border-box; }

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
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
        }

        .brand {
            font-weight: bold;
            color: #0f766e;
            font-size: 18px;
            text-decoration: none;
        }

        .top-menu {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .container {
            padding: 32px;
        }

        .card {
            background: #ffffff;
            padding: 24px;
            border-radius: 18px;
            box-shadow: 0 8px 22px rgba(0,0,0,0.05);
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .btn {
            display: inline-block;
            padding: 9px 14px;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background: #0f766e;
            color: #ffffff;
        }

        .btn-warning {
            background: #f59e0b;
            color: #ffffff;
        }

        .btn-danger {
            background: #ef4444;
            color: #ffffff;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .filter-box {
            display: grid;
            grid-template-columns: 2fr 1fr auto;
            gap: 10px;
            margin-bottom: 20px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f9fafb;
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-active {
            background: #dcfce7;
            color: #166534;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-slug {
            background: #e0f2fe;
            color: #075985;
        }

        .alert {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 16px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        @media (max-width: 900px) {
            .filter-box {
                grid-template-columns: 1fr;
            }

            .header-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile-fix.css') }}">
</head>
<body>

<nav class="navbar">
    <a href="{{ route('dashboard') }}" class="brand">
        Monitoring Aktivitas Perpustakaan
    </a>

    <div class="top-menu">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Master User</a>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Role</a>
        <span>{{ auth()->user()->name }}</span>
    </div>
</nav>

<main class="container">
    <div class="card">
        <div class="header-row">
            <div>
                <h1 style="margin: 0;">Modul Aktivitas</h1>
                <p style="margin: 6px 0 0; color: #6b7280;">
                    Kelola modul utama aktivitas perpustakaan.
                </p>
            </div>

            <a href="{{ route('modules.create') }}" class="btn btn-primary">
                + Tambah Modul
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <form method="GET" action="{{ route('modules.index') }}" class="filter-box">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari modul...">

            <select name="status">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <button type="submit" class="btn btn-secondary">
                Filter
            </button>
        </form>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Urutan</th>
                        <th>Nama Modul</th>
                        <th>Slug</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($modules as $module)
                        <tr>
                            <td>{{ $module->sort_order }}</td>
                            <td><strong>{{ $module->name }}</strong></td>
                            <td>
                                <span class="badge badge-slug">{{ $module->slug }}</span>
                            </td>
                            <td>{{ $module->description ?? '-' }}</td>
                            <td>
                                @if($module->is_active)
                                    <span class="badge badge-active">Aktif</span>
                                @else
                                    <span class="badge badge-inactive">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('modules.edit', $module) }}" class="btn btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('modules.destroy', $module) }}" method="POST" onsubmit="return confirm('Yakin hapus modul ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #6b7280;">
                                Belum ada data modul.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top: 16px;">
            {{ $modules->links() }}
        </div>
    </div>
</main>

</body>
</html>
