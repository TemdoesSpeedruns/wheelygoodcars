@extends('layouts.app')

@section('content')
<div class="car-form">

    <h2>Nieuw aanbod</h2>

    <form method="POST" action="{{ route('cars.store') }}">
        @csrf

        <input type="hidden" name="license_plate" value="{{ $license_plate }}">

        <input type="text" name="make" placeholder="Merk">
        <input type="text" name="model" placeholder="Model">
        <input type="number" name="mileage" placeholder="Kilometerstand">
        <input type="number" name="price" placeholder="Vraagprijs">

        <button>Aanbod afronden</button>

    </form>

</div>
@endsection
