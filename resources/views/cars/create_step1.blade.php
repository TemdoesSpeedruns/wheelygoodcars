@extends('layouts.app')

@section('content')
<div class="license-plate-wrapper">

    <form method="POST" action="{{ route('cars.create') }}" class="license-plate">
        @csrf

        <div class="license-country">NL</div>

        <input
            type="text"
            name="license_plate"
            class="license-input"
            placeholder="1-ABC-23"
        >

        <button class="license-button">Go!</button>
    </form>

</div>
@endsection
