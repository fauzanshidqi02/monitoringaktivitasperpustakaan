@extends('layouts.app')

@section('title', 'Tambah User')

@section('styles')
    <style>
        .form-card {
            max-width: 760px;
            background: #ffffff;
            padding: 26px;
            border-radius: 18px;
            box-shadow: 0 8px 22px rgba(0,0,0,0.05);
        }

        .form-card h1 {
            margin: 0;
            font-size: 30px;
            color: #111827;
        }

        .form-card .subtitle {
            color: #6b7280;
            margin: 8px 0 24px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
            color: #111827;
        }

        input,
        select {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background: #ffffff;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #0f766e;
            box-shadow: 0 0 0 3px rgba(15,118,110,0.12);
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

        .checkbox-row label {
            margin: 0;
        }

        .button-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
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

        .btn-primary {
            background: #0f766e;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #0d665f;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        @media (max-width: 700px) {
            .form-card {
                padding: 20px;
                border-radius: 14px;
            }

            .form-card h1 {
                font-size: 24px;
            }

            .button-row {
                flex-direction: column;
                align-items: stretch;
            }

            .button-row .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    <div class="form-card">
        <h1>Tambah User</h1>

        <p class="subtitle">
            Masukkan data user yang boleh login menggunakan akun Gmail.
        </p>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Contoh: Ahmad Fauzan"
                    autocomplete="name"
                >

                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Email Gmail</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@gmail.com"
                    autocomplete="email"
                >

                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role_id">
                    <option value="">Pilih Role</option>

                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>

                @error('role_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group checkbox-row">
                <input
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    {{ old('is_active', true) ? 'checked' : '' }}
                >

                <label for="is_active">Akun Aktif</label>
            </div>

            <div class="button-row">
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>

                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
