<!-- resources/views/progressive-overload.blade.php -->

@extends('main.main')

@section('container')
<div class="container mt-5">
    <h1>Progressive Overload</h1>
    <div class="container">
        <canvas id="performanceLine"></canvas>
        <div id="performanceLine-legend"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById("performanceLine")) {
            const ctx = document.getElementById('performanceLine').getContext('2d');
            const thisWeekData = @json($thisWeekData);
            const lastWeekData = @json($lastWeekData);

            const muscleGroups = Object.keys(thisWeekData);
            const thisWeekTotals = muscleGroups.map(group => thisWeekData[group].total_weight || 0);
            const lastWeekTotals = muscleGroups.map(group => lastWeekData[group].total_weight || 0);

            const graphGradient = ctx.createLinearGradient(0, 0, 0, 400);
            graphGradient.addColorStop(0, 'rgba(26, 115, 232, 0.5)');
            graphGradient.addColorStop(1, 'rgba(26, 115, 232, 0.1)');

            const graphGradient2 = ctx.createLinearGradient(0, 0, 0, 400);
            graphGradient2.addColorStop(0, 'rgba(0, 208, 255, 0.5)');
            graphGradient2.addColorStop(1, 'rgba(0, 208, 255, 0.1)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: muscleGroups,
                    datasets: [{
                        label: 'This week',
                        data: thisWeekTotals,
                        backgroundColor: graphGradient,
                        borderColor: '#1F3BB3',
                        borderWidth: 1.5,
                        fill: true,
                        pointBorderWidth: 1,
                        pointRadius: 4,
                        pointHoverRadius: 2,
                        pointBackgroundColor: '#1F3BB3',
                        pointBorderColor: '#fff'
                    }, {
                        label: 'Last week',
                        data: lastWeekTotals,
                        backgroundColor: graphGradient2,
                        borderColor: '#52CDFF',
                        borderWidth: 1.5,
                        fill: true,
                        pointBorderWidth: 1,
                        pointRadius: 4,
                        pointHoverRadius: 2,
                        pointBackgroundColor: '#52CDFF',
                        pointBorderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    elements: {
                        line: {
                            tension: 0.4,
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                display: true,
                                color: "#F0F0F0",
                                drawBorder: false,
                            },
                            ticks: {
                                beginAtZero: true,
                                autoSkip: true,
                                maxTicksLimit: 4,
                                color: "#6B778C",
                                font: {
                                    size: 10,
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                autoSkip: true,
                                maxTicksLimit: 7,
                                color: "#6B778C",
                                font: {
                                    size: 10,
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
