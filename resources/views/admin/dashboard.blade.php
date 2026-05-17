@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Admin Dashboard</h1>

    <meta http-equiv="refresh" content="10">

    <div class="row mt-4">

        <div class="col-md-4">
            <div class="card p-3">
                <h4>Totaal auto's</h4>
                <p>{{ $totalCars }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h4>Totaal users</h4>
                <p>{{ $totalUsers }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h4>Totaal tags</h4>
                <p>{{ $totalTags }}</p>
            </div>
        </div>

    </div>

    <div class="row mt-4">

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Verkocht</h5>
                <p>{{ $carsSold }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Vandaag toegevoegd</h5>
                <p>{{ $carsToday }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Views vandaag</h5>
                <p>{{ $viewsToday }}</p>
            </div>
        </div>

    </div>

    {{-- GEMIDDELDE --}}
    <div class="row mt-4">

        <div class="col-md-12">
            <div class="card p-3 text-center">
                <h5>Gemiddeld aantal auto's per aanbieder</h5>
                <h2>{{ number_format($avgCarsPerUser, 2) }}</h2>
            </div>
        </div>

    </div>

    <div class="mt-4">

        @php
            $percent = $totalCars > 0 ? ($carsSold / $totalCars) * 100 : 0;
        @endphp

        <h5>Verkocht ratio</h5>

        <div class="progress">
            <div class="progress-bar" style="width: {{ $percent }}%"></div>
        </div>

        <small>{{ number_format($percent, 1) }}%</small>

    </div>

    <div class="mt-4">

        <a href="{{ route('admin.tags.stats') }}" class="btn btn-primary">
            Tag statistieken
        </a>

        <a href="{{ route('admin.suspicious.users') }}" class="btn btn-danger">
            Opvallende aanbieders
        </a>

    </div>

    {{-- CHART --}}
    <div class="mt-4 d-flex justify-content-center">
        <div style="width: 320px; height: 320px;">
            <canvas id="carsChart"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('carsChart');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Totaal', 'Verkocht'],
        datasets: [{
            data: [{{ $totalCars }}, {{ $carsSold }}]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

@endsection