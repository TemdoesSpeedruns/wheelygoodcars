@extends('layouts.app')

@section('content')
<div class="car-form">

    <h2>Nieuw aanbod - stap 2</h2>

    <form method="POST" action="{{ route('cars.store') }}">
        @csrf

        <input type="hidden" name="license_plate" value="{{ $license_plate }}">

        <input
            type="text"
            name="brand"
            placeholder="Merk"
            value="{{ $rdw['merk'] ?? '' }}"
        >

        <input
            type="text"
            name="model"
            placeholder="Model"
            value="{{ $rdw['handelsbenaming'] ?? '' }}"
        >

        <input
            type="number"
            name="mileage"
            placeholder="Kilometerstand"
        >

        <input
            type="number"
            name="price"
            placeholder="Vraagprijs"
            step="0.01"
        >

        <input
            type="number"
            name="production_year"
            placeholder="Bouwjaar"
            value="{{ $rdw['bouwjaar'] ?? '' }}"
        >

        <input
            type="text"
            name="color"
            placeholder="Kleur"
            value="{{ $rdw['kleur'] ?? '' }}"
        >

        <hr>

        <h5>Tags</h5>

        <div class="tags-box">

            @if(isset($tags) && count($tags))
                @foreach($tags as $tag)
                    <label class="tag-item">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                        <span>{{ $tag->name }}</span>
                    </label>
                @endforeach
            @else
                <p>Geen tags gevonden</p>
            @endif

        </div>

        <br>

        <button type="submit">Aanbod afronden</button>

    </form>

</div>
@endsection