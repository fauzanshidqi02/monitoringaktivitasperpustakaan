<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
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

        input, select {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
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

        .checkbox-row {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .checkbox-row input {
            width: auto;
        }

        .avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #0f766e;
            margin-bottom: 16px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile-fix.css') }}">
</head>
<body>

<nav class="navbar">
    <a href="{{ route('dashboard') }}" class="brand">
        Monitoring Aktivitas Perpustakaan
    </a>
</nav>

<main class="container">
    <div class="card">
        <h1>Edit User</h1>

        @if($user->avatar)
            <img src="{{ $user->avatar }}" class="avatar" alt="Avatar">
        @endif

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Email Gmail</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role_id">
                    <option value="">Pilih Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group checkbox-row">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                <label style="margin: 0;">Akun Aktif</label>
            </div>

            <button type="submit" class="btn btn-primary">
                Update
            </button>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </form>
    </div>
</main>

</body>
</html>
