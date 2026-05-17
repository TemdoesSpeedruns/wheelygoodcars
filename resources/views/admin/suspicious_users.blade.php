@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Suspicious Users</h1>

    @foreach($flagged as $item)
        <div class="card mb-3 p-3">

            <h4>{{ $item['user']->name }} (score: {{ $item['score'] }})</h4>

            <ul>
                @foreach($item['reasons'] as $reason)
                    <li>{{ $reason }}</li>
                @endforeach
            </ul>

            <form method="POST" action="{{ route('admin.users.ignore', $item['user']->id) }}">
                @csrf
                <button class="btn btn-warning btn-sm">
                    Verwijder uit lijst
                </button>
            </form>

        </div>
    @endforeach

</div>
@endsection