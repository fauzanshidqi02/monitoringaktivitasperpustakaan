@extends('layouts.app')

@section('title', 'Master User')

@section('styles')
    <style>
        .user-card {
            background: #ffffff;
            padding: 24px;
            border-radius: 18px;
            box-shadow: 0 8px 22px rgba(0,0,0,0.05);
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px;
        }

        .header-row h1 {
            margin: 0;
            font-size: 30px;
            color: #111827;
        }

        .header-row p {
            margin: 6px 0 0;
            color: #6b7280;
            line-height: 1.5;
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
            white-space: nowrap;
        }

        .btn-primary {
            background: #0f766e;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #0d665f;
        }

        .btn-warning {
            background: #f59e0b;
            color: #ffffff;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-danger {
            background: #ef4444;
            color: #ffffff;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        .filter-box {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 10px;
            margin-bottom: 20px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
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

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th {
            background: #f9fafb;
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            color: #111827;
            font-size: 14px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
            font-size: 14px;
        }

        .badge {
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }

        .badge-active {
            background: #dcfce7;
            color: #166534;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 16px;
            line-height: 1.5;
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
            align-items: center;
        }

        .actions form {
            margin: 0;
        }

        .user-top {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-small {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #0f766e;
        }

        .avatar-placeholder {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #0f766e;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border: 2px solid #0f766e;
        }

        .pagination-custom {
            margin-top: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .pagination-info {
            font-size: 13px;
            color: #6b7280;
        }

        .pagination-links {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .pagination-links a,
        .pagination-links span {
            min-width: 34px;
            height: 34px;
            padding: 7px 10px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            text-decoration: none;
            color: #374151;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
        }

        .pagination-links a:hover {
            background: #ecfdf5;
            border-color: #0f766e;
            color: #0f766e;
        }

        .pagination-links .active-page {
            background: #0f766e;
            color: #ffffff;
            border-color: #0f766e;
            font-weight: bold;
        }

        .pagination-links .disabled-page {
            color: #9ca3af;
            background: #f9fafb;
        }

        @media (max-width: 900px) {
            .filter-box {
                grid-template-columns: 1fr;
            }

            .header-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-row .btn {
                width: 100%;
                text-align: center;
            }

            table {
                font-size: 13px;
            }

            .pagination-custom {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endsection

@section('content')
    <div class="user-card">
        <div class="header-row">
            <div>
                <h1>Master User</h1>
                <p>
                    Kelola user yang boleh login menggunakan akun Gmail.
                </p>
            </div>

            <a href="{{ route('users.create') }}" class="btn btn-primary">
                + Tambah User
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

        <form method="GET" action="{{ route('users.index') }}" class="filter-box">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama atau email..."
            >

            <select name="role_id">
                <option value="">Semua Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>

            <select name="status">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                    Aktif
                </option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                    Nonaktif
                </option>
            </select>

            <button type="submit" class="btn btn-secondary">
                Filter
            </button>
        </form>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Login Terakhir</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="user-top">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar }}" class="avatar-small" alt="Avatar">
                                    @else
                                        <div class="avatar-placeholder">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <strong>{{ $user->name }}</strong>
                                </div>
                            </td>

                            <td>{{ $user->email }}</td>

                            <td>{{ $user->role->name ?? '-' }}</td>

                            <td>
                                @if($user->is_active)
                                    <span class="badge badge-active">Aktif</span>
                                @else
                                    <span class="badge badge-inactive">Nonaktif</span>
                                @endif
                            </td>

                            <td>
                                {{ $user->last_login_at ? $user->last_login_at->timezone(config('app.timezone', 'Asia/Jakarta'))->format('d-m-Y H:i') : '-' }}
                            </td>

                            <td>
                                <div class="actions">
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
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
                            <td colspan="6" style="text-align: center; color: #6b7280;">
                                Belum ada data user.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="pagination-custom">
                <div class="pagination-info">
                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }}
                    dari {{ $users->total() }} data
                </div>

                <div class="pagination-links">
                    @if($users->onFirstPage())
                        <span class="disabled-page">‹</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}">‹</a>
                    @endif

                    @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        @if($page == $users->currentPage())
                            <span class="active-page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}">›</a>
                    @else
                        <span class="disabled-page">›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
