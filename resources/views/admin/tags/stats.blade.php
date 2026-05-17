@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Tag Statistieken</h1>

    <table class="table table-striped mt-4">

        <thead>
            <tr>
                <th>Tag</th>
                <th>Gebruik totaal</th>
                <th>Niet verkocht</th>
                <th>Verkocht</th>
            </tr>
        </thead>

        <tbody>
        @foreach ($tags as $tag)
            <tr>
                <td>{{ $tag->name }}</td>

                <td>{{ $tag->cars_count }}</td>

                <td>{{ $tag->cars->whereNull('sold_at')->count() }}</td>

                <td>{{ $tag->cars->whereNotNull('sold_at')->count() }}</td>
            </tr>
        @endforeach
        </tbody>

    </table>

</div>
@endsection