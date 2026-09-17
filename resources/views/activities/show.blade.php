<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Aktivitas</title>
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

        h1 {
            margin-top: 0;
            margin-bottom: 8px;
        }

        h2 {
            margin-top: 0;
        }

        .subtitle {
            color: #6b7280;
            margin-top: 0;
            margin-bottom: 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            margin-top: 20px;
        }

        .info-box {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 14px;
            background: #f9fafb;
        }

        .label {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .value {
            font-weight: bold;
            color: #111827;
        }

        .btn {
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .btn-warning {
            background: #f59e0b;
            color: #ffffff;
        }

        .btn-danger {
            background: #ef4444;
            color: #ffffff;
        }

        .button-row {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-module {
            background: #ccfbf1;
            color: #0f766e;
        }

        .badge-draft {
            background: #f3f4f6;
            color: #374151;
        }

        .badge-submitted {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-on_review {
            background: #e0e7ff;
            color: #3730a3;
        }

        .badge-revision {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-approved {
            background: #dcfce7;
            color: #166534;
        }

        .badge-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .content-box {
            line-height: 1.7;
            color: #374151;
            white-space: pre-line;
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
            padding: 20px;
        }

        @media (max-width: 800px) {
            .grid {
                grid-template-columns: 1fr;
            }

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
    <a href="{{ route('activities.index') }}" class="brand">
        Monitoring Aktivitas Perpustakaan
    </a>

    <div>
        {{ auth()->user()->name }}
    </div>
</nav>

<main class="container">
    <div class="card">
        <h1>Detail Aktivitas</h1>
        <p class="subtitle">
            Informasi lengkap aktivitas perpustakaan.
        </p>

        <div class="button-row">
            <a href="{{ route('activities.edit', $activity) }}" class="btn btn-warning">
                Edit Aktivitas
            </a>

            @if(in_array(auth()->user()->role?->slug, ['super_admin', 'admin', 'kepala_perpustakaan', 'koordinator']))
                <a href="{{ route('activities.review.edit', $activity) }}" class="btn" style="background:#0f766e; color:#fff;">
                    Review
                </a>
            @endif

            <a href="{{ route('activities.index') }}" class="btn btn-secondary">
                Kembali
            </a>

            <form action="{{ route('activities.destroy', $activity) }}" method="POST"
                  onsubmit="return confirm('Yakin hapus aktivitas ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    Hapus
                </button>
            </form>
        </div>

        <h2 style="margin-bottom: 4px;">
            {{ $activity->title }}
        </h2>

        <div>
            <span class="badge badge-module">
                {{ $activity->module->name ?? '-' }}
            </span>

            <span class="badge badge-{{ $activity->status }}">
                {{ ucwords(str_replace('_', ' ', $activity->status)) }}
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
                <div class="label">Jenis Aktivitas</div>
                <div class="value">
                    {{ $activity->category->name ?? '-' }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Dibuat Oleh</div>
                <div class="value">
                    {{ $activity->creator->name ?? '-' }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Petugas / PIC</div>
                <div class="value">
                    {{ $activity->assignedUser->name ?? '-' }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Jumlah / Output</div>
                <div class="value">
                    {{ $activity->quantity ?? '-' }} {{ $activity->unit }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Sumber Input</div>
                <div class="value">
                    {{ ucwords(str_replace('_', ' ', $activity->input_source)) }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Wajib Bukti</div>
                <div class="value">
                    {{ $activity->evidence_required ? 'Ya' : 'Tidak' }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Tanggal Input</div>
                <div class="value">
                    {{ $activity->created_at ? $activity->created_at->format('d-m-Y H:i') : '-' }}
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Deskripsi</h2>
        <div class="content-box">
            {{ $activity->description ?? '-' }}
        </div>
    </div>

    <div class="card">
        <h2>Catatan</h2>
        <div class="content-box">
            {{ $activity->notes ?? '-' }}
        </div>
    </div>

    <div class="card">
        <h2>Riwayat Status</h2>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Status Lama</th>
                        <th>Status Baru</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activity->statusLogs as $log)
                        <tr>
                            <td>
                                {{ $log->created_at ? $log->created_at->format('d-m-Y H:i') : '-' }}
                            </td>
                            <td>
                                {{ $log->changedBy->name ?? '-' }}
                            </td>
                            <td>
                                {{ $log->old_status ? ucwords(str_replace('_', ' ', $log->old_status)) : '-' }}
                            </td>
                            <td>
                                {{ ucwords(str_replace('_', ' ', $log->new_status)) }}
                            </td>
                            <td>
                                {{ $log->note ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                Belum ada riwayat status.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <h2>Bukti / Dokumen Pendukung</h2>
        <p class="subtitle">
            Upload bukti aktivitas seperti foto kegiatan, PDF, Excel, Word, atau dokumen pendukung lainnya.
        </p>

        @if(session('success'))
            <div style="background:#dcfce7; color:#166534; padding:12px; border-radius:10px; margin-bottom:16px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:10px; margin-bottom:16px;">
                <strong>Upload gagal:</strong>
                <ul style="margin-bottom:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('activities.files.store', $activity) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid">
                <div class="info-box">
                    <label style="font-weight:bold; display:block; margin-bottom:8px;">File Bukti</label>
                    <input type="file" name="file" required>
                    <div style="font-size:12px; color:#6b7280; margin-top:6px;">
                        Format: JPG, PNG, PDF, Word, Excel, PPT. Maksimal 10 MB.
                    </div>
                </div>

                <div class="info-box">
                    <label style="font-weight:bold; display:block; margin-bottom:8px;">Jenis File</label>
                    <select name="file_type" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                        <option value="">Pilih Jenis File</option>
                        <option value="foto">Foto</option>
                        <option value="dokumen">Dokumen</option>
                        <option value="invoice">Invoice</option>
                        <option value="bast">BAST</option>
                        <option value="poster">Poster</option>
                        <option value="laporan">Laporan</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
            </div>

            <div style="margin-top:16px;">
                <label style="font-weight:bold; display:block; margin-bottom:8px;">Deskripsi File</label>
                <textarea name="description"
                        style="width:100%; min-height:80px; padding:11px; border:1px solid #d1d5db; border-radius:8px;"
                        placeholder="Contoh: Foto bukti kegiatan katalogisasi buku baru"></textarea>
            </div>

            <div style="margin-top:16px;">
                <button type="submit" class="btn" style="background:#0f766e; color:#fff;">
                    Upload Bukti
                </button>
            </div>
        </form>

        <hr style="margin:24px 0; border:none; border-top:1px solid #e5e7eb;">

        <h3>Daftar Bukti</h3>

        <table>
            <thead>
                <tr>
                    <th>Nama File</th>
                    <th>Jenis</th>
                    <th>Ukuran</th>
                    <th>Upload Oleh</th>
                    <th>Waktu</th>
                    <th width="180">Aksi</th>
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
                        <td>
                            {{ $file->file_size ? number_format($file->file_size / 1024, 1) . ' KB' : '-' }}
                        </td>
                        <td>{{ $file->uploader->name ?? '-' }}</td>
                        <td>{{ $file->created_at ? $file->created_at->format('d-m-Y H:i') : '-' }}</td>
                        <td>
                            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                @if($file->file_path)
                                    <a href="{{ asset('storage/' . $file->file_path) }}"
                                    target="_blank"
                                    class="btn"
                                    style="background:#0284c7; color:#fff;">
                                        Buka
                                    </a>
                                @endif

                                <form action="{{ route('activity-files.destroy', $file) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin hapus file bukti ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="background:#ef4444; color:#fff;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">
                            Belum ada file bukti untuk aktivitas ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
