@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Auto aanpassen</h1>

    <form method="POST" action="{{ route('cars.update', $car->id) }}">
        @csrf
        @method('PUT')

        <input type="text" name="brand" value="{{ $car->brand }}">
        <input type="text" name="model" value="{{ $car->model }}">
        <input type="number" name="mileage" value="{{ $car->mileage }}">
        <input type="number" name="price" value="{{ $car->price }}">

        <hr>

        <h5>Tags aanpassen</h5>

        @foreach($tags as $tag)
            <label>
                <input type="checkbox"
                       name="tags[]"
                       value="{{ $tag->id }}"
                       {{ $car->tags->contains($tag->id) ? 'checked' : '' }}>
                {{ $tag->name }}
            </label>
        @endforeach

        <br><br>

        <button class="btn btn-success">Opslaan</button>

    </form>

</div>
@endsection