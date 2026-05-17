@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-2">
        {{ $car->brand }} {{ $car->model }}
    </h1>

    <p class="text-muted">
        Deze auto is {{ $car->views }} keer bekeken.
    </p>

    <div class="card p-3 shadow-sm">

        <p><strong>Kenteken:</strong> {{ $car->license_plate }}</p>
        <p><strong>Merk:</strong> {{ $car->brand }}</p>
        <p><strong>Model:</strong> {{ $car->model }}</p>
        <p><strong>Kilometerstand:</strong> {{ $car->mileage }}</p>
        <p><strong>Prijs:</strong> €{{ number_format($car->price, 0, ',', '.') }}</p>

        @if($car->color)
            <p><strong>Kleur:</strong> {{ $car->color }}</p>
        @endif

        @if($car->production_year)
            <p><strong>Bouwjaar:</strong> {{ $car->production_year }}</p>
        @endif

        <a href="{{ route('cars.pdf', $car->id) }}" class="btn btn-primary mt-3">
            Download PDF
        </a>

    </div>

</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="viewsToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Populair aanbod</strong>
            <small>nu</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
         Deze auto is vandaag {{ $viewsToday }} keer bekeken. {{ $car->views }} totaal views.
        </div>      
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        const toastEl = document.getElementById('viewsToast');
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }, 10000);
});
</script>

@endsection