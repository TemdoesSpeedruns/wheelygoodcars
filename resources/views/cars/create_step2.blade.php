@extends('layouts.app')

@section('content')
<div class="car-form">

    <h2>Nieuw aanbod</h2>

    <form method="POST" action="{{ route('cars.store') }}">
        @csrf

        <input
            type="hidden"
            name="license_plate"
            value="{{ $license_plate }}"
        >

        <input
            type="text"
            name="make"
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

        <button>Aanbod afronden</button>

    </form>

</div>
@endsection