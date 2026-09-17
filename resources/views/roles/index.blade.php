<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Role</title>
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
            background: #e0f2fe;
            color: #075985;
            font-size: 12px;
            font-weight: bold;
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

        .top-menu {
            display: flex;
            gap: 10px;
            align-items: center;
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
        <span>{{ auth()->user()->name }}</span>
    </div>
</nav>

<main class="container">
    <div class="card">
        <div class="header-row">
            <div>
                <h1 style="margin: 0;">Master Role</h1>
                <p style="margin: 6px 0 0; color: #6b7280;">
                    Kelola role dan hak akses dasar user sistem.
                </p>
            </div>

            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                + Tambah Role
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

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama Role</th>
                        <th>Slug</th>
                        <th>Deskripsi</th>
                        <th>Jumlah User</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td><strong>{{ $role->name }}</strong></td>
                            <td>
                                <span class="badge">{{ $role->slug }}</span>
                            </td>
                            <td>{{ $role->description ?? '-' }}</td>
                            <td>{{ $role->users_count }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Yakin hapus role ini?')">
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
                            <td colspan="5" style="text-align: center; color: #6b7280;">
                                Belum ada data role.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $roles->links() }}
        </div>
    </div>
</main>

</body>
</html>
