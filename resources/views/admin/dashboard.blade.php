@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Admin Dashboard</h1>

    <div class="row mt-4">

        <div class="col-md-4">
            <div class="card p-3">
                <h4>Totaal auto's</h4>
                <p>{{ $totalCars }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h4>Totaal users</h4>
                <p>{{ $totalUsers }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h4>Totaal tags</h4>
                <p>{{ $totalTags }}</p>
            </div>
        </div>

    </div>

    <a href="{{ route('admin.tags.stats') }}" class="btn btn-primary mt-4">
        Bekijk tag statistieken
    </a>

</div>
@endsection