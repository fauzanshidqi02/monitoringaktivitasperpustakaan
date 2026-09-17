<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aktivitas - Monitoring Aktivitas Perpustakaan</title>
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
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }

        .brand {
            font-weight: bold;
            color: #0f766e;
            font-size: 18px;
            text-decoration: none;
        }

        .nav-right {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .container {
            padding: 32px;
        }

        .card {
            background: #ffffff;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 8px 22px rgba(0,0,0,0.05);
            margin-bottom: 22px;
        }

        h1, h2 {
            margin-top: 0;
        }

        .subtitle {
            color: #6b7280;
            line-height: 1.6;
        }

        .btn {
            border: none;
            border-radius: 8px;
            padding: 10px 14px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
        }

        .btn-primary {
            background: #0f766e;
            color: #ffffff;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .btn-info {
            background: #0284c7;
            color: #ffffff;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 14px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
            font-size: 14px;
        }

        input, select {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px;
            font-size: 14px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .summary-card {
            border-radius: 14px;
            padding: 18px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-left: 5px solid #0f766e;
        }

        .summary-label {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .summary-value {
            font-size: 24px;
            font-weight: bold;
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
            font-size: 14px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
            font-size: 14px;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-draft { background: #f3f4f6; color: #374151; }
        .badge-submitted { background: #dbeafe; color: #1d4ed8; }
        .badge-on_review { background: #fef3c7; color: #92400e; }
        .badge-revision { background: #ffedd5; color: #c2410c; }
        .badge-approved { background: #dcfce7; color: #166534; }
        .badge-completed { background: #ccfbf1; color: #0f766e; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 20px;
        }

        .pagination {
            margin-top: 18px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            text-decoration: none;
            color: #111827;
            background: #ffffff;
            font-size: 14px;
        }

        .pagination .active {
            background: #0f766e;
            color: #ffffff;
            border-color: #0f766e;
        }

        .pagination .disabled {
            color: #9ca3af;
            background: #f3f4f6;
        }

        @media (max-width: 1000px) {
            .filter-grid,
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 700px) {
            .filter-grid,
            .summary-grid {
                grid-template-columns: 1fr;
            }

            .navbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            table {
                font-size: 13px;
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

    <div class="nav-right">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            Dashboard
        </a>

        <a href="{{ route('activities.index') }}" class="btn btn-info">
            Aktivitas
        </a>
    </div>
</nav>

<main class="container">
    <section class="card">
        <h1>Laporan Aktivitas</h1>
        <p class="subtitle">
            Gunakan halaman ini untuk melihat rekap aktivitas perpustakaan berdasarkan tanggal,
            modul, status, dan kata kunci.
        </p>
    </section>

    <section class="card">
        <h2>Filter Laporan</h2>

        <form action="{{ route('reports.activities') }}" method="GET">
            <div class="filter-grid">
                <div class="form-group">
                    <label>Tanggal Awal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}">
                </div>

                <div class="form-group">
                    <label>Tanggal Akhir</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}">
                </div>

                <div class="form-group">
                    <label>Modul</label>
                    <select name="module_id">
                        <option value="">Semua Modul</option>
                        @foreach($modules as $module)
                            <option value="{{ $module->id }}" {{ request('module_id') == $module->id ? 'selected' : '' }}>
                                {{ $module->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="">Semua Status</option>
                        @foreach(['draft', 'submitted', 'on_review', 'revision', 'approved', 'completed', 'rejected'] as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Kata Kunci</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas...">
                </div>
            </div>

            <div style="margin-top: 16px; display:flex; gap:10px; flex-wrap:wrap;">
                <button type="submit" class="btn btn-primary">
                    Terapkan Filter
                </button>

                <a href="{{ route('reports.activities') }}" class="btn btn-secondary">
                    Reset
                </a>

                <a href="{{ route('reports.activities.export', request()->query()) }}" class="btn btn-info">
                    Export Excel
                </a>
                <a href="{{ route('reports.activities.export-pdf', request()->query()) }}" class="btn btn-primary">
                    Export PDF
                </a>
            </div>
        </form>
    </section>

    <section class="card">
        <h2>Rekap Status</h2>

        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">Total Aktivitas</div>
                <div class="summary-value">{{ $summary['total'] }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Draft</div>
                <div class="summary-value">{{ $summary['draft'] }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Submitted</div>
                <div class="summary-value">{{ $summary['submitted'] }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">On Review</div>
                <div class="summary-value">{{ $summary['on_review'] }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Revision</div>
                <div class="summary-value">{{ $summary['revision'] }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Approved</div>
                <div class="summary-value">{{ $summary['approved'] }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Completed</div>
                <div class="summary-value">{{ $summary['completed'] }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Rejected</div>
                <div class="summary-value">{{ $summary['rejected'] }}</div>
            </div>
        </div>
    </section>

    <section class="card">
        <h2>Data Aktivitas</h2>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Aktivitas</th>
                        <th>Modul</th>
                        <th>PIC</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Approval</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                        <tr>
                            <td>
                                {{ $activity->activity_date ? $activity->activity_date->format('d-m-Y') : '-' }}
                            </td>

                            <td>
                                <strong>{{ $activity->title }}</strong><br>
                                <small style="color:#6b7280;">
                                    {{ \Illuminate\Support\Str::limit($activity->description, 80) }}
                                </small>
                            </td>

                            <td>
                                {{ $activity->module->name ?? '-' }}<br>
                                <small style="color:#6b7280;">
                                    {{ $activity->category->name ?? '-' }}
                                </small>
                            </td>

                            <td>
                                {{ $activity->assignedUser->name ?? '-' }}
                            </td>

                            <td>
                                {{ $activity->quantity ?? '-' }} {{ $activity->unit }}
                            </td>

                            <td>
                                <span class="badge badge-{{ $activity->status }}">
                                    {{ ucwords(str_replace('_', ' ', $activity->status)) }}
                                </span>
                            </td>

                            <td>
                                @if($activity->approved_at)
                                    {{ $activity->approver->name ?? '-' }}<br>
                                    <small style="color:#6b7280;">
                                        {{ $activity->approved_at->format('d-m-Y H:i') }}
                                    </small>
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('activities.show', $activity) }}" class="btn btn-secondary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty">
                                Tidak ada data aktivitas sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($activities->hasPages())
            <div class="pagination">
                @if($activities->onFirstPage())
                    <span class="disabled">Sebelumnya</span>
                @else
                    <a href="{{ $activities->previousPageUrl() }}">Sebelumnya</a>
                @endif

                @foreach($activities->getUrlRange(1, $activities->lastPage()) as $page => $url)
                    @if($page == $activities->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($activities->hasMorePages())
                    <a href="{{ $activities->nextPageUrl() }}">Berikutnya</a>
                @else
                    <span class="disabled">Berikutnya</span>
                @endif
            </div>
        @endif
    </section>
</main>

</body>
</html>
