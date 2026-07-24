@extends('layouts.trainer-layout')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header bg-primary text-white">
            <h4>Member Progress Chart</h4>
        </div>

        <div class="card-body">

            <canvas id="progressChart" height="100"></canvas>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = @json($dates);

const weightData = @json($weights);

const bmiData = @json($bmis);

new Chart(document.getElementById('progressChart'), {

    type: 'line',

    data: {

        labels: labels,

        datasets: [

            {
                label: 'Weight (Kg)',
                data: weightData,
                borderColor: 'blue',
                backgroundColor: 'transparent',
                tension: 0.3
            },

            {
                label: 'BMI',
                data: bmiData,
                borderColor: 'green',
                backgroundColor: 'transparent',
                tension: 0.3
            }

        ]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                position: 'top'

            }

        }

    }

});

</script>

@endsection