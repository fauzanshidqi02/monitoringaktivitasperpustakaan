<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Review Aktivitas</title>
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
        }

        .brand {
            font-weight: bold;
            color: #0f766e;
            text-decoration: none;
            font-size: 18px;
        }

        .container {
            padding: 32px;
        }

        .card {
            background: #ffffff;
            padding: 24px;
            border-radius: 18px;
            box-shadow: 0 8px 22px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        h1, h2 {
            margin-top: 0;
        }

        .subtitle {
            color: #6b7280;
            margin-top: 0;
            line-height: 1.6;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .info-box {
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            border-radius: 12px;
            padding: 14px;
        }

        .label {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .value {
            font-weight: bold;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        select, textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }

        textarea {
            min-height: 130px;
            resize: vertical;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .btn {
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            border: none;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
        }

        .btn-primary { background: #0f766e; color: #ffffff; }
        .btn-secondary { background: #e5e7eb; color: #111827; }
        .btn-info { background: #0284c7; color: #ffffff; }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            margin-right: 6px;
            margin-bottom: 6px;
        }

        .badge-module {
            background: #ccfbf1;
            color: #0f766e;
        }

        .badge-status {
            background: #e0f2fe;
            color: #075985;
        }

        .content-box {
            line-height: 1.7;
            white-space: pre-line;
            color: #374151;
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
            vertical-align: top;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 18px;
        }

        @media (max-width: 800px) {
            .grid { grid-template-columns: 1fr; }

            .navbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile-fix.css') }}">
</head>
<body>

<nav class="navbar">
    <a href="{{ route('activities.show', $activity) }}" class="brand">
        Monitoring Aktivitas Perpustakaan
    </a>

    <div>{{ auth()->user()->name }}</div>
</nav>

<main class="container">
    <div class="card">
        <h1>Review Aktivitas</h1>
        <p class="subtitle">
            Ubah status aktivitas dan berikan catatan review bila diperlukan.
        </p>

        <h2>{{ $activity->title }}</h2>

        <div style="margin-bottom: 18px;">
            <span class="badge badge-status">
                {{ ucwords(str_replace('_', ' ', $activity->status)) }}
            </span>

            <span class="badge badge-module">
                {{ $activity->module->name ?? '-' }}
            </span>

            <span class="badge badge-module">
                {{ $activity->category->name ?? '-' }}
            </span>
        </div>

        <div class="grid">
            <div class="info-box">
                <div class="label">Tanggal Aktivitas</div>
                <div class="value">
                    {{ $activity->activity_date ? $activity->activity_date->format('d-m-Y') : '-' }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Petugas / PIC</div>
                <div class="value">
                    {{ $activity->assignedUser->name ?? '-' }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Dibuat Oleh</div>
                <div class="value">
                    {{ $activity->creator->name ?? '-' }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Jumlah / Output</div>
                <div class="value">
                    {{ $activity->quantity ?? '-' }} {{ $activity->unit }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Disetujui Oleh</div>
                <div class="value">
                    {{ $activity->approver->name ?? '-' }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Tanggal Approval</div>
                <div class="value">
                    {{ $activity->approved_at ? $activity->approved_at->format('d-m-Y H:i') : '-' }}
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Deskripsi Aktivitas</h2>
        <div class="content-box">
            {{ $activity->description ?? '-' }}
        </div>
    </div>

    <div class="card">
        <h2>Form Review</h2>

        <form action="{{ route('activities.review.update', $activity) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Status Baru</label>
                <select name="status">
                    <option value="on_review" {{ old('status', $activity->status) === 'on_review' ? 'selected' : '' }}>
                        On Review
                    </option>
                    <option value="revision" {{ old('status', $activity->status) === 'revision' ? 'selected' : '' }}>
                        Revision
                    </option>
                    <option value="approved" {{ old('status', $activity->status) === 'approved' ? 'selected' : '' }}>
                        Approved
                    </option>
                    <option value="completed" {{ old('status', $activity->status) === 'completed' ? 'selected' : '' }}>
                        Completed
                    </option>
                    <option value="rejected" {{ old('status', $activity->status) === 'rejected' ? 'selected' : '' }}>
                        Rejected
                    </option>
                </select>

                @error('status')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Catatan Review</label>
                <textarea name="note" placeholder="Contoh: Data sudah sesuai / Mohon lengkapi bukti kegiatan...">{{ old('note') }}</textarea>

                @error('note')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan Review
            </button>

            <a href="{{ route('activities.show', $activity) }}" class="btn btn-secondary">
                Kembali
            </a>
        </form>
    </div>

    <div class="card">
        <h2>Bukti Aktivitas</h2>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama File</th>
                        <th>Jenis</th>
                        <th>Upload Oleh</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activity->files as $file)
                        <tr>
                            <td>
                                <strong>{{ $file->original_name }}</strong><br>
                                <small style="color:#6b7280;">
                                    {{ $file->description ?? '-' }}
                                </small>
                            </td>
                            <td>{{ $file->file_type ? ucwords($file->file_type) : '-' }}</td>
                            <td>{{ $file->uploader->name ?? '-' }}</td>
                            <td>{{ $file->created_at ? $file->created_at->format('d-m-Y H:i') : '-' }}</td>
                            <td>
                                @if($file->file_path)
                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-info">
                                        Buka File
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                Belum ada bukti aktivitas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <h2>Catatan Review Sebelumnya</h2>

        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Tipe</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activity->comments as $comment)
                    <tr>
                        <td>{{ $comment->created_at ? $comment->created_at->format('d-m-Y H:i') : '-' }}</td>
                        <td>{{ $comment->user->name ?? '-' }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $comment->comment_type)) }}</td>
                        <td>{{ $comment->comment }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty">
                            Belum ada catatan review.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
