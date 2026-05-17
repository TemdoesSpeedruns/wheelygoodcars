@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="mx-auto" style="max-width: 700px;">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="fw-semibold">Stap 1 van 2</span>
            <span class="text-muted">0%</span>
        </div>

        <div class="progress mb-5">
            <div class="progress-bar"
                 role="progressbar"
                 style="width: 0%">
            </div>
        </div>

        <div class="license-plate-wrapper">

            <form method="POST"
                  action="{{ route('cars.create') }}"
                  class="license-plate">

                @csrf

                <div class="license-country">
                    NL
                </div>

                <input
                    type="text"
                    name="license_plate"
                    class="license-input"
                    placeholder="1-ABC-23"
                >

                <button class="license-button">
                    Go!
                </button>

            </form>

        </div>

    </div>

</div>
@endsection