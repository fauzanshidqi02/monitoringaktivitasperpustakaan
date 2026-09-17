@extends('layouts.app')

@section('title', 'Dashboard - Monitoring Aktivitas Perpustakaan')

@section('styles')
    .dashboard-panel {
        background: #ffffff;
        border-radius: 6px;
        box-shadow: 0 8px 22px rgba(0,0,0,0.07);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .panel-strip {
        height: 28px;
        background: #0d6efd;
    }

    .filter-area {
        padding: 24px 22px 16px;
    }

    .filter-label {
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
    }

    .filter-row {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .filter-row select {
        width: 320px;
        max-width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 5px;
        padding: 11px 12px;
        font-size: 14px;
        background: #ffffff;
    }

    .btn {
        border: none;
        border-radius: 5px;
        padding: 11px 18px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
    }

    .btn-primary {
        background: #0d6efd;
        color: #ffffff;
    }

    .btn-primary:hover {
        background: #0b5ed7;
    }

    .chart-card {
        margin: 8px 22px 26px;
        padding: 18px 20px 24px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.06);
        background: #ffffff;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        gap: 14px;
    }

    .chart-title {
        font-size: 18px;
        font-weight: 500;
        color: #111827;
    }

    .view-report {
        color: #0d6efd;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
        white-space: nowrap;
    }

    .view-report:hover {
        text-decoration: underline;
    }

    .chart-wrapper {
        position: relative;
        height: 350px;
        width: 100%;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-top: 22px;
    }

    .summary-card {
        border-radius: 6px;
        padding: 22px 24px;
        color: #ffffff;
        min-height: 112px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.12);
    }

    .summary-blue {
        background: #0d6efd;
    }

    .summary-gray {
        background: #cfd4da;
    }

    .summary-green {
        background: #28a745;
    }

    .summary-yellow {
        background: #ffc107;
    }

    .summary-label {
        font-size: 13px;
        font-weight: bold;
        line-height: 1.5;
        text-transform: uppercase;
        text-shadow: 0 1px 2px rgba(0,0,0,0.25);
    }

    .summary-value {
        font-size: 30px;
        font-weight: bold;
        margin-top: 6px;
        text-shadow: 0 2px 3px rgba(0,0,0,0.25);
    }

    @media (max-width: 1100px) {
        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .chart-wrapper {
            height: 320px;
        }
    }

    @media (max-width: 700px) {
        .filter-row {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-row select,
        .filter-row .btn {
            width: 100%;
        }

        .chart-card {
            margin: 8px 14px 20px;
            padding: 16px;
        }

        .chart-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .chart-wrapper {
            height: 280px;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }
    }
@endsection

@section('content')
    @php
        $summary = $summary ?? [
            'total' => 0,
            'draft' => 0,
            'submitted' => 0,
            'on_review' => 0,
            'revision' => 0,
            'approved' => 0,
            'completed' => 0,
            'rejected' => 0,
        ];

        $perluReview = ($summary['submitted'] ?? 0)
            + ($summary['on_review'] ?? 0)
            + ($summary['revision'] ?? 0);

        $years = $years ?? collect([now()->format('Y')]);
        $selectedYear = $selectedYear ?? now()->format('Y');
    @endphp

    <h1 class="page-title">
        Statistik Aktivitas Perpustakaan
    </h1>

    <section class="dashboard-panel">
        <div class="panel-strip"></div>

        <div class="filter-area">
            <form action="{{ route('dashboard') }}" method="GET">
                <label class="filter-label">Tahun</label>

                <div class="filter-row">
                    <select name="year">
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ (int) $selectedYear === (int) $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary">
                        Tampilkan
                    </button>
                </div>
            </form>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    Statistik Aktivitas Tahun {{ $selectedYear }}
                </div>

                <a href="{{ route('reports.activities', [
                    'date_from' => $selectedYear . '-01-01',
                    'date_to' => $selectedYear . '-12-31'
                ]) }}" class="view-report">
                    View Report
                </a>
            </div>

            <div class="chart-wrapper">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </section>

    <section class="summary-grid">
        <div class="summary-card summary-blue">
            <div class="summary-label">
                Total<br>Aktivitas
            </div>
            <div class="summary-value">
                {{ $summary['total'] ?? 0 }}
            </div>
        </div>

        <div class="summary-card summary-gray">
            <div class="summary-label">
                Perlu<br>Review
            </div>
            <div class="summary-value">
                {{ $perluReview }}
            </div>
        </div>

        <div class="summary-card summary-green">
            <div class="summary-label">
                Total<br>Approved
            </div>
            <div class="summary-value">
                {{ $summary['approved'] ?? 0 }}
            </div>
        </div>

        <div class="summary-card summary-yellow">
            <div class="summary-label">
                Total<br>Completed
            </div>
            <div class="summary-value">
                {{ $summary['completed'] ?? 0 }}
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('activityChart');

            if (!ctx) {
                return;
            }

            const chartLabels = @json($chartLabels ?? []);
            const chartDatasets = @json($chartDatasets ?? []);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: chartDatasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                boxWidth: 35,
                                padding: 18
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y + ' aktivitas';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(0,0,0,0.08)'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.08)'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
