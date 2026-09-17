<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Aktivitas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7f6; color: #1f2937; }
        .navbar { background: #fff; padding: 16px 32px; border-bottom: 1px solid #e5e7eb; }
        .brand { font-weight: bold; color: #0f766e; text-decoration: none; font-size: 18px; }
        .container { padding: 32px; }
        .card { max-width: 850px; background: #fff; padding: 24px; border-radius: 18px; box-shadow: 0 8px 22px rgba(0,0,0,0.05); }
        label { display: block; font-weight: bold; margin-bottom: 6px; }
        input, select, textarea { width: 100%; padding: 11px; border: 1px solid #d1d5db; border-radius: 8px; }
        textarea { min-height: 110px; resize: vertical; }
        .form-group { margin-bottom: 16px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .btn { padding: 10px 15px; border-radius: 8px; font-weight: bold; text-decoration: none; border: none; cursor: pointer; display: inline-block; }
        .btn-primary { background: #0f766e; color: #fff; }
        .btn-secondary { background: #e5e7eb; color: #111827; }
        .error { color: #dc2626; font-size: 13px; margin-top: 5px; }
        .checkbox-row { display: flex; gap: 8px; align-items: center; }
        .checkbox-row input { width: auto; }
        @media (max-width: 800px) { .grid { grid-template-columns: 1fr; } }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile-fix.css') }}">
</head>
<body>

<nav class="navbar">
    <a href="{{ route('activities.index') }}" class="brand">
        Monitoring Aktivitas Perpustakaan
    </a>
</nav>

<main class="container">
    <div class="card">
        <h1>Tambah Aktivitas Manual</h1>

        <form action="{{ route('activities.store') }}" method="POST">
            @csrf

            <div class="grid">
                <div class="form-group">
                    <label>Modul</label>
                    <select name="module_id" id="module_id">
                        <option value="">Pilih Modul</option>
                        @foreach($modules as $module)
                            <option value="{{ $module->id }}" {{ old('module_id') == $module->id ? 'selected' : '' }}>
                                {{ $module->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('module_id') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Jenis Aktivitas</label>
                    <select name="activity_category_id" id="activity_category_id">
                        <option value="">Pilih Jenis Aktivitas</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                    data-module="{{ $category->module_id }}"
                                    {{ old('activity_category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('activity_category_id') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Judul Aktivitas</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Katalogisasi buku baru">
                @error('title') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" placeholder="Uraian aktivitas...">{{ old('description') }}</textarea>
                @error('description') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="grid">
                <div class="form-group">
                    <label>Tanggal Aktivitas</label>
                    <input type="date" name="activity_date" value="{{ old('activity_date', date('Y-m-d')) }}">
                    @error('activity_date') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Petugas / PIC</label>
                    <select name="assigned_to">
                        <option value="">Pilih Petugas</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} - {{ $user->role->name ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_to') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="grid">
                <div class="form-group">
                    <label>Jumlah / Output</label>
                    <input type="number" name="quantity" value="{{ old('quantity') }}" min="0" placeholder="Contoh: 25">
                    @error('quantity') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Satuan</label>
                    <input type="text" name="unit" value="{{ old('unit') }}" placeholder="Contoh: buku, orang, file, konten">
                    @error('unit') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Status Awal</label>
                <select name="status">
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="submitted" {{ old('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                </select>
                @error('status') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group checkbox-row">
                <input type="checkbox" name="evidence_required" value="1" {{ old('evidence_required') ? 'checked' : '' }}>
                <label style="margin: 0;">Wajib Bukti / Dokumen Pendukung</label>
            </div>

            <div class="form-group">
                <label>Catatan</label>
                <textarea name="notes" placeholder="Catatan tambahan...">{{ old('notes') }}</textarea>
                @error('notes') <div class="error">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('activities.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</main>

<script>
    const moduleSelect = document.getElementById('module_id');
    const categorySelect = document.getElementById('activity_category_id');
    const selectedCategory = "{{ old('activity_category_id') }}";
    const categoryOptions = Array.from(categorySelect.options);

    function filterCategories() {
        const selectedModule = moduleSelect.value;

        categorySelect.innerHTML = '';

        categoryOptions.forEach(option => {
            if (option.value === '' || option.dataset.module === selectedModule) {
                categorySelect.appendChild(option);
            }
        });

        if (selectedCategory) {
            categorySelect.value = selectedCategory;
        }
    }

    moduleSelect.addEventListener('change', filterCategories);
    filterCategories();
</script>

</body>
</html>
