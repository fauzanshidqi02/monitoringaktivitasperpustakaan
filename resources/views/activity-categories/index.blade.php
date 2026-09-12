<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jenis Aktivitas</title>
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
            grid-template-columns: 2fr 1fr 1fr auto;
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

        .badge-module {
            background: #ccfbf1;
            color: #0f766e;
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
        .pagination-info {
            margin-top: 16px;
            color: #6b7280;
            font-size: 13px;
        }

        .custom-pagination {
            margin-top: 12px;
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .page-link {
            padding: 8px 12px;
            border-radius: 8px;
            background: #ffffff;
            border: 1px solid #d1d5db;
            color: #0f766e;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
        }

        .page-link:hover {
            background: #ecfdf5;
        }

        .page-link.active {
            background: #0f766e;
            color: #ffffff;
            border-color: #0f766e;
        }

        .page-link.disabled {
            color: #9ca3af;
            background: #f3f4f6;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="{{ route('dashboard') }}" class="brand">
        Monitoring Aktivitas Perpustakaan
    </a>

    <div class="top-menu">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Master User</a>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Role</a>
        <a href="{{ route('modules.index') }}" class="btn btn-secondary">Modul</a>
        <span>{{ auth()->user()->name }}</span>
    </div>
</nav>

<main class="container">
    <div class="card">
        <div class="header-row">
            <div>
                <h1 style="margin: 0;">Jenis Aktivitas</h1>
                <p style="margin: 6px 0 0; color: #6b7280;">
                    Kelola jenis aktivitas berdasarkan modul perpustakaan.
                </p>
            </div>

            <a href="{{ route('activity-categories.create') }}" class="btn btn-primary">
                + Tambah Jenis Aktivitas
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

        <form method="GET" action="{{ route('activity-categories.index') }}" class="filter-box">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari jenis aktivitas...">

            <select name="module_id">
                <option value="">Semua Modul</option>
                @foreach($modules as $module)
                    <option value="{{ $module->id }}" {{ request('module_id') == $module->id ? 'selected' : '' }}>
                        {{ $module->name }}
                    </option>
                @endforeach
            </select>

            <select name="status">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <button type="submit" class="btn btn-secondary">
                Filter
            </button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Urutan</th>
                    <th>Modul</th>
                    <th>Jenis Aktivitas</th>
                    <th>Slug</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th width="170">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->sort_order }}</td>
                        <td>
                            <span class="badge badge-module">
                                {{ $category->module->name ?? '-' }}
                            </span>
                        </td>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td>
                            <span class="badge badge-slug">
                                {{ $category->slug }}
                            </span>
                        </td>
                        <td>{{ $category->description ?? '-' }}</td>
                        <td>
                            @if($category->is_active)
                                <span class="badge badge-active">Aktif</span>
                            @else
                                <span class="badge badge-inactive">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('activity-categories.edit', $category) }}" class="btn btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('activity-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin hapus jenis aktivitas ini?')">
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
                        <td colspan="7" style="text-align: center; color: #6b7280;">
                            Belum ada data jenis aktivitas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($categories->hasPages())
        <div class="pagination-info">
            Menampilkan {{ $categories->firstItem() }} sampai {{ $categories->lastItem() }}
            dari {{ $categories->total() }} data
        </div>

        <div class="custom-pagination">
            @if ($categories->onFirstPage())
                <span class="page-link disabled">‹ Previous</span>
            @else
                <a class="page-link" href="{{ $categories->previousPageUrl() }}">‹ Previous</a>
            @endif

            @for ($page = 1; $page <= $categories->lastPage(); $page++)
                @if ($page == $categories->currentPage())
                    <span class="page-link active">{{ $page }}</span>
                @else
                    <a class="page-link" href="{{ $categories->url($page) }}">{{ $page }}</a>
                @endif
            @endfor

            @if ($categories->hasMorePages())
                <a class="page-link" href="{{ $categories->nextPageUrl() }}">Next ›</a>
            @else
                <span class="page-link disabled">Next ›</span>
            @endif
        </div>
    @endif
    </div>
</main>

</body>
</html>
