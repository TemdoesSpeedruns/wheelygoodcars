@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">Alle auto's</h1>

    <div class="row">

        @foreach ($cars as $car)
            <div class="col-md-4 mb-3">

                <div class="card shadow-sm p-3">

                    <h5>{{ $car->brand }} {{ $car->model }}</h5>

                    <p><strong>Kenteken:</strong> {{ $car->license_plate }}</p>
                    <p><strong>Kilometerstand:</strong> {{ $car->mileage }}</p>
                    <p><strong>Prijs:</strong> €{{ number_format($car->price, 0, ',', '.') }}</p>

                    <a href="{{ route('cars.show', $car->id) ?? '#' }}"
                       class="btn btn-success btn-sm">
                        Bekijken
                    </a>

                </div>

            </div>
        @endforeach

    </div>

</div>
@endsection