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

    <form method="POST"
          action="{{ route('cars.store') }}"
          enctype="multipart/form-data">
        @csrf

        <input type="hidden"
               name="license_plate"
               value="{{ old('license_plate', $license_plate) }}">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <input
            type="text"
            name="brand"
            placeholder="Merk"
            value="{{ old('brand', $rdw['merk'] ?? '') }}"
            class="track-progress"
            required
        >

        <input
            type="text"
            name="model"
            placeholder="Model"
            value="{{ old('model', $rdw['handelsbenaming'] ?? '') }}"
            class="track-progress"
            required
        >

        <input
            type="number"
            name="mileage"
            placeholder="Kilometerstand"
            value="{{ old('mileage') }}"
            class="track-progress"
            required
        >

        <input
            type="number"
            name="price"
            placeholder="Vraagprijs"
            step="0.01"
            value="{{ old('price') }}"
            class="track-progress"
            required
        >

        <input
            type="number"
            name="production_year"
            placeholder="Bouwjaar"
            value="{{ old('production_year', $rdw['bouwjaar'] ?? '') }}"
            class="track-progress"
        >

        <input
            type="text"
            name="color"
            placeholder="Kleur"
            value="{{ old('color', $rdw['kleur'] ?? '') }}"
            class="track-progress"
        >

        <hr>

        {{-- IMAGE --}}
        <h5>Afbeelding</h5>
        <input type="file" name="image" accept="image/*" class="track-progress">

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
                            {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
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