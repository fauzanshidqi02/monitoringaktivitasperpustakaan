<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aktivitas PDF</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #111827;
        }

        h1 {
            margin: 0;
            font-size: 18px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            margin-top: 4px;
            margin-bottom: 18px;
            color: #555;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        .info-table td {
            padding: 5px;
            border: 1px solid #ddd;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        .summary-table th,
        .summary-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
        }

        .summary-table th {
            background: #f3f4f6;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 5px;
            vertical-align: top;
        }

        .data-table th {
            background: #0f766e;
            color: #ffffff;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 18px;
            font-size: 9px;
            color: #555;
            text-align: right;
        }
    </style>
</head>
<body>

<h1>Laporan Aktivitas Perpustakaan</h1>
<div class="subtitle">
    Dicetak pada {{ now()->format('d-m-Y H:i') }}
</div>

<table class="info-table">
    <tr>
        <td width="20%"><strong>Tanggal Awal</strong></td>
        <td width="30%">{{ $filters['date_from'] }}</td>
        <td width="20%"><strong>Tanggal Akhir</strong></td>
        <td width="30%">{{ $filters['date_to'] }}</td>
    </tr>
    <tr>
        <td><strong>Modul</strong></td>
        <td>{{ $filters['module'] }}</td>
        <td><strong>Status</strong></td>
        <td>{{ $filters['status'] }}</td>
    </tr>
    <tr>
        <td><strong>Kata Kunci</strong></td>
        <td colspan="3">{{ $filters['search'] }}</td>
    </tr>
</table>

<table class="summary-table">
    <thead>
        <tr>
            <th>Total</th>
            <th>Draft</th>
            <th>Submitted</th>
            <th>On Review</th>
            <th>Revision</th>
            <th>Approved</th>
            <th>Completed</th>
            <th>Rejected</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $summary['total'] }}</td>
            <td>{{ $summary['draft'] }}</td>
            <td>{{ $summary['submitted'] }}</td>
            <td>{{ $summary['on_review'] }}</td>
            <td>{{ $summary['revision'] }}</td>
            <td>{{ $summary['approved'] }}</td>
            <td>{{ $summary['completed'] }}</td>
            <td>{{ $summary['rejected'] }}</td>
        </tr>
    </tbody>
</table>

<table class="data-table">
    <thead>
        <tr>
            <th width="8%">Tanggal</th>
            <th width="18%">Aktivitas</th>
            <th width="13%">Modul</th>
            <th width="10%">PIC</th>
            <th width="8%">Jumlah</th>
            <th width="10%">Status</th>
            <th width="13%">Approval</th>
            <th width="20%">Catatan</th>
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
                    {{ $activity->description ?? '-' }}
                </td>

                <td>
                    {{ $activity->module->name ?? '-' }}<br>
                    <small>{{ $activity->category->name ?? '-' }}</small>
                </td>

                <td>
                    {{ $activity->assignedUser->name ?? '-' }}
                </td>

                <td class="text-center">
                    {{ $activity->quantity ?? '-' }} {{ $activity->unit }}
                </td>

                <td>
                    {{ ucwords(str_replace('_', ' ', $activity->status)) }}
                </td>

                <td>
                    @if($activity->approved_at)
                        {{ $activity->approver->name ?? '-' }}<br>
                        {{ $activity->approved_at->format('d-m-Y H:i') }}
                    @else
                        -
                    @endif
                </td>

                <td>
                    {{ $activity->notes ?? '-' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">
                    Tidak ada data aktivitas sesuai filter.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    Sistem Monitoring Aktivitas Perpustakaan
</div>

</body>
</html>
