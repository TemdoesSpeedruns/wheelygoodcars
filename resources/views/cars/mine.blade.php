@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">Mijn auto's</h1>

    <table class="table table-striped table-bordered align-middle">

        <thead class="table-dark">
            <tr>
                <th>Kenteken</th>
                <th>Merk</th>
                <th>Model</th>
                <th>Kilometerstand</th>
                <th>Prijs</th>
                <th>Tags</th>
                <th>Status</th>
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

                    <td>
                        <div id="price-display-{{ $car->id }}">
                            €{{ number_format($car->price, 0, ',', '.') }}

                            <button type="button"
                                    class="btn btn-sm btn-link p-0 ms-2"
                                    onclick="togglePriceEdit({{ $car->id }})">
                                wijzigen
                            </button>
                        </div>

                        <form method="POST"
                              action="{{ route('cars.updatePrice', $car->id) }}"
                              class="d-none mt-2"
                              id="price-edit-{{ $car->id }}">

                            @csrf

                            <div class="d-flex gap-1">

                                <input type="number"
                                       name="price"
                                       value="{{ $car->price }}"
                                       step="0.01"
                                       class="form-control form-control-sm"
                                       style="max-width: 120px;">

                                <button class="btn btn-sm btn-outline-secondary">
                                    Save
                                </button>

                                <button type="button"
                                        class="btn btn-sm btn-light"
                                        onclick="togglePriceEdit({{ $car->id }})">
                                    x
                                </button>

                            </div>

                        </form>
                    </td>

                    <td>
                        @foreach($car->tags as $tag)
                            <span class="badge bg-{{ $tag->color ?? 'secondary' }}">
                                {{ $tag->name }}
                            </span>
                        @endforeach

                        <a href="{{ route('cars.edit', $car->id) }}"
                           class="btn btn-sm btn-link d-block p-0 mt-1">
                            tags aanpassen
                        </a>
                    </td>

                    <td>
                        <form method="POST"
                              action="{{ route('cars.toggleSold', $car->id) }}">
                            @csrf

                            <button class="btn btn-sm {{ $car->sold_at ? 'btn-success' : 'btn-warning' }}">
                                {{ $car->sold_at ? 'Verkocht' : 'Te koop' }}
                            </button>

                        </form>
                    </td>

                    <td class="d-flex gap-2">

                        <a href="{{ route('cars.pdf', $car->id) }}"
                           class="btn btn-primary btn-sm">
                            PDF
                        </a>

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

<script>
function togglePriceEdit(id) {
    document.getElementById('price-display-' + id).classList.toggle('d-none');
    document.getElementById('price-edit-' + id).classList.toggle('d-none');
}
</script>

@endsection