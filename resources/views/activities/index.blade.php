<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aktivitas Perpustakaan</title>
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

        .btn-primary { background: #0f766e; color: #ffffff; }
        .btn-warning { background: #f59e0b; color: #ffffff; }
        .btn-danger { background: #ef4444; color: #ffffff; }
        .btn-info { background: #0284c7; color: #ffffff; }
        .btn-secondary { background: #e5e7eb; color: #111827; }

        .filter-box {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr auto;
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

        .badge-module { background: #ccfbf1; color: #0f766e; }
        .badge-draft { background: #f3f4f6; color: #374151; }
        .badge-submitted { background: #dbeafe; color: #1d4ed8; }
        .badge-on_review { background: #e0e7ff; color: #3730a3; }
        .badge-revision { background: #fef3c7; color: #92400e; }
        .badge-approved { background: #dcfce7; color: #166534; }
        .badge-completed { background: #d1fae5; color: #065f46; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }

        .alert {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 16px;
        }

        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
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
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Dashboard</a>
        <span>{{ auth()->user()->name }}</span>
    </div>
</nav>

<main class="container">
    <div class="card">
        <div class="header-row">
            <div>
                <h1 style="margin: 0;">Aktivitas Perpustakaan</h1>
                <p style="margin: 6px 0 0; color: #6b7280;">
                    Kelola aktivitas manual perpustakaan.
                </p>
            </div>

            <a href="{{ route('activities.create') }}" class="btn btn-primary">
                + Tambah Aktivitas
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <form method="GET" action="{{ route('activities.index') }}" class="filter-box">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas...">

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
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                <option value="on_review" {{ request('status') === 'on_review' ? 'selected' : '' }}>On Review</option>
                <option value="revision" {{ request('status') === 'revision' ? 'selected' : '' }}>Revision</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            <input type="date" name="activity_date" value="{{ request('activity_date') }}">

            <button type="submit" class="btn btn-secondary">Filter</button>
        </form>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Modul</th>
                        <th>Jenis</th>
                        <th>Judul</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Input</th>
                        <th width="220">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                        <tr>
                            <td>{{ $activity->activity_date?->format('d-m-Y') }}</td>
                            <td>
                                <span class="badge badge-module">
                                    {{ $activity->module->name ?? '-' }}
                                </span>
                            </td>
                            <td>{{ $activity->category->name ?? '-' }}</td>
                            <td>
                                <strong>{{ $activity->title }}</strong><br>
                                <small style="color:#6b7280;">
                                    Oleh: {{ $activity->creator->name ?? '-' }}
                                </small>
                            </td>
                            <td>
                                {{ $activity->quantity ?? '-' }} {{ $activity->unit }}
                            </td>
                            <td>
                                <span class="badge badge-{{ $activity->status }}">
                                    {{ ucwords(str_replace('_', ' ', $activity->status)) }}
                                </span>
                            </td>
                            <td>{{ ucwords(str_replace('_', ' ', $activity->input_source)) }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('activities.show', $activity) }}" class="btn btn-info">Detail</a>
                                    <a href="{{ route('activities.edit', $activity) }}" class="btn btn-warning">Edit</a>

                                    <form action="{{ route('activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Yakin hapus aktivitas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; color:#6b7280;">
                                Belum ada data aktivitas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($activities->hasPages())
            <div class="pagination-info">
                Menampilkan {{ $activities->firstItem() }} sampai {{ $activities->lastItem() }}
                dari {{ $activities->total() }} data
            </div>

            <div class="custom-pagination">
                @if ($activities->onFirstPage())
                    <span class="page-link disabled">‹ Previous</span>
                @else
                    <a class="page-link" href="{{ $activities->previousPageUrl() }}">‹ Previous</a>
                @endif

                @for ($page = 1; $page <= $activities->lastPage(); $page++)
                    @if ($page == $activities->currentPage())
                        <span class="page-link active">{{ $page }}</span>
                    @else
                        <a class="page-link" href="{{ $activities->url($page) }}">{{ $page }}</a>
                    @endif
                @endfor

                @if ($activities->hasMorePages())
                    <a class="page-link" href="{{ $activities->nextPageUrl() }}">Next ›</a>
                @else
                    <span class="page-link disabled">Next ›</span>
                @endif
            </div>
        @endif
    </div>
</main>

</body>
</html>
