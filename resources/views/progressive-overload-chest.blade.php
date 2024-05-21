<!-- resources/views/progressive-overload.blade.php -->

@extends('main.main')

@section('container')
<div class="container mt-5">
    <h1>Progressive Overload - Chest</h1>
    <canvas id="progressiveOverloadChart" width="200" height="50"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('progressiveOverloadChart').getContext('2d');
        const data = {
            labels: ['Last Week', 'This Week'],
            datasets: [{
                label: 'Total Weight Lifted (kg)',
                data: [{{ $lastWeekData }}, {{ $thisWeekData }}],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        new Chart(ctx, config);
    });
</script>
@endsection
