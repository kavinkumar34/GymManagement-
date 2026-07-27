@extends('layouts.trainer-layout')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header" style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h4 class="mb-0">
                            <i class="fas fa-chart-bar me-2"></i> Progress Chart
                        </h4>
                        <div>
                            <span class="badge bg-light text-dark me-2">
                                <i class="fas fa-user me-1"></i> {{ $member->name ?? 'Member' }}
                            </span>
                            <a href="{{ route('trainer.progress.index') }}" class="btn btn-sm"
                                style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px;">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (isset($weights) && count($weights) > 0)
                        <!-- Stats -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-3 col-sm-6">
                                <div class="p-3"
                                    style="background: #f8fafc; border-radius: 12px; border-left: 4px solid #1a472a;">
                                    <small class="text-muted d-block">Current Weight</small>
                                    <h4 class="mb-0">
                                        @php
                                            $currentWeight = end($weights);
                                        @endphp
                                        {{ number_format($currentWeight, 2) }} Kg
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="p-3"
                                    style="background: #f0fdf4; border-radius: 12px; border-left: 4px solid #10b981;">
                                    <small class="text-muted d-block">Starting Weight</small>
                                    <h4 class="mb-0" style="color: #10b981;">
                                        @php
                                            $startWeight = $weights[0] ?? 0;
                                        @endphp
                                        {{ number_format($startWeight, 2) }} Kg
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="p-3"
                                    style="background: #fef3c7; border-radius: 12px; border-left: 4px solid #f59e0b;">
                                    <small class="text-muted d-block">Progress</small>
                                    <h4 class="mb-0" style="color: #f59e0b;">
                                        @php
                                            $start = $weights[0] ?? 0;
                                            $end = end($weights) ?? 0;
                                            $diff = $start - $end;
                                        @endphp
                                        @if ($diff > 0)
                                            <span style="color: #10b981;">-{{ number_format($diff, 2) }} Kg</span>
                                        @elseif($diff < 0)
                                            <span style="color: #ef4444;">+{{ number_format(abs($diff), 2) }} Kg</span>
                                        @else
                                            <span style="color: #6b7280;">No Change</span>
                                        @endif
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="p-3"
                                    style="background: #fef2f2; border-radius: 12px; border-left: 4px solid #8b5cf6;">
                                    <small class="text-muted d-block">Total Records</small>
                                    <h4 class="mb-0" style="color: #8b5cf6;">{{ count($weights) }}</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Chart -->
                        <div style="position: relative; height: 350px; width: 100%;">
                            <canvas id="progressChart"></canvas>
                        </div>

                        <div class="mt-3 text-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i> Weight and BMI progress over time
                            </small>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-bar fa-4x text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">No Data Available</h5>
                            <p class="text-muted">Add progress records to see the chart.</p>
                            <a href="{{ route('trainer.progress.create') }}" class="btn"
                                style="background: #0d2818; color: white; border-radius: 8px; padding: 8px 25px;">
                                <i class="fas fa-plus me-2"></i> Add Progress
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (isset($weights) && count($weights) > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('progressChart').getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($dates),
                        datasets: [{
                                label: 'Weight (Kg)',
                                data: @json($weights),
                                borderColor: '#0d2818',
                                backgroundColor: 'rgba(13,40,24,0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.3,
                                pointBackgroundColor: '#0d2818',
                                pointBorderColor: '#0d2818',
                                pointRadius: 5,
                                pointHoverRadius: 8
                            },
                            {
                                label: 'BMI',
                                data: @json($bmis),
                                borderColor: '#ffd54f',
                                backgroundColor: 'rgba(255,213,79,0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.3,
                                pointBackgroundColor: '#ffd54f',
                                pointBorderColor: '#ffd54f',
                                pointRadius: 5,
                                pointHoverRadius: 8,
                                yAxisID: 'y1'
                            }
                        ]
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
                                    usePointStyle: true,
                                    padding: 20,
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(13,40,24,0.9)',
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                padding: 12,
                                cornerRadius: 8
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            y: {
                                beginAtZero: false,
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Weight (Kg)',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    }
                                }
                            },
                            y1: {
                                position: 'right',
                                beginAtZero: false,
                                grid: {
                                    drawOnChartArea: false
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'BMI',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif

    @push('styles')
        <style>
            @media (max-width: 768px) {
                .card-header .d-flex {
                    flex-direction: column;
                    gap: 10px;
                    align-items: flex-start !important;
                }

                .row.g-3 .col-md-3 {
                    margin-bottom: 15px;
                }
            }

            @media (max-width: 576px) {
                .card-header h4 {
                    font-size: 1rem;
                }

                .p-3 {
                    padding: 12px !important;
                }

                .p-3 h4 {
                    font-size: 1.3rem !important;
                }

                .p-3 small {
                    font-size: 0.7rem !important;
                }
            }
        </style>
    @endpush

@endsection
