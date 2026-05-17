@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">{{ $car->brand }} {{ $car->model }}</h1>

    <div class="card p-3 shadow-sm">

        <p><strong>Kenteken:</strong> {{ $car->license_plate }}</p>
        <p><strong>Merk:</strong> {{ $car->brand }}</p>
        <p><strong>Model:</strong> {{ $car->model }}</p>
        <p><strong>Kilometerstand:</strong> {{ $car->mileage }}</p>
        <p><strong>Prijs:</strong> €{{ number_format($car->price, 0, ',', '.') }}</p>

        @if($car->color)
            <p><strong>Kleur:</strong> {{ $car->color }}</p>
        @endif

        @if($car->production_year)
            <p><strong>Bouwjaar:</strong> {{ $car->production_year }}</p>
        @endif

        <a href="{{ route('cars.pdf', $car->id) }}" class="btn btn-primary mt-3">
            Download PDF
        </a>

    </div>

</div>
@endsection