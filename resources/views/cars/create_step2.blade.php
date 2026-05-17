@extends('layouts.app')

@section('content')
<div class="car-form">

    <h2>Nieuw aanbod - stap 2</h2>

    <div class="progress mb-4">
        <div id="formProgress"
             class="progress-bar progress-bar-striped progress-bar-animated"
             role="progressbar"
             style="width: 0%;">
            0%
        </div>
    </div>

    <form method="POST" action="{{ route('cars.store') }}">
        @csrf

        <input type="hidden"
               name="license_plate"
               value="{{ $license_plate }}">

        <input
            type="text"
            name="brand"
            placeholder="Merk"
            value="{{ $rdw['merk'] ?? '' }}"
            class="track-progress"
        >

        <input
            type="text"
            name="model"
            placeholder="Model"
            value="{{ $rdw['handelsbenaming'] ?? '' }}"
            class="track-progress"
        >

        <input
            type="number"
            name="mileage"
            placeholder="Kilometerstand"
            class="track-progress"
        >

        <input
            type="number"
            name="price"
            placeholder="Vraagprijs"
            step="0.01"
            class="track-progress"
        >

        <input
            type="number"
            name="production_year"
            placeholder="Bouwjaar"
            value="{{ $rdw['bouwjaar'] ?? '' }}"
            class="track-progress"
        >

        <input
            type="text"
            name="color"
            placeholder="Kleur"
            value="{{ $rdw['kleur'] ?? '' }}"
            class="track-progress"
        >

        <hr>

        <h5>Tags</h5>

        <div class="tags-box">

            @if(isset($tags) && count($tags))

                @foreach($tags as $tag)

                    <label class="tag-item">

                        <input
                            type="checkbox"
                            name="tags[]"
                            value="{{ $tag->id }}"
                            class="track-progress"
                        >

                        <span>{{ $tag->name }}</span>

                    </label>

                @endforeach

            @else

                <p>Geen tags gevonden</p>

            @endif

        </div>

        <br>

        <button type="submit">
            Aanbod afronden
        </button>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const fields = document.querySelectorAll('.track-progress');
    const progressBar = document.getElementById('formProgress');

    function updateProgress() {

        let filled = 0;

        fields.forEach(field => {

            if (
                (field.type === 'checkbox' && field.checked) ||
                (field.value && field.value.trim() !== '')
            ) {
                filled++;
            }

        });

        const percentage = Math.round((filled / fields.length) * 100);

        progressBar.style.width = percentage + '%';
        progressBar.innerText = percentage + '%';

    }

    fields.forEach(field => {
        field.addEventListener('input', updateProgress);
        field.addEventListener('change', updateProgress);
    });

    updateProgress();

});
</script>
@endsection