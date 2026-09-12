<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Modul Aktivitas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
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
            max-width: 700px;
            background: #ffffff;
            padding: 24px;
            border-radius: 18px;
            box-shadow: 0 8px 22px rgba(0,0,0,0.05);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input, textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
        }

        textarea {
            min-height: 100px;
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
        }

        .btn-primary {
            background: #0f766e;
            color: #ffffff;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .hint {
            color: #6b7280;
            font-size: 13px;
            margin-top: 5px;
        }

        .checkbox-row {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .checkbox-row input {
            width: auto;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="{{ route('dashboard') }}" class="brand">
        Monitoring Aktivitas Perpustakaan
    </a>
</nav>

<main class="container">
    <div class="card">
        <h1>Tambah Modul Aktivitas</h1>

        <form action="{{ route('modules.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Modul</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Pengolahan">
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" placeholder="Contoh: pengolahan">
                <div class="hint">Boleh dikosongkan, sistem akan membuat slug otomatis.</div>
                @error('slug')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" placeholder="Deskripsi modul...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Urutan Tampil</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                @error('sort_order')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group checkbox-row">
                <input type="checkbox" name="is_active" value="1" checked>
                <label style="margin: 0;">Modul Aktif</label>
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan
            </button>

            <a href="{{ route('modules.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </form>
    </div>
</main>

</body>
</html>
