@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">Alle auto's</h1>

    <form method="GET" action="{{ route('cars.index') }}" class="mb-4">

        <div class="input-group mb-2">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Zoek op merk of model">

            <button class="btn btn-primary">
                Zoeken
            </button>

            @if(request('search') || request('tag'))
                <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary">
                    Reset
                </a>
            @endif

        </div>

        <div class="row">

            <div class="col-md-4">

                <select name="tag" class="form-select" onchange="this.form.submit()">

                    <option value="">Alle tags</option>

                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}"
                            {{ request('tag') == $tag->id ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach

                </select>

            </div>

        </div>

    </form>

    <div class="row g-3">

        @forelse ($cars as $car)

            <div class="col-md-4">

                <div class="card shadow-sm p-3 h-100">

                    <h5>{{ $car->brand }} {{ $car->model }}</h5>

                    <p><strong>Kenteken:</strong> {{ $car->license_plate }}</p>
                    <p><strong>Kilometerstand:</strong> {{ $car->mileage }}</p>
                    <p><strong>Prijs:</strong> €{{ number_format($car->price, 0, ',', '.') }}</p>

                    {{-- TAGS --}}
                    <div class="mb-2">
                        @foreach($car->tags as $tag)
                            <span class="badge bg-{{ $tag->color ?? 'secondary' }} me-1">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>

                    <a href="{{ route('cars.show', $car->id) }}"
                       class="btn btn-success btn-sm">
                        Bekijken
                    </a>

                </div>

            </div>

        @empty

            <p class="text-muted">
                Geen auto's gevonden.
            </p>

        @endforelse

    </div>

    <div class="mt-4">
        {{ $cars->links() }}
    </div>

</div>
@endsection