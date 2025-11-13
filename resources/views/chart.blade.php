<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chart - {{ config('app.name', 'CarbonAI') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @php
        $assets = \App\Helpers\AssetHelper::getViteAssets();
    @endphp
    @if($assets['css'] && $assets['js'])
        <link rel="stylesheet" href="{{ $assets['css'] }}">
        <script src="{{ $assets['js'] }}"></script>
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link rel="stylesheet" href="{{ app()->environment('production') ? secure_asset('css/style.css') : asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ app()->environment('production') ? secure_asset('css/chart.css') : asset('css/chart.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
@php
    // Load the dummy data
    $jsonData = json_decode(file_get_contents(base_path('dummy_dashboard_data.json')), true);

    // 1.Extract Emissions by scope data
    $emissionsByScope = $jsonData['emissions_by_scope'];
    $scope1 = $emissionsByScope['scope1_tco2e'];
    $scope2 = $emissionsByScope['scope2_tco2e'];
    $scope3 = $emissionsByScope['scope3_tco2e'];
    $totalEmissions = $emissionsByScope['total_tco2e'];
    $scope1Pct = $emissionsByScope['scope1_pct'];
    $scope2Pct = $emissionsByScope['scope2_pct'];
    $scope3Pct = $emissionsByScope['scope3_pct'];

    // 2.Extract Emissions by Category data
    $emissionsByCategory = $jsonData['emissions_by_category'];

    // Extract Top Emitting Sources data
    $topEmittingSources = $jsonData['top_emitting_sources'];

    // 3.Extract Trend vs Target data
    $data = $jsonData['trend_vs_target'];
    $currentYear = $data['current_year'];
    $years = $data['years'];

    // Extract data for 2023 and 2024
    $baseline2023 = null;
    $target2024 = null;
    $actual2024 = null;
    $targetReductionPct = null;
    $actualVsTargetPct = null;
    $performanceStatus = null;

    foreach ($years as $year) {
        if ($year['year'] == 2023) {
            $baseline2023 = $year['baseline_tco2e'];
        }
        if ($year['year'] == 2024) {
            $target2024 = $year['target_tco2e'];
            $actual2024 = $year['actual_tco2e'];
            $targetReductionPct = $year['target_reduction_pct'];
            $actualVsTargetPct = $year['actual_vs_target_pct'];
            $performanceStatus = $year['performance_status'];
        }
    }
@endphp

<div class="chart-container">
    <div class="px8 py-6">
        <div class="row">
            <!-- Card 1: Emissions by Scope -->
            <div class="col-12 col-md-6">
                <div class="card chart-card">
                    <div class="chart-header">
                        <h1 class="chart-title">Emissions by Scope</h1>
                        <p class="highlight">Contribution from Scope 1, 2, and 3</p>
                    </div>

                    <div class="scope-chart-wrapper">
                        <div class="scope-chart-container">
                            <canvas id="scopeChart"></canvas>
                            <div class="scope-chart-center">
                                <div class="scope-total-value">{{ number_format($totalEmissions, 1) }}</div>
                                <div class="scope-total-unit">tCO₂e</div>
                            </div>
                        </div>
                        <div class="scope-legend">
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #3b82f6;"></div>
                                <div class="legend-content">
                                    <div class="legend-label">Scope 1</div>
                                    <div class="legend-value">{{ number_format($scope1, 2) }} tCO₂e ({{ number_format($scope1Pct, 1) }}%)</div>
                                </div>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #06b6d4;"></div>
                                <div class="legend-content">
                                    <div class="legend-label">Scope 2</div>
                                    <div class="legend-value">{{ number_format($scope2, 2) }} tCO₂e ({{ number_format($scope2Pct, 1) }}%)</div>
                                </div>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #10b981;"></div>
                                <div class="legend-content">
                                    <div class="legend-label">Scope 3</div>
                                    <div class="legend-value">{{ number_format($scope3, 2) }} tCO₂e ({{ number_format($scope3Pct, 1) }}%)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Trend vs Target Chart -->
            <div class="col-12 col-md-6">
                <div class="card chart-card">
                    <div class="chart-header">
                        <h1 class="chart-title">Trend vs Target</h1>
                        <p class="highlight">Annual performance against baseline and reduction target</p>
                        <p class="chart-subtitle">2024 performance {{ $performanceStatus === 'above target' ? 'slightly above target' : $performanceStatus }}</p>
                    </div>

                    <div class="chart-wrapper">
                        <div class="chart-container-inner">
                            <canvas id="trendChart"></canvas>
                        </div>
                        <div class="chart-labels">
                            <div class="bar-group">
                                <div class="bar-label">2023 Baseline</div>
                                <div class="bar-value">{{ number_format($baseline2023, 1) }} tCO₂e</div>
                            </div>
                            <div class="bar-group">
                                <div class="bar-label">2024 Target</div>
                                <div class="bar-value">{{ number_format($target2024, 1) }} tCO₂e</div>
                                <div class="bar-metric">{{ number_format($targetReductionPct, 1) }}% vs baseline</div>
                            </div>
                            <div class="bar-group">
                                <div class="bar-label">2024 Actual</div>
                                <div class="bar-value">{{ number_format($actual2024, 1) }} tCO₂e</div>
                                <div class="bar-metric">{{ $actualVsTargetPct > 0 ? '+' : '' }}{{ number_format($actualVsTargetPct, 1) }}% vs target</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Emissions by Category -->
            <div class="col-12 col-md-6">
                <div class="card chart-card">
                    <div class="chart-header">
                        <h1 class="chart-title">Emissions by Category</h1>
                        <p class="highlight">Combined top 8 categories across all scopes</p>
                    </div>

                    <div class="category-chart-wrapper">
                        <canvas id="categoryChart"></canvas>
                        <div class="category-labels">
                            @foreach($emissionsByCategory as $category)
                            <div class="category-group">
                                <div class="category-label">{{ strlen($category['category_name']) > 8 ? substr($category['category_name'], 0, 8) . '...' : $category['category_name'] }}</div>
                                <div class="category-value">{{ number_format($category['tco2e'], 1) }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Top Emitting Sources -->
            <div class="col-12 col-md-6">
                <div class="card chart-card">
                    <div class="chart-header">
                        <h1 class="chart-title">Top Emitting Sources</h1>
                        <p class="highlight">Top 10 emitters across all scopes</p>
                    </div>

                    <div class="sources-chart-wrapper">
                        <canvas id="sourcesChart"></canvas>
                        <div class="sources-labels">
                            @foreach($topEmittingSources as $source)
                            <div class="source-group">
                                <div class="source-label">{{ strlen($source['source_name']) > 8 ? substr($source['source_name'], 0, 8) . '...' : $source['source_name'] }}</div>
                                <div class="source-value">{{ number_format($source['tco2e'], 1) }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// 1.Emissions by Scope Donut Chart
const scopeCtx = document.getElementById('scopeChart');
const scope1Value = {{ $scope1 }};
const scope2Value = {{ $scope2 }};
const scope3Value = {{ $scope3 }};

new Chart(scopeCtx, {
    type: 'doughnut',
    data: {
        labels: ['Scope 1', 'Scope 2', 'Scope 3'],
        datasets: [{
            data: [scope1Value, scope2Value, scope3Value],
            backgroundColor: [
                '#3b82f6',  // Blue for Scope 1
                '#06b6d4',  // Cyan for Scope 2
                '#10b981'   // Green for Scope 3
            ],
            borderWidth: 0,
            cutout: '60%'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                enabled: true,
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.parsed || 0;
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((value / total) * 100).toFixed(1);
                        return label + ': ' + value.toFixed(2) + ' tCO₂e (' + percentage + '%)';
                    }
                },
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#333',
                borderWidth: 1
            }
        }
    }
});

// 2.Trend vs Target Bar Chart
const ctx = document.getElementById('trendChart');
const baselineValue = {{ $baseline2023 }};
const targetValue = {{ $target2024 }};
const actualValue = {{ $actual2024 }};

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['2023 Baseline', '2024 Target', '2024 Actual'],
        datasets: [
            {
                label: 'tCO₂e',
                data: [baselineValue, targetValue, actualValue],
                backgroundColor: [
                    '#9ca3af',
                    '#14b8a6',
                    '#0d9488'
                ],
                borderColor: [
                    '#9ca3af',
                    '#14b8a6',
                    '#0d9488'
                ],
                borderWidth: 0,
                borderRadius: {
                    topLeft: 5,
                    topRight: 5,
                    bottomLeft: 0,
                    bottomRight: 0
                },
                borderSkipped: false,
                barPercentage: 0.6,
                categoryPercentage: 0.8,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: {
                top: 20,
                bottom: 0,
                left: 20,
                right: 20
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                enabled: true,
                callbacks: {
                    label: function(context) {
                        return context.parsed.y.toFixed(1) + ' tCO₂e';
                    }
                },
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#333',
                borderWidth: 1
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                display: false,
                grid: {
                    display: false
                },
                ticks: {
                    display: false
                }
            },
            x: {
                display: false,
                grid: {
                    display: false
                },
                ticks: {
                    display: false
                }
            }
        }
    }
});

// 3.Emissions by Category Bar Chart
const categoryCtx = document.getElementById('categoryChart');
const categoryData = @json($emissionsByCategory);
const categoryLabels = categoryData.map(item => item.category_name);
const categoryValues = categoryData.map(item => item.tco2e);

new Chart(categoryCtx, {
    type: 'bar',
    data: {
        labels: categoryLabels.map(label => label.length > 8 ? label.substring(0, 8) + '...' : label),
        datasets: [{
            label: 'tCO₂e',
            data: categoryValues,
            backgroundColor: '#14b8a6',
            borderColor: '#14b8a6',
            borderWidth: 0,
            borderRadius: {
                topLeft: 5,
                topRight: 5,
                bottomLeft: 0,
                bottomRight: 0
            },
            borderSkipped: false,
            barPercentage: 0.6,
            categoryPercentage: 0.8,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: {
                top: 20,
                bottom: 0,
                left: 0,
                right: 0
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                enabled: true,
                callbacks: {
                    label: function(context) {
                        return context.parsed.y.toFixed(1) + ' tCO₂e';
                    }
                },
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#333',
                borderWidth: 1
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                display: false,
                grid: {
                    display: false
                },
                ticks: {
                    display: false
                }
            },
            x: {
                display: false,
                grid: {
                    display: false
                },
                ticks: {
                    display: false
                }
            }
        }
    }
});

// 4.Top Emitting Sources Bar Chart
const sourcesCtx = document.getElementById('sourcesChart');
const sourcesData = @json($topEmittingSources);
const sourcesLabels = sourcesData.map(item => item.source_name);
const sourcesValues = sourcesData.map(item => item.tco2e);

new Chart(sourcesCtx, {
    type: 'bar',
    data: {
        labels: sourcesLabels.map(label => label.length > 8 ? label.substring(0, 8) + '...' : label),
        datasets: [{
            label: 'tCO₂e',
            data: sourcesValues,
            backgroundColor: '#14b8a6',
            borderColor: '#14b8a6',
            borderWidth: 0,
            borderRadius: {
                topLeft: 5,
                topRight: 5,
                bottomLeft: 0,
                bottomRight: 0
            },
            borderSkipped: false,
            barPercentage: 0.6,
            categoryPercentage: 0.8,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: {
                top: 20,
                bottom: 0,
                left: 0,
                right: 0
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                enabled: true,
                callbacks: {
                    label: function(context) {
                        return context.parsed.y.toFixed(1) + ' tCO₂e';
                    }
                },
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#333',
                borderWidth: 1
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                display: false,
                grid: {
                    display: false
                },
                ticks: {
                    display: false
                }
            },
            x: {
                display: false,
                grid: {
                    display: false
                },
                ticks: {
                    display: false
                }
            }
        }
    }
});
</script>
</body>
</html>

