@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">Alle auto's</h1>

    <div class="row g-3">

        @foreach ($cars as $car)

            <div class="col-md-{{ isset($featuredId) && $car->id == $featuredId ? '8' : '4' }} mb-3">

                <div class="card shadow-sm p-3 h-100
                    {{ isset($featuredId) && $car->id == $featuredId ? 'border border-warning' : '' }}">

                    <h5>
                        {{ $car->brand }} {{ $car->model }}

                        @if(isset($featuredId) && $car->id == $featuredId)
                            <span class="badge bg-warning text-dark ms-2">
                                Uitgelicht
                            </span>
                        @endif
                    </h5>

                    <p><strong>Kenteken:</strong> {{ $car->license_plate }}</p>
                    <p><strong>Kilometerstand:</strong> {{ $car->mileage }}</p>
                    <p><strong>Prijs:</strong> €{{ number_format($car->price, 0, ',', '.') }}</p>

                    <a href="{{ route('cars.show', $car->id) }}"
                       class="btn btn-success btn-sm">
                        Bekijken
                    </a>

                </div>

            </div>

        @endforeach

    </div>

</div>
@endsection