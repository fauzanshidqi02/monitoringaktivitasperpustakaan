@extends('layouts.app')

@section('title', 'Edit User')

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

        .avatar-preview {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px;
            border-radius: 14px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            margin-bottom: 20px;
        }

        .avatar-large {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #0f766e;
        }

        .avatar-placeholder-large {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #0f766e;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            font-weight: bold;
            border: 2px solid #0f766e;
        }

        .avatar-info strong {
            display: block;
            color: #111827;
            margin-bottom: 4px;
        }

        .avatar-info span {
            color: #6b7280;
            font-size: 13px;
            word-break: break-word;
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

            .avatar-preview {
                align-items: flex-start;
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
        <h1>Edit User</h1>

        <p class="subtitle">
            Perbarui data user, role, dan status akun.
        </p>

        <div class="avatar-preview">
            @if($user->avatar)
                <img src="{{ $user->avatar }}" class="avatar-large" alt="Avatar">
            @else
                <div class="avatar-placeholder-large">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif

            <div class="avatar-info">
                <strong>{{ $user->name }}</strong>
                <span>{{ $user->email }}</span>
            </div>
        </div>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
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
                    value="{{ old('email', $user->email) }}"
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
                <input
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                >

                <label for="is_active">Akun Aktif</label>
            </div>

            <div class="button-row">
                <button type="submit" class="btn btn-primary">
                    Update
                </button>

                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
