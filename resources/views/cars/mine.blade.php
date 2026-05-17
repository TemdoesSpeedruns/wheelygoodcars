@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">Mijn auto's</h1>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Kenteken</th>
                <th>Merk</th>
                <th>Model</th>
                <th>Kilometerstand</th>
                <th>Prijs</th>
                <th>Acties</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($cars as $car)
                <tr>
                    <td>{{ $car->license_plate }}</td>
                    <td>{{ $car->brand }}</td>
                    <td>{{ $car->model }}</td>
                    <td>{{ $car->mileage }}</td>
                    <td>€{{ number_format($car->price, 0, ',', '.') }}</td>

                    <td class="d-flex gap-2">

                        {{-- PDF --}}
                        <a href="{{ route('cars.pdf', $car->id) }}"
                           class="btn btn-primary btn-sm">
                            PDF
                        </a>

                        {{-- DELETE --}}
                        <form action="{{ route('cars.destroy', $car) }}"
                              method="POST"
                              onsubmit="return confirm('Weet je het zeker?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm">
                                Verwijderen
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection